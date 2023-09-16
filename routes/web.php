<?php

use App\Http\Controllers\CallbackTripayController;
use App\Http\Controllers\ProfileController;
use App\Livewire\Pages\Landing;
use App\Livewire\Pages\Payments\Checkout;
use App\Livewire\Pages\Portal\Dashboard;
use App\Livewire\Pages\Portal\Discussion;
use App\Livewire\Pages\Portal\Donation ;
use App\Livewire\Pages\Portal\Event;
use App\Livewire\Pages\Portal\Profile;
use App\Livewire\Pages\Portal\Requirment;
use App\Livewire\Pages\Portal\Verified;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');
  // Your other localized routes...
 
    Livewire::setUpdateRoute(function ($handle) {
        return Route::post('/livewire/update', $handle);
    });


Route::post('/callback/tripay',CallbackTripayController::class);
Route::middleware(['auth'])->group(function () {
    Route::get('/requirement', Requirment::class)->name('requirement');
    Route::get('/verified', Verified::class)->name('verified');
    Route::middleware(['isbiodata','isVerified'])->group(function () {
        Route::get('/dashboard', Dashboard::class);
        Route::get('/profile', Profile::class);
        Route::get('/events', Event::class);
        Route::get('/diskusi', Discussion::class);
        Route::get('/donasi', Donation::class);
        Route::get('/checkout/{transaksi:merchant_ref}', Checkout::class)->name('payments.checkout');
    });
});
Route::middleware('guest')->group(function () {
    Route::get('/', Landing::class);
});




require __DIR__ . '/auth.php';
