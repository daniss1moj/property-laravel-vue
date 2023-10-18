<?php

use App\Http\Controllers\AuthConroller;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationMarkController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
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

Route::get('/', fn() => to_route('listings.index'));

Route::resource('index', IndexController::class);

Route::resource('listings', ListingController::class)->only(['index', 'show'])->withTrashed();

Route::get('login', [AuthConroller::class, 'create'])->name('login');

Route::post('login', [AuthConroller::class, 'store'])->name('login.store');

Route::delete('logout', [AuthConroller::class, 'destroy'])->name('logout');

Route::resource('user-account', UserAccountController::class)->only(['create', 'store']);

Route::prefix('realtor')->name('realtor.')->middleware(['auth', 'verified'])->group(function () {
    Route::put('listings/{listing}/restore', [RealtorListingController::class, 'restore'])->name('listings.restore')->withTrashed();
    Route::resource('listings', RealtorListingController::class)
        ->withTrashed();
    Route::resource('listings.image', RealtorListingImageController::class)->only(['create', 'store', 'destroy']);
});


Route::put('offer/{offer}/accept', RealtorListingAcceptOfferController::class)->name('offer.accept');

Route::resource('listings.offer', OfferController::class)->middleware('auth')->only('store');

Route::resource('notifications', NotificationController::class)->middleware('auth')->only(['index']);

Route::put('notifications/{notification}/mark', NotificationMarkController::class)->middleware('auth')->name('notifications.mark');

Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');



Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listings.index')->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');



Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');