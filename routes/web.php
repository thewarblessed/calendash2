<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

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

Route::get('/', function () {
    return redirect('/dashboard');
})->middleware('auth');

//SIDEBAR SIDEBAR SIDEBAR SIDEBAR

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');

Route::middleware('auth:sanctum')->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/tables', function () {
    return view('tables');
})->name('tables')->middleware('auth');

Route::get('/events', function () {
    return view('event.events');
})->name('events')->middleware('auth');

// USER CREATE EVENT
Route::get('/myevents', function () {
    return view('event.myEvents');
})->name('myEvents')->middleware('auth');

// USER CHECK VENUES
Route::get('/venues', [VenueController::class, 'indexUser'])
    ->name('venues.indexUser')
    ->middleware('auth');

        // FOR REFERENCE SEARCH
// Route::get('/search', function () {
//     return view('event.new');
// })->name('new')->middleware('auth');


// USER CHECK CALENDAR
Route::get('/calendar', [CalendarController::class, 'myCalendar'])
    ->name('calendar')
    ->middleware('auth');

Route::get('/wallet', function () {
    return view('wallet');
})->name('wallet')->middleware('auth');

Route::get('/RTL', function () {
    return view('RTL');
})->name('RTL')->middleware('auth');

Route::get('/profile', function () {
    return view('account-pages.profile');
})->name('profile')->middleware('auth');

Route::get('/signin', function () {
    return view('account-pages.signin');
})->name('signin');

Route::get('/signup', function () {
    return view('account-pages.signup');
})->name('signup')->middleware('guest');

Route::get('/sign-up', [RegisterController::class, 'create'])
    ->middleware('guest')
    ->name('sign-up');

Route::post('/sign-up', [RegisterController::class, 'store'])
    ->middleware('guest')
    ->name('register');

Route::get('/sign-in', [LoginController::class, 'create'])
    ->middleware('guest')
    ->name('sign-in');

Route::post('/sign-in', [LoginController::class, 'store'])
    ->middleware('guest')
    ->name('login');

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::get('/forgot-password', [ForgotPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.request');

Route::post('/forgot-password', [ForgotPasswordController::class, 'store'])
    ->middleware('guest')
    ->name('password.email');

Route::get('/reset-password/{token}', [ResetPasswordController::class, 'create'])
    ->middleware('guest')
    ->name('password.reset');

Route::post('/reset-password', [ResetPasswordController::class, 'store'])
    ->middleware('guest');

Route::get('/laravel-examples/user-profile', [ProfileController::class, 'index'])->name('users.profile')->middleware('auth');
Route::put('/laravel-examples/user-profile/update', [ProfileController::class, 'update'])->name('users.update')->middleware('auth');
Route::get('/laravel-examples/users-management', [UserController::class, 'index'])->name('users-management')->middleware('auth');


// Route::get('/createEvent', function () {
//     return view('event.create');
// })->name('createEvent')->middleware('auth');


// CREATE EVENT
Route::get('/createEvent', [EventController::class, 'showVenues'])
        ->name('createEvent')
        ->middleware('auth');

//CREATE EVENTS POST
Route::post('/createEvent/post', [EventController::class, 'store'])
    ->name('createEventPost')
    ->middleware('auth');

// VENUE ADMIN 
// Route::get('/admin/venues', function () {
//     // return view('admin.venue.index');
// })->name('adminVenues')->middleware('auth');

Route::get('/admin/venues', [VenueController::class, 'index'])->name('adminVenues')->middleware('auth');



Route::get('/admin/createVenue', [VenueController::class, 'create'])
    ->middleware('auth')
    ->name('adminVenueCreate');

Route::get('/texteditor', function () {
    return view('event.editor');
})->name('multiform')->middleware('auth');

// ADAA
// Route::get('/request', function () {
//     return view('adaa.request');
// })->name('adaaRequest');

Route::get('/request', [RequestController::class, 'index'])
    ->middleware('auth')
    ->name('adaaRequest');






