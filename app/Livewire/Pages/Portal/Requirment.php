<?php

namespace App\Livewire\Pages\Portal;

use App\Models\AngkatanUser;
use App\Models\Biodata;
use Auth;
use Livewire\Attributes\Rule;
use Livewire\Component;


class Requirment extends Component
{
    public $modal = true;
    public $step = 1;
    public $payloads = [];
    public $countType = 0;
    public $type = [
        'mi' => false,
        'mts' => false,
        'ma' => false
    ];
    #[Rule([

        'fieldsType' => 'required',
        'fieldsType.*.angkatan' => [
            'required',  'numeric', 'min:4',
        ],

        'fieldsType.*.tahun_kelulusan' => [
            'required', 'numeric', 'min:4',
        ],

    ], message: [
        'required' => 'The Input is missing.',
        'numeric' => 'The Input please number.',
        'min' => 'The Input is too short.',
    ],)]
    public $fieldsType = [];

    public $fields = [
        'phone' => '',
        'phone_wa' => '',
        'status_hubungan' => 'Lajang',
        'current_address' => '',
        'district' => '',
        'pekerjaan' => '',
    ];

    public function mount(){
        if(auth()->user()->isbiodata){
            return $this->redirect('/', navigate: true);
        }
    }
    public function updatedType($arr)
    {
        $count = 0;
        foreach ($this->type as $value) {
            if ($value === true) {
                $count++;
            }
        }
        $this->countType = $count;

    }

    public function nextStep()
    {


        $this->validate([
            'fields' => 'required',
             'fields.*' => ['required'],
             'fields.current_address' => 'nullable'
            ]);
        $location = \Indonesia::findDistrict($this->fields['district'], $with = ['province', 'city']);

        try {
            $payloads = [
                'biodata' => [
                    ...$this->fields,
                    'city' => $location->city->id,
                    'province' => $location->province->id,
                    'district' => $this->fields['district'],
                    'user_id' => auth()->user()->id
                ]
            ];
            $this->payloads = $payloads;
            $this->step = 2;
        } catch (\Throwable $th) {
            $this->step = 1;
        }
    }
    public function save()
    {
        $this->validate();
        try {
            Auth::user()->update([
                'isbiodata' => true,
            ]);

            Biodata::create($this->payloads['biodata']);

            foreach ($this->fieldsType as $k => $item) {
                AngkatanUser::create([
                    'user_id' => auth()->user()->id,
                    'tipe_angkatan' => $k,
                    'tahun_kelulusan' => $item['tahun_kelulusan'],
                    'angkatan' => $item['angkatan']
                ]);
            }
            return $this->redirect('/', navigate: true);
        } catch (\Throwable $th) {
            $this->step = 2;
        }
    }
    public function render()
    {
        return view('livewire.pages.portal.requirment');
    }
}
