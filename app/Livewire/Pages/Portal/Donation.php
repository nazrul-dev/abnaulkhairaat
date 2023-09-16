<?php

namespace App\Livewire\Pages\Portal;

use App\Models\Donation as ModelsDonation;
use App\Models\Transaksi;
use App\Models\Event;

use Livewire\Component;

use App\Models\Event as ModelsEvent;
use Illuminate\Database\QueryException;
use WireUi\Traits\Actions;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nekoding\Tripay\Networks\HttpClient;
use Nekoding\Tripay\Tripay;
use Nekoding\Tripay\Signature;

class Donation extends Component
{
    use Actions, WithPagination;
    public $limitPerPage = 4;
    public $channelPembayaran = [];
    public $donationAmount = 0;
    public $channelSelected;
    public $modalDonationShow = false;
    public $modalDetailShow = false;
    public $detailData = [];


    protected $listeners = [
        'loadmore' => 'loadmore'
    ];

    public function loadmore()
    {
        $this->limitPerPage = $this->limitPerPage + 10;
    }

    public function addDonation()
    {

        if (!count($this->channelPembayaran)) {
            $tripay = new Tripay(new HttpClient(config("tripay.tripay_api_key")));
            $channelpembayaran = $tripay->getChannelPembayaran();
            $this->channelPembayaran = $channelpembayaran['data'];
        }

        $this->handlerModalDonation();
    }

    public function selectedChannel($channel)
    {
        $this->channelSelected =   $this->channelPembayaran[$channel];
    }


    public function checkout()
    {

        $this->validate([
            'donationAmount' => 'required|min:5'
        ]);

        if ($this->donationAmount < 50000) {
            return    $this->notification([
                'title'       => 'Gagal',
                'description' => 'Minimal Donasi Rp 50,000',
                'icon'        => 'error'
            ]);
        }

        try {
            $user = auth()->user();
            $merchantReff = 'DT-' . time();
            $data = [
                'method'         =>  $this->channelSelected['code'],
                'merchant_ref'   => $merchantReff,
                'amount'         => $this->donationAmount,
                'customer_name'  => $user->name,
                'customer_email' => $user->email,
                'customer_phone' => $user->biodata->phone ?? '',
                'order_items'    => [
                    [
                        'name'        => 'Donasi',
                        'price'       => $this->donationAmount,
                        'quantity'    => 1,

                    ]
                ],
                // 'return_url'   => 'https://domainanda.com/redirect',
                'expired_time' => (time() + (6 * 60 * 60)), // 24 jam
                'signature'    => Signature::generate($merchantReff . $this->donationAmount)
            ];

            $tripay = new Tripay(new HttpClient(config("tripay.tripay_api_key")));
            $res = $tripay->createTransaction($data);
            $responseJson = $res->getResponse();
            $responseArray = json_decode($responseJson, true);

            if ($responseArray['success']) {
                $transaksi = Transaksi::create([
                    'tipe_donasi' => 'donasi',

                    'jumlah_donasi' => $this->donationAmount,
                    'biaya_admin' =>  $responseArray['data']['total_fee'],
                    'total_donasi' =>  $responseArray['data']['amount_received'],
                    'merchant_ref' =>  $responseArray['data']['merchant_ref'],
                    'expired_time' =>  $responseArray['data']['expired_time'],
                    'status' =>  $responseArray['data']['status'] ?? null,
                    'qr_url' => $responseArray['data']['qr_url'] ?? null,
                    'reference' =>  $responseArray['data']['reference'],
                    'payment_method' =>  $responseArray['data']['payment_method'],
                    'payment_name' =>  $responseArray['data']['payment_name'],
                    'pay_code' =>  $responseArray['data']['pay_code'] ?? $responseArray['data']['qr_url'],
                    'user_id' =>  $user->id,
                ]);
                $this->handlerModalDonation();
                return $this->redirect(route('payments.checkout', $transaksi->merchant_ref), navigate: true);
            } else {
                $this->handlerModalDonation();
                return    $this->notification([
                    'title'       => 'Gagal',
                    'description' => 'Gagal Melakukan Checkout , coba lagi',
                    'icon'        => 'error'
                ]);
            }
        } catch (QueryException $th) {

            $this->handlerModalDonation();
            return    $this->notification([
                'title'       => 'Gagal',
                'description' => 'Gagal Melakukan Checkout , coba lagi',
                'icon'        => 'error'
            ]);
        }
    }


    public function handlerModalDonation()
    {

        $this->modalDonationShow = !$this->modalDonationShow;
    }

    public function handlerDetail($detail)
    {
        $res = $detail;


        if ($detail && $detail['tipe_donasi'] !== 'event') {
            $res['rel'] = Event::find($detail['tipe_donasi']);
        } else {
            $res['rel'] = ModelsDonation::find($detail['tipe_donasi']);
        }
        $this->detailData = $res;
        $this->handlerModalDetail();
    }

    public function handlerModalDetail()
    {

        $this->modalDetailShow = !$this->modalDetailShow;
    }


    public function render()
    {


        $transaksi = Transaksi::where(function ($q) {
            // if (!auth()->user()->isadmin) {
            //     $q->where('user_id', auth()->id());
            // }
        })->latest()->paginate($this->limitPerPage);
        // if($transaksi->count() < $transaksi->total()){
        //     $this->dispatch('loadmore');
        // }
        $stat =  Transaksi::where(function ($q) {
            if (!auth()->user()->isadmin) {
                $q->where('user_id', auth()->id());
            }
        })->selectRaw('COUNT(*) as semua,
                     SUM(CASE WHEN status="PAID" THEN jumlah_donasi ELSE 0 END) as total_paid,
                     SUM(CASE WHEN status="UNPAID" THEN jumlah_donasi ELSE 0 END) as total_unpaid,
                     SUM(CASE WHEN status="EXPIRED" THEN jumlah_donasi ELSE 0 END) as total_expired,
                     SUM(status="PAID") as paid,
                     SUM(status="UNPAID") as unpaid,
                     SUM(status="EXPIRED") as expired
                     ')
            ->first()->toArray();

        return view('livewire.pages.portal.donation', compact('transaksi', 'stat'));
    }
}
