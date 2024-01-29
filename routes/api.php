<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\Auth\LoginController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Route::post('/admin/storeVenue', [VenueController::class, 'store'])
//     ->middleware('auth')
//     ->name('storeVenue');

// LOGIN

Route::post('/auth/sign-in', [LoginController::class, 'loginMobile']);



// VENUE CRUD
Route::post('/admin/storeVenue',[
    'uses' => 'VenueController@store',
    'as' => 'storeVenue',
    ]);

Route::middleware(['cors'])->group(function () {
        Route::get('/admin/indexVenues',[
        'uses' => 'VenueController@index',
        'as' => 'indexVenue',
        ]);         
});




Route::get('/admin/indexVenues',[
        'uses' => 'VenueController@index',
        'as' => 'indexVenue',
        ]);

Route::get('/admin/venue/{id}/edit',[
        'uses' => 'VenueController@edit',
        'as' => 'editVenue',
        ]);

Route::post('/admin/venue/{id}',[
        'uses' => 'VenueController@update',
        'as' => 'updateVenue',
        ]);

Route::delete('/admin/venue/{id}',[
        'uses' => 'VenueController@destroy',
        'as' => 'deleteVenue',
        ]);

// CREATE EVENT FOR VENUES
// FILTER VENUES WHILE CREATING EVENT
Route::get('/create/venueFilter',[
        'uses' => 'EventController@searchVenues',
        'as' => 'searchVenue',
        ]);
// create Event
Route::post('/create/newEvent',[
    'uses' => 'EventController@store',
    'as' => 'storeEvent',
    ]);

// GET ALL EVENTS
Route::get('/show/allEvent',[
        'uses' => 'EventController@showEvents',
        'as' => 'showEvent',
        ]);

// GET SINGLE EVENT
Route::get('/show/event/{id}',[
        'uses' => 'RequestController@edit',
        'as' => 'showSingleEvent',
        ]);
// SHOW LETTER
Route::get('/show/letter/{id}',[
        'uses' => 'EventController@showLetter',
        'as' => 'showLetter',
]);

//CALENDAR
Route::get('/getCalendars', [CalendarController::class, 'myCalendar'])
    ->name('getCalendar');

// SHOW EVENT BASED ON ROLE
// Route::get('/show/event',[
//         'uses' => 'RequestController@store',
//         'as' => 'showEventRole',
// ]);

// APPROVE REQUEST
// Route::post('/request/approve/{id}',[
//         'uses' => 'RequestController@store',
//         'as' => 'EventApproval',
// ])->middleware('auth');


///////////////////// OFFICIALS ////////////////
// ADD OFFICIALS
Route::post('/admin/storeOfficial',[
        'uses' => 'OfficialController@store',
        'as' => 'storeOfficial',
]);

Route::post('/request/approve/{id}',[
        'uses' => 'RequestController@store',
        'as' => 'showEventRole',
]);


////////////////================ MOBILE ROUTES ================//////////////////
//REGISTRATION MOBILE
Route::post('/auth/sign-up',[
        'uses' => 'App\Http\Controllers\Auth\RegisterController@registerMobile',
        'as' => 'registerMobile',
        ]);

//LOGIN MOBILE
Route::post('/auth/sign-in',[
        'uses' => 'App\Http\Controllers\Auth\LoginController@loginMobile',
        'as' => 'loginMobile',
        ]);    
Route::post('/auth/logout',[
        'uses' => 'App\Http\Controllers\Auth\LoginController@logoutMobile',
        'as' => 'logoutMobile',
        ]);    

//PROFILE MOBILE
Route::get('/profile/{id}',[
        'uses' => 'App\Http\Controllers\UserController@getProfile',
        'as' => 'getProfile',
        ]); 

//ADMIN MOBILE VENUE CRUD
Route::post('/mobileAdmin/venue/store', [VenueController::class, 'storeMobile']);
Route::get('/mobileAdmin/venue/index', [VenueController::class, 'indexMobile']);
Route::delete('/mobileAdmin/venue/delete/{id}', [VenueController::class, 'destroyMobile']);
Route::post('/mobileAdmin/venue/update/{id}', [VenueController::class, 'updateMobile']);
// Route::post('/mobileAdmin/venue/bago/{id}', [VenueController::class, 'updateBago']);

// ADMIN MOBILE EVENTS
Route::get('/mobileAdmin/event/getAll', [EventController::class, 'getMobileAdminEvents']);


//MOBILE CREATE EVENT
Route::post('/mobileAdmin/event/store', [EventController::class, 'storeMobileEvent']);
Route::get('/mobileAdmin/event/index', [EventController::class, 'getMobileEvents']);