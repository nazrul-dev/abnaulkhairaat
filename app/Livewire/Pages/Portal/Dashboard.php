<?php

namespace App\Livewire\Pages\Portal;

use App\Models\AngkatanUser;
use App\Models\Event;
use App\Models\Transaksi;
use App\Models\User;
use DB;
use Livewire\Component;

class Dashboard extends Component
{

    public $tipeAngkatanSelected = 'mi';

    public function selectedTipeAngkatan($key)
    {

        $this->tipeAngkatanSelected = $key;
    }
    public function render()
    {

        $userCount = User::whereNot('isadmin')->count();

        $totalDonation = Transaksi::where('status', 'PAID')->sum('total_donasi');

        $angkatanCounts = DB::table('biodata')
            ->select('province', 'city', DB::raw('COUNT(*) as jumlah_pengguna'))
            ->groupBy('province', 'city')
            ->orderBy('province')
            ->orderBy('city')
            ->get();

        $groupedData = [];

        foreach ($angkatanCounts as $count) {
            $province = $count->province;
            $city = $count->city;
            $jumlah_pengguna = $count->jumlah_pengguna;

            if (!isset($groupedData[$province])) {
                $groupedData[$province] = [];
            }

            $groupedData[$province][$city] = $jumlah_pengguna;
        }
        $users = DB::table('users')
            ->select('pekerjaan', 'district', 'angkatan')
            ->join('biodata', 'users.id', '=', 'biodata.user_id')
            ->join('angkatan_users', 'users.id', '=', 'angkatan_users.user_id')
            ->groupBy('pekerjaan', 'district', 'angkatan')
            ->get();

        $pekerjaanCounts = DB::table('users')
            ->join('biodata', 'users.id', '=', 'biodata.user_id')
            ->select('pekerjaan', DB::raw('COUNT(*) as jumlah_pengguna'))
            ->groupBy('pekerjaan')
            ->get();

        $angkatanCounts = DB::table('angkatan_users')
            ->select('tipe_angkatan', 'angkatan', DB::raw('COUNT(*) as jumlah_pengguna'))

            ->groupBy('tipe_angkatan', 'angkatan')
            ->orderBy('tipe_angkatan')
            ->orderBy('angkatan')
            ->get();

        $groupedDataAngkatan = [];

        $previousTipeAngkatan = null;

        foreach ($angkatanCounts as $count) {
            if ($count->tipe_angkatan != $previousTipeAngkatan) {
                $groupedDataAngkatan[$count->tipe_angkatan] = [];
                $previousTipeAngkatan = $count->tipe_angkatan;
            }

            $groupedDataAngkatan[$count->tipe_angkatan][] = [
                'angkatan' => $count->angkatan,
                'jumlah_pengguna' => $count->jumlah_pengguna,
            ];
        }
        $event  = Event::count();
        $angkatan['angkatanTerendah']  = AngkatanUser::angkatanTerendah();
        $angkatan['angkatanTetinggi']  = AngkatanUser::angkatanTertinggi();
        $angkatan['jumlahAngkatan']  = AngkatanUser::hitungAngkatanUnik();


        return view('livewire.pages.portal.dashboard', compact('event','angkatan','totalDonation','userCount','pekerjaanCounts', 'groupedDataAngkatan'));
    }
}
