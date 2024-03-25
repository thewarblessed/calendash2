<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\OfficialController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\GoogleSocialiteController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\OrganizationAdviserController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\SectionHeadController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\BusinessManagerController;
use App\Http\Controllers\RequestRoomController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\ReportController;

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

// USER STATUS EVENT TABLE

Route::get('/myEvents', [EventController::class, 'statusEvents'])
    ->name('myEvents')
    ->middleware('auth');

Route::get('/myEvents/details', function () {
        return view('event.myEventsStatus');
    })->name('events.status')->middleware('auth');

// USER CHECK VENUES
Route::get('/venues', [VenueController::class, 'indexUser'])
    ->name('venues.indexUser')
    ->middleware('auth');

Route::get('/completeProfile', [UserController::class, 'viewCompleteProfile'])
    ->name('completeProfile')
    ->middleware('auth');
// COMPLETE PROFILE
// Route::get('/completeProfile', function () {
//     return view('completeProfile');
// })->name('completeProfile')->middleware('auth');

        // FOR REFERENCE SEARCH
// Route::get('/search', function () {
//     return view('event.new');
// })->name('new')->middleware('auth');


// USER CHECK CALENDAR
// Route::get('/calendar', [CalendarController::class, 'myCalendar'])
//     ->name('calendar')
//     ->middleware('auth');

Route::get('/calendar', function () {
    return view('mycalendar');
})->name('calendar')->middleware('auth');

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

Route::get('/timeline', function () {
    return view('timeline');
})->name('timeline');

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

// route to rulesreg
Route::get('/rulesreg/{id}', [VenueController::class, 'rulesreg'])
    ->middleware('auth')
    ->name('venueRulesreg');

// route to feedback
Route::get('/feedback/{id}', [VenueController::class, 'feedback'])
    ->middleware('auth')    
    ->name('venueFeedback');

Route::get('/texteditor', function () {
    return view('event.editor');
})->name('multiform')->middleware('auth');

////////////////////  REQUEST APPROVAL
// ADAA

Route::get('/request', [RequestController::class, 'index'])
    ->name('adaaRequest')
    ->middleware('auth');

//  STORE REQUEST APPROVAL
Route::post('/request/approve/{id}', [RequestController::class, 'store'])
->middleware('auth')
->name('EventApproval');

/////////////////////// CREATE EVENTS FOR ADMIN /////////////

Route::get('/admin/allEvents', [EventController::class, 'showAdminEvents'])
    ->name('AdminAllEvents');

Route::get('/admin/createEvent', [EventController::class, 'createAdminEvents'])
    ->name('createAdminEvents');

Route::get('/mycreateevent', function () {
    return view('myevents');
})->name('myeventsexample');

// Route::post('/postCreateMyEvent', [EventController::class, 'storeMyEventsAdmin'])
//     ->name('postCreateMyEvent');

///////////////////////// ROOM CRUD FOR ADMIN  /////////////////////////////

Route::get('/admin/rooms', [RoomController::class, 'index'])
    ->middleware('auth')
    ->name('adminRooms');

Route::get('/admin/createRoom', [RoomController::class, 'create'])
    ->middleware('auth')
    ->name('adminRoomCreate');

/////////////////////// CREATE OFFICIALS FOR ADMIN /////////////
// GET ALL OFFICIALS
Route::get('/admin/officials', [OfficialController::class, 'index'])
    ->name('AdminAllOfficials');
// CREATE OFFICIALS
Route::get('/admin/createOfficials', [OfficialController::class, 'create'])
    ->middleware('auth')
    ->name('AdminCreateOfficials');

////////////////////// ORG ADVISERS///////////////////
Route::get('/admin/orgAdvisers', [OrganizationAdviserController::class, 'index'])
    ->middleware('auth')
    ->name('AdminIndexOrgAdviser');

Route::get('/admin/createOrgAdviser', [OrganizationAdviserController::class, 'create'])
    ->middleware('auth')
    ->name('AdminCreateOrgAdviser');

Route::get('/admin/sectionHeads', [SectionHeadController::class, 'index'])
    ->middleware('auth')
    ->name('AdminIndexSectionHead');

Route::get('/admin/createSectionHead', [SectionHeadController::class, 'create'])
    ->middleware('auth')
    ->name('AdminCreateSectionHead');

Route::get('/admin/departmentHeads', [DepartmentHeadController::class, 'index'])
    ->middleware('auth')
    ->name('AdminIndexDepartmentHead');

Route::get('/admin/createDepartmentHead', [DepartmentHeadController::class, 'create'])
    ->middleware('auth')
    ->name('AdminCreateDepartmentHead');


    /////////////////////// COMPLETE USER PROFILES FOR ADMIN /////////////
// GET ALL OFFICIALS
Route::get('/admin/pendingUsers', [UserController::class, 'pendingUsers'])
->name('pendingUsers');
// // CREATE OFFICIALS
// Route::get('/admin/createOfficials', [OfficialController::class, 'create'])
// ->middleware('auth')
// ->name('AdminCreateOfficials');

///////////////////////////////////////////////// OUTSIDE AND BUSINESS MANAGER ////////////////////////////////////////
Route::get('/outsidelist',[
    'uses' => 'BusinessManagerController@getAllOutsideUser',
    'as' => 'outsideUser',
]);

Route::get('/pending/receipt', [BusinessManagerController::class, 'waitingForReceipt'])
->middleware('auth')
->name('waitingForReceipt');

Route::get('/outside/createRequest', [BusinessManagerController::class, 'create'])
->middleware('auth')
->name('outsideCreateRequest');

Route::get('/outside/myRequest', [BusinessManagerController::class, 'statusOutsiderEvents'])
->middleware('auth')
->name('statusOutsiderEvents');

Route::get('/outsidelist',[
    'uses' => 'BusinessManagerController@getAllOutsideUser',
    'as' => 'outsideUser',
]);

Route::get('/outside/pendingUser',[
    'uses' => 'BusinessManagerController@showPendingOutsider',
    'as' => 'showPendingOutsider',
]);

/// rejected request of outsider
Route::get('/outside/rejected-request',[
    'uses' => 'BusinessManagerController@rejectedEventsOutsider',
    'as' => 'rejectedEventsOutsider',
]);

/// rejected request of business manager
Route::get('/bm/rejected-request',[
    'uses' => 'BusinessManagerController@rejectedEventsBusinessManager',
    'as' => 'rejectedEventsBusinessManager',
]);

/// APPROVED request of outsider
Route::get('/outside/approved-request',[
    'uses' => 'BusinessManagerController@approvedEventsOutsider',
    'as' => 'approvedEventsOutsider',
]);

/// APPROVED request of business manager
Route::get('/bm/approved-request',[
    'uses' => 'BusinessManagerController@approvedEventsBusinessManager',
    'as' => 'approvedEventsBusinessManager',
]);

//////////////////////////////////////////////// ATTENDANCE ///////////////////////////////////////////////////
Route::get('/attendance', [AttendanceController::class, 'index'])
->name('attendance');

Route::get('/attendance/{id}', [AttendanceController::class, 'attendance'])
    ->middleware('auth')
    ->name('singleAttendance');


//////////////////////////////////////////////// REJECTED REQUESTS FOR OFFICIALS  ///////////////////////////////////////////////////
Route::get('/my/rejected', [RequestController::class, 'myRejectRequest'])
    ->middleware('auth')
    ->name('myRejected');

Route::get('/my/approved', [RequestController::class, 'myApprovedRequest'])
->middleware('auth')
->name('myApproved');

//////////////////////////////////////////////// REJECTED REQUESTS FOR USERS  ///////////////////////////////////////////////////
Route::get('/me/rejected', [UserEventController::class, 'myRejected'])
    ->middleware('auth')
    ->name('meRejected');

Route::get('/me/approved', [UserEventController::class, 'myApproved'])
->middleware('auth')
->name('meApproved');


//////////////////////////////////////// ATTENDANCE IMPORT FILE EXCEL  ///////////////////////////

Route::post('/import/studentImport', [AttendanceController::class, 'import'])
->middleware('auth')
->name('studentImport');

//////////////////////////////////////// OUTSIDER & BUSINESS MANAGER  ///////////////////////////

Route::get('/outside/request', [BusinessManagerController::class, 'index'])
->middleware('auth')
->name('outsideRequest');

// GOOGLE LOGIN 
Route::get('auth/google', [GoogleSocialiteController::class, 'redirectToGoogle']);
Route::get('/login/google/callback', [GoogleSocialiteController::class, 'handleCallback']);

// GMAIL NOTIFICATION
Route::get('/sendmail', [MailController::class, 'index']);

//////////////////////////////////////// ROOM PENDING REQUEST  ///////////////////////////

Route::get('/pending/rooms', [RequestRoomController::class, 'index'])
    ->middleware('auth')
    ->name('pendingRequestRoom');

Route::get('/approved/rooms', [RequestRoomController::class, 'approvedRoomsView'])
    ->middleware('auth')
    ->name('approvedRoomsView');


//////////////////////////////////////// REPORT CHARTS  ///////////////////////////
Route::get('/admin/report', [ReportController::class, 'countEventPerOrgReport'])->name('countEventPerOrgReport');
