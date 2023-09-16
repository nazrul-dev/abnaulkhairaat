<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\AngkatanUser;
use App\Models\Biodata;
use App\Models\Genealogy;
use App\Models\User;
use File;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravolt\Indonesia\Seeds\CitiesSeeder;
use Laravolt\Indonesia\Seeds\VillagesSeeder;
use Laravolt\Indonesia\Seeds\DistrictsSeeder;
use Laravolt\Indonesia\Seeds\ProvincesSeeder;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        File::deleteDirectory(public_path('storage/avatars'));
        $path = public_path().'/storage/avatars';
        File::makeDirectory($path, $mode = 0777, true, true);
        // User::factory()->count(50)->create()->each(function ($user) {
        //     // // Seed the relation with one address
        //     $biodata = Biodata::factory()->make();
        //     $user->biodata()->save($biodata);

        //     $angkatan = AngkatanUser::factory()->make();
        //     $user->angkatanUsers()->save($angkatan);
        //     // dd($user);
        // });

        $this->call([
            ProvincesSeeder::class,
            CitiesSeeder::class,
            DistrictsSeeder::class,
            VillagesSeeder::class,
        ]);

    }
}
