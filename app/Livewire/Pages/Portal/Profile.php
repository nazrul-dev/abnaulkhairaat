<?php

namespace App\Livewire\Pages\Portal;

use Illuminate\Validation\Rules;
use Hash;
use Illuminate\Database\QueryException;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use WireUi\Traits\Actions;

class Profile extends Component
{
    use WithFileUploads, Actions;
    public $modal = true;

    public $payloads = [];
    public $countType = 0;
    public $pic;
    public $piOld;
    public $password = '', $password_confirmation;
    public $fields = [
        'name' => '',
        'phone' => '',
        'phone_wa' => '',
        'status_hubungan' => 'Lajang',
        'current_address' => '',
        'district' => '',
        'pekerjaan' => '',
    ];
    public function mount()
    {
        $user = auth()->user();
        $this->fields = [
            'name' => $user->name,
            'phone' => $user->biodata->phone,
            'phone_wa' => $user->biodata->phone_wa,
            'status_hubungan' => $user->biodata->status_hubungan,
            'current_address' => $user->biodata->current_address,
            'district' => $user->biodata->district,
            'pekerjaan' => $user->biodata->pekerjaan,

        ];

        $this->piOld = $user->avatar;
    }

    public function save()
    {

        $filepath = null;
        if ($this->pic) {
            $filepath = $this->pic->store('avatars');
        }



        if ($this->password) {

            $this->validate(
                [
                    'fields' => 'required',
                    'fields.*' => ['required'],
                    'fields.phone_wa' => ['nullable'],
                    'password' => ['required', 'confirmed', Rules\Password::defaults()],
                    'pic' => ['nullable', 'image']
                ]
            );
        } else {
            $this->validate([
                'fields' => 'required',
                'fields.*' => ['required'],
                'fields.phone_wa' => ['nullable'],
                'pic' => ['nullable', 'image']
            ]);
        }


        $location = \Indonesia::findDistrict($this->fields['district'], $with = ['province', 'city']);

        try {
            if ($this->password) {
                auth()->user()->update([
                    'name' => $this->fields['name'],
                    'password' => Hash::make($this->password),
                    'avatar' => $this->pic ? $filepath :  $this->piOld
                ]);
            } else {
                auth()->user()->update([
                    'name' => $this->fields['name'],
                    'avatar' => $this->pic ? $filepath :  $this->piOld
                ]);
            }


            auth()->user()->biodata->update([
                ...$this->fields,
                'city' => $location->city->id,
                'province' => $location->province->id,
                'district' => $this->fields['district'],

            ]);

            $this->notification([
                'title'       => 'Success',
                'description' => 'Berhasil Update Profile ',
                'icon'        => 'success'
            ]);
        } catch (QueryException $th) {
            $this->notification([
                'title'       => 'Error',
                'description' => 'Gagal Update Profile ',
                'icon'        => 'error'
            ]);
        }
    }
    public function render()
    {
        return view('livewire.pages.portal.profile');
    }
}
