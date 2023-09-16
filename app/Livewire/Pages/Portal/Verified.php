<?php

namespace App\Livewire\Pages\Portal;


use Livewire\Component;
use WireUi\Traits\Actions;

class Verified extends Component
{
    use Actions;
    public $modal = true;

    public function mount(){
        if(auth()->user()->email_verified_at){
            return $this->redirect('/dashboard', navigate: true);
        }
    }
    public function send(){
       try {
        $user = auth()->user();
        $user->sendEmailVerificationNotification();
        $this->notification([
            'title'       => 'Success',
            'description' => 'Kode Link Berhasil dikirim , Silahkan Cek lagi email anda ',
            'icon'        => 'success'
        ]);
       } catch (\Throwable $th) {
        //throw $th;
       }
    }
    public function render()
    {
        if($auth->user()->email_verified_at){
            return $this->redirect('/dashboard',navigate:true);
        }
        
        return view('livewire.pages.portal.verified');
    }
}
