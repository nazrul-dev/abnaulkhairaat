<?php

namespace App\Livewire\Pages\Payments;

use App\Models\Donation;
use App\Models\Event;
use App\Models\Transaksi;
use Livewire\Component;
use Nekoding\Tripay\Networks\HttpClient;
use Nekoding\Tripay\Tripay;

class Checkout extends Component
{
    public $res;
    public $open = 0;
    public $dataDonation;
    public function mount(Transaksi $transaksi)
    {

        $tripay = new Tripay(new HttpClient(config("tripay.tripay_api_key")));
        $res = $tripay->getDetailTransaction($transaksi->reference);
        $responseJson = $res->getResponse();


        $responseArray = json_decode($responseJson, true);

        if ($responseArray['success']) {
            if ($transaksi->tipe_donasi === 'event') {
                $this->dataDonation = Event::find($transaksi->relation_id);
            } else {
                $this->dataDonation = Donation::find($transaksi->relation_id);
            }
            $this->res =  [
                'transaksi' => $transaksi,
                'tripay' => $responseArray['data']
            ];
        }
    }

    public function changeOpen($num)
    {
        $this->open = $num;
    }
    public function render()
    {
        $data = $this->res;
        return view('livewire.pages.payments.checkout', compact('data'));
    }
}
