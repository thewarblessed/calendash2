<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\OrganizationAdviserController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\SectionHeadController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\BusinessManagerController;
use App\Http\Controllers\AccomplishmentController;
use App\Http\Controllers\AccomplishmentReportsController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\GoogleSocialiteController;
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

//ROOM CRUD
Route::post('/admin/storeRoom',[
        'uses' => 'RoomController@store',
        'as' => 'storeRoom',
        ]);
Route::post('/admin/room/{id}',[
        'uses' => 'RoomController@update',
        'as' => 'updateRoom',
        ]);
Route::get('/admin/room/{id}/edit',[
        'uses' => 'RoomController@edit',
        'as' => 'editRoom',
        ]);
Route::delete('/admin/room/{id}',[
        'uses' => 'RoomController@destroy',
        'as' => 'deleteRoom',
        ]);

// CREATE EVENT FOR VENUES
// FILTER VENUES WHILE CREATING EVENT
Route::get('/create/venueFilter',[
        'uses' => 'EventController@searchVenues',
        'as' => 'searchVenue.store',
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
    
//CALENDAR EVENT DETAILS
Route::get('/getCalendarEvent/{id}', [CalendarController::class, 'myCalendarDetails'])
->name('getCalendarEvent');

//CHECK STATUS BY USER
Route::get('/myEventStatus/{id}', [RequestController::class, 'checkStatus'])
    ->name('checkMyEventStatus');

//CHECK EVENT CONFLICT
Route::post('/check-event-conflict',[
        'uses' => 'EventController@checkEventConflict',
        'as' => 'checkEventConflict',
]);

// APPROVE REQUEST
// Route::post('/request/approve/{id}',[
//         'uses' => 'RequestController@store',
//         'as' => 'EventApproval',
// ])->middleware('auth');

////////////////////// PENDING ROOM REQUEST DATATABLE ////////////////////
Route::get('/my/pendingRooms',[
        'uses' => 'RequestRoomController@getAllPendingRequestRooms',
        'as' => 'getAllPendingRequestRooms',
]);

Route::get('/my/pendingRooms/{id}',[
        'uses' => 'RequestRoomController@getSinglePendingRequestRooms',
        'as' => 'getSinglePendingRequestRooms',
]);

///////////// APPROVING OF ROOMS ////////////////////
Route::post('/rooms/approve/{id}',[
        'uses' => 'RequestRoomController@approveRooms',
        'as' => 'approveRooms',
]);

///////////// GET ALL APPROVED ROOM EVENTS ////////////////////
Route::get('/rooms/approve',[
        'uses' => 'RequestRoomController@getAllApproveRooms',
        'as' => 'getAllApproveRooms',
]);

Route::post('/rooms/reject/{id}',[
        'uses' => 'RequestRoomController@rejectRooms',
        'as' => 'rejectRooms',
]);


//////////// GET ALL REJECTED ROOM EVENTS ///////////
Route::get('/rooms/rejected',[
        'uses' => 'RequestRoomController@getAllRejectedRooms',
        'as' => 'getAllRejectedRooms',
]);


///////////////////// ADMIN EVENTS /////////////////////////
Route::get('/admin/allEvents/{id}', 'EventController@showAdminSingleEvent')->name('showAdminSingleEvent');
Route::post('/admin/allEvents/update/{id}', 'EvensController@update')->name('updateAdminEvents');

// GET EVENT BY DATE (admin)
Route::post('/events',[
        'uses' => 'EventController@getEventDate',
        'as' => 'getEventDate',
        ]);

// REPORTS
// Route::get('/admin/report/venue', [ReportController::class, 'showVenueReport'])->name('admin.report.venue');
Route::get('/admin/report/event', [ReportController::class, 'showEventReport'])->name('admin.report.event');

Route::get('/admin/all-events', 'EventController@getAdminAllEvents')->name('getAdminAllEvents');



///////////////////// OFFICIALS ////////////////
// ADD OFFICIALS
Route::post('/admin/storeOfficial',[
        'uses' => 'OfficialController@store',
        'as' => 'storeOfficial',
]);
// EDIT OFFICIALS
Route::get('/admin/official/{id}/edit',[
        'uses' => 'OfficialController@edit',
        'as' => 'editOfficials',
        ]);
// UPDATE OFFICIALS
Route::post('/admin/official/{id}',[
        'uses' => 'OfficialController@update',
        'as' => 'updateOfficials',
        ]);

Route::post('/request/approve/{id}',[
        'uses' => 'RequestController@store',
        'as' => 'showEventRole',
]);

// REJECTING OF REQUEST BY OFFICIALS
Route::post('/request/reject/{id}',[
        'uses' => 'RequestController@reject',
        'as' => 'rejectEvent',
]);

//get official all reject request
Route::post('/my/reject/{id}',[
        'uses' => 'RequestController@getMyRejectRequest',
        'as' => 'getMyRejectRequest',
]);

//get official all approved request
Route::post('/my/approved/{id}',[
        'uses' => 'RequestController@getMyApprovedRequest',
        'as' => 'getMyApprovedRequest',
]);

//get USER all reject request
Route::post('/user/reject/{id}',[
        'uses' => 'UserEventController@getAllRejectedRequest',
        'as' => 'getAllRejectedRequest',
]);

//get USER all approved request
Route::post('/user/approved/{id}',[
        'uses' => 'UserEventController@getAllApprovedRequest',
        'as' => 'getAllApprovedRequest',
]);


// GET ALL ORG ADVISERS
Route::get('/admin/orgadvisers',[
        'uses' => 'OrganizationAdviserController@getAllOrgAdviser',
        'as' => 'getAllOrgAdviser',
        ]);
Route::post('/admin/storeOrgAdviser',[
        'uses' => 'OrganizationAdviserController@store',
        'as' => 'storeOrgAdviser',
]);
Route::get('/admin/orgAdviser/{id}',[
        'uses' => 'OrganizationAdviserController@edit',
        'as' => 'getSingleOrgAdviser',
]);
Route::post('/admin/orgAdviser/update/{id}',[
        'uses' => 'OrganizationAdviserController@update',
        'as' => 'updateOrgAdviser',
]);

///////////////////// SECTION HEADS /////////////////////////

Route::get('/admin/orgadvisers',[
        'uses' => 'OrganizationAdviserController@getAllOrgAdviser',
        'as' => 'getAllOrgAdviser',
        ]);
Route::post('/admin/storeSectionHead',[
        'uses' => 'SectionHeadController@store',
        'as' => 'storeSectionHead',
]);
Route::get('/admin/sectionHead/{id}',[
        'uses' => 'SectionHeadController@edit',
        'as' => 'getSingleSectionHead',
]);
Route::post('/admin/sectionHead/update/{id}',[
        'uses' => 'SectionHeadController@update',
        'as' => 'updateSectionHead',
]);

///////////////////// DEPARTMENT HEADS /////////////////////////

Route::get('/admin/orgadvisers',[
        'uses' => 'OrganizationAdviserController@getAllOrgAdviser',
        'as' => 'getAllOrgAdviser',
        ]);
Route::post('/admin/storeDepartmentHead',[
        'uses' => 'DepartmentHeadController@store',
        'as' => 'storeDepartmentHead',
]);
Route::get('/admin/departmentHead/{id}',[
        'uses' => 'DepartmentHeadController@edit',
        'as' => 'getSingleDepartmentHead',
]);
Route::post('/admin/departmentHead/update/{id}',[
        'uses' => 'DepartmentHeadController@update',
        'as' => 'updateDepartmentHead',
]);

///////////////////// USERS ////////////////
// COMPLETION OF USER PROFILES
Route::post('/users/storeCompleteProfile',[
        'uses' => 'UserController@completeProfile',
        'as' => 'userCompleteProfile',
]);

Route::post('/admin/confirmPendingUsers/{id}',[
        'uses' => 'UserController@confirmPendingUsers',
        'as' => 'approveAccount',
]);

Route::post('/admin/rejectPendingUser/{id}',[
        'uses' => 'UserController@rejectUser',
        'as' => 'rejectUser',
]);

// get single User
Route::get('/admin/getUser/{id}',[
        'uses' => 'UserController@getUser',
        'as' => 'getSingleUser',
]);
// edit role
Route::post('/admin/editRole/{id}',[
        'uses' => 'UserController@editRole',
        'as' => 'updateUserRole',
]);

Route::post('/admin/postCreateMyEvent', [EventController::class, 'storeMyEventsAdmin'])
    ->name('postCreateMyEvent');

////////////////////////////// ACCOMPLISHMENT REPORT (USERS VIEW) //////////////////////////////
Route::post('/user/get-all-my-approved-events/{id}', [AccomplishmentController::class, 'getMyApprovedEvents'])
    ->name('getMyApprovedEvents');

Route::post('/user/store-accomplishment', [AccomplishmentController::class, 'storeImage'])
->name('storeImage');

Route::post('/upload/{id}', [AccomplishmentController::class, 'storeAccomplishment'])
->name('storeAccomplishment');

Route::post('/update/{id}', [AccomplishmentController::class, 'updateAccomplishment'])
->name('updateAccomplishment');

////////////////////////////// ALL ACCOMPLISHMENT REPORTS (ADMIN VIEW) //////////////////////////////
Route::get('get-all-approved-events', [AccomplishmentReportsController::class, 'getAllApprovedEvents'])
    ->name('getAllApprovedEvents');

Route::get('get-all-accomplishments', [AccomplishmentReportsController::class, 'getAllAccomplishments'])
->name('getAllAccomplishments');

Route::get('get-event-images/{id}', [AccomplishmentReportsController::class, 'getEventsImages'])
    ->name('getEventsImages');

Route::get('get-completed-events', [AccomplishmentReportsController::class, 'checkDeadline'])
->name('checkDeadline');

/////////////////////////////// OUTSIDE & BUSINESS MANAGER ////////////////////////
Route::post('/outside/storeEvent',[
        'uses' => 'BusinessManagerController@store',
        'as' => 'storeOutsiderEvents',
]);

Route::get('/show/outsiderEvent/{id}',[
        'uses' => 'BusinessManagerController@edit',
        'as' => 'showSingleOutsiderEvent',
        ]);

Route::post('/outside/storeEventAmount/{id}',[
        'uses' => 'BusinessManagerController@storeBusinessManager',
        'as' => 'storeBusinessManager',
]);

Route::post('/upload-receipt/{id}',[
        'uses' => 'BusinessManagerController@uploadReceipt',
        'as' => 'uploadReceipt',
]);
Route::post('/approve-receipt/{id}',[
        'uses' => 'BusinessManagerController@approveReceipt',
        'as' => 'approveReceipt',
]);

Route::post('/reject-outsider-event/{id}',[
        'uses' => 'BusinessManagerController@rejectEvent',
        'as' => 'rejectEventOutsider',
]);

Route::post('/rejected-event-outsider/{id}',[
        'uses' => 'BusinessManagerController@getAllRejectedEventsOutsider',
        'as' => 'getAllRejectedEventsOutsider',
]);

Route::post('/rejected-event-businessmanager/{id}',[
        'uses' => 'BusinessManagerController@getAllRejectedEventsBusinessManager',
        'as' => 'getAllRejectedEventsBusinessManager',
]);
   
Route::post('/approved-event-outsider/{id}',[
        'uses' => 'BusinessManagerController@getAllApprovedEventsOutsider',
        'as' => 'getAllApprovedEventsOutsider',
]);

Route::post('/approved-event-businessmanager',[
        'uses' => 'BusinessManagerController@getAllApprovedEventsBusinessManager',
        'as' => 'getAllApprovedEventsBusinessManager',
]);


Route::get('/myOutsiderEventStatus/{id}', [BusinessManagerController::class, 'checkStatusOutsider'])
    ->name('checkStatusOutsider');


////////////////////////////// attendance student lists //////////////////////
Route::get('/studentlists/{id}',[
        'uses' => 'AttendanceController@getStudentList',
        'as' => 'getStudentList',
]);

// Update Attendance
Route::post('/updateAttendance/{id}',[
        'uses' => 'AttendanceController@updateAttendance',
        'as' => 'updateAttendance',
        ]);

Route::get('/get-department/{id}',[
        'uses' => 'OrganizationAdviserController@getDepartment',
        'as' => 'getDepartmentCompleteProfile',
]);

Route::post('/add-participant/{id}',[
        'uses' => 'AttendanceController@addParticipant',
        'as' => 'addParticipantAttendance',
]);
        

////////////////////////////// NOTIFICATIONS  //////////////////////
Route::post('/notif/request/{id}',[
        'uses' => 'NotificationController@index',
        'as' => 'getNotif',
]);

Route::post('/notif/read-request/{id}',[
        'uses' => 'NotificationController@readNotif',
        'as' => 'readNotif',
]);

////////////////////////////// EXTERNAL API  //////////////////////
Route::get('/getAllCalendars',[
        'uses' => 'CalendarController@myApiCalendar',
        'as' => 'myApiCalendar',
]);

////////////////////////////// Check Passcode //////////////////////
Route::post('/me/check-passcode',[
        'uses' => 'ProfileController@checkPasscode',
        'as' => 'checkPasscode',
]);

////////////////////////////// Check Password //////////////////////
Route::post('/me/check-password',[
        'uses' => 'ProfileController@verifyPassword',
        'as' => 'verifyPassword',
]);

////////////////////////////// Update Passcode //////////////////////
Route::post('/me/update-passcode',[
        'uses' => 'ProfileController@updatePasscode',
        'as' => 'updatePasscode',
]);

////////////////////////////// Check if the user uploaded a accomplishment report ///////////////////

Route::post('/me/check-accomplishments/{id}',[
        'uses' => 'AccomplishmentReportsController@checkUserAccomplishment',
        'as' => 'checkUserAccomplishment',
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
Route::get('/mobileAdmin/department', [DepartmentHeadController::class, 'getAllDepartments']);
Route::get('/mobileAdmin/organization', [OrganizationAdviserController::class, 'getAllOrganizations']);

//////////////////////////// MOBILE CALENDAR ///////////////////
Route::get('/getAllCalendars/mobile',[
        'uses' => 'CalendarController@myApiCalendarMobile',
        'as' => 'myApiCalendarMobile',
]);

//ROOM INDEX 
Route::get('/mobileAdmin/room/index', [RoomController::class, 'roomIndexMobile']);


//CREATE EVENT
Route::post('/mobile/event-store', [EventController::class, 'storeEventMobile']);

//get events of user
Route::post('/mobile/my-events', [EventController::class, 'myEventsMobile']);

//status of events of user
Route::post('/mobile/my-event-status/{id}', [EventController::class, 'myEventStatusMobile']);

// CHECK GOOGLE ID / SOCIAL ID IN USERS TABLE
Route::post('/mobile/check-social-id', [GoogleSocialiteController::class, 'checkGoogleID']);

// GET ALL SECTIONS
Route::get('/mobile/get-all-course', [SectionHeadController::class, 'getAllCourses']);

Route::get('/mobile/get-all-organization', [OrganizationAdviserController::class, 'getAllOrganizations']);

Route::get('/mobile/get-all-department', [DepartmentHeadController::class, 'getAllDepartments']);
