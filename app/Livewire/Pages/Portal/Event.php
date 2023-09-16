<?php

namespace App\Livewire\Pages\Portal;

use App\Models\Event as ModelsEvent;
use App\Models\Transaksi;
use Illuminate\Database\QueryException;
use Livewire\Component;
use WireUi\Traits\Actions;
use Livewire\Attributes\Rule;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Nekoding\Tripay\Networks\HttpClient;
use Nekoding\Tripay\Tripay;
use Nekoding\Tripay\Signature;

class Event extends Component
{

    use Actions, WithFileUploads, WithPagination;
    public $posterShow;
    public $modalPosterShow = false;
    public $limitPerPage = 3;
    public $pesan = '';
    public $fangkatan, $ftipe_angkatan;
    public $ids = '';
    public $channelPembayaran = [];

    #[Rule('required')]
    public $nama = '';
    #[Rule('required')]
    public $tanggal_mulai = '';
    #[Rule('required')]
    public $tanggal_berakhir = '';
    #[Rule('required')]
    public $lokasi = '';
    #[Rule('nullable|image')]
    public $poster;
    #[Rule('required')]
    public $penanggung_jawab = '';
    public $modalForm = false, $modalDonationShow = false;


    public $donationAmount = 0;
    public $channelSelected;
    public $eventSelected;
    protected $listeners = [
        'loadmore' => 'loadmore'
    ];

    public function loadmore()
    {
        $this->limitPerPage = $this->limitPerPage + 3;
    }


    public function handlerModal()
    {
        $this->modalForm = !$this->modalForm;
    }

    public function form($data = null)
    {

        if ($data !== null) {
            $this->ids = $data['id'];
            $this->nama = $data['nama'];
            $this->tanggal_mulai = $data['tanggal_mulai'];
            $this->tanggal_berakhir = $data['tanggal_berakhir'];
            $this->lokasi = $data['lokasi'];
            $this->penanggung_jawab = $data['penanggung_jawab'];
        }
        $this->handlerModal();
    }

    public function save()
    {

        $this->validate();
        try {
            if (!$this->ids) {
                $this->create();
            } else {
                $this->update();
            }
        } catch (QueryException $th) {
            dd($th);
        }
    }

    public function create()
    {

        $filepath = null;
        if ($this->poster) {
            $filepath = $this->poster->store('posters');
        }
        ModelsEvent::create([
            "nama" => $this->nama,
            "tanggal_mulai" => $this->tanggal_mulai,
            "tanggal_berakhir" => $this->tanggal_berakhir,
            "lokasi" => $this->lokasi,
            "poster" => $filepath,
            "penanggung_jawab" => $this->penanggung_jawab,
        ]);

        $this->notification([
            'title'       => 'Success',
            'description' => 'Berhasil Menambah Event ',
            'icon'        => 'success'
        ]);
        $this->reset([
            "nama",
            "tanggal_mulai",
            "tanggal_berakhir",
            "lokasi",
            "poster",
            "penanggung_jawab"
        ]);
        $this->modalForm = false;
    }

    public function update()
    {
        $filepath = null;
        if ($this->poster) {
            $filepath = $this->poster->store('posters');
        }
        ModelsEvent::find($this->ids)->update([
            "nama" => $this->nama,
            "tanggal_mulai" => $this->tanggal_mulai,
            "tanggal_berakhir" => $this->tanggal_berakhir,
            "lokasi" => $this->lokasi,
            "poster" => $filepath,
            "penanggung_jawab" => $this->penanggung_jawab,
        ]);

        $this->notification([
            'title'       => 'Success',
            'description' => 'Berhasil Mengubah Event successfully saved',
            'icon'        => 'success'
        ]);

        $this->reset([
            "ids",
            "nama",
            "tanggal_mulai",
            "tanggal_berakhir",
            "lokasi",
            "poster",
            "penanggung_jawab"
        ]);
        $this->modalForm = false;
    }

    public function handlerDelete($id)
    {
        $this->ids = $id;
        $this->dialog()->confirm([
            'title'       => 'Apakah Kamu yakin?',
            'description' => 'untuk Menghapus Data Event ini',
            'acceptLabel' => 'Ya, saya yakin',
            'method'      => 'delete',

        ]);
    }

    public function delete()
    {
        ModelsEvent::destroy($this->ids);
        $this->notification([
            'title'       => 'Success',
            'description' => 'Berhasil Menghapus Event ',
            'icon'        => 'success'
        ]);
        $this->reset('ids');
    }

    public function mount()
    {
    }

    public function donation($event)
    {

        if (!count($this->channelPembayaran)) {
            $tripay = new Tripay(new HttpClient(config("tripay.tripay_api_key")));
            $channelpembayaran = $tripay->getChannelPembayaran();
            $this->channelPembayaran = $channelpembayaran['data'];
        }
        $this->eventSelected = $event;
        $this->handlerModalDonation();
    }

    public function handlerModalDonation()
    {

        $this->modalDonationShow = !$this->modalDonationShow;
    }


    public function handlerModalShowPoster()
    {

        $this->modalPosterShow = !$this->modalPosterShow;
    }
    public function selectedChannel($channel)
    {
        $this->channelSelected =   $this->channelPembayaran[$channel];
    }

    public function handlerShowPoster($path)
    {
        $this->posterShow = $path;
        $this->handlerModalShowPoster();
    }

    public function checkout()
    {
        if (!$this->eventSelected) {
            $this->handlerModalDonation();
            return    $this->notification([
                'title'       => 'Gagal',
                'description' => 'Gagal Melakukan Checkout , coba lagi',
                'icon'        => 'error'
            ]);
        }
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
                'customer_email' =>  $user->email,
                'customer_phone' => $user->biodata->phone ?? '',
                'order_items'    => [
                    [
                        'name'        => $this->eventSelected['nama'],
                        'price'       => $this->donationAmount,
                        'quantity'    => 1,
                        'image_url'   => asset('storage/' . $this->eventSelected['poster']),
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
                    'tipe_donasi' => 'event',
                    'relation_id' => $this->eventSelected['id'],
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
dd($th);
            $this->handlerModalDonation();
            return    $this->notification([
                'title'       => 'Gagal',
                'description' => 'Gagal Melakukan Checkout dari server , coba lagi',
                'icon'        => 'error'
            ]);
        }
    }

    public function render()
    {
        $events = ModelsEvent::latest()->paginate($this->limitPerPage);
        return view('livewire.pages.portal.event', compact('events'));
    }
}
