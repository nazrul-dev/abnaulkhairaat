<?php

namespace App\Livewire\Pages\Portal;


use App\Models\ChatsAngkatan;


use Livewire\Component;
use Livewire\WithPagination;

class Discussion extends Component
{
    use WithPagination;
    public $limitPerPage = 4;
    public $pesan = '';
    public $public = true;
    public $fangkatan, $ftipe_angkatan;

    public function selectedAngaktan($item)
    {

        if ($item !== 'public') {
            $this->public = false;
            $this->fangkatan = $item['angkatan'];
            $this->ftipe_angkatan = $item['tipe_angkatan'];
        } else {
            $this->public = true;
            $this->fangkatan = null;
            $this->ftipe_angkatan = null;
        }
    }



    protected $listeners = [
        'loadmore' => 'loadmore'
    ];

    public function loadmore()
    {
        $this->limitPerPage = $this->limitPerPage + 1;
    }
    public function send()
    {
        $this->validate([
            'pesan' => 'required'
        ]);
        ChatsAngkatan::create([
            'user_id' =>  auth()->user()->id,
            'pesan' => $this->pesan,
            'angkatan' => $this->fangkatan,
            'tipe_angkatan' => $this->ftipe_angkatan
        ]);
        $this->reset('pesan');
        // $a= User::whereHas('angkatanUsers', function ($query) {
        //     return $query->where('angkatan', $this->fangkatan)->where(
        //         'tipe_angkatan',
        //         $this->ftipe_angkatan
        //     )->whereNot('user_id', auth()->id());
        // })->get();
        // $di = [];
        // foreach($a as $b){
        //     array_push($di, [
        //         'angkatan' => $this->fangkatan,
        //         'tipe_angkatan' => $this->ftipe_angkatan,
        //         'chats_angkatan_id'=>$chatID->id ,
        //         'user_id'=> $b->id,

        //     ]);
        // }
        // ChatRead::insert($di);


    }
    public function render()
    {

        // $this->dispatch('loadmore');

        $user = auth()->user();
        $angkatan = auth()->user()->angkatanUsers;
        $chats = ChatsAngkatan::where(function ($query) {
            if (!$this->public) {
                $query->where('angkatan', $this->fangkatan);
                $query->where('tipe_angkatan', $this->ftipe_angkatan);
            } else {
                $query->whereNull('angkatan');
                $query->whereNull('tipe_angkatan');
            }
        })
            ->orderBy('created_at', 'desc')->paginate($this->limitPerPage);

            if($chats->count() < $chats->total()){
                $this->dispatch('loadmore');
            }
        return view('livewire.pages.portal.discussion', compact('user', 'angkatan', 'chats'));
    }
}
