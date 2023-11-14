<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

use App\Models\User;
use App\Models\ActivitiesType;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\FootwearController;
use App\Http\Controllers\PersonalChallengeController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\TeamRequestController;
use App\Http\Controllers\FriendshipController;
use App\Http\Controllers\AdminController;


use Illuminate\Foundation\Auth\EmailVerificationRequest;
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
    return redirect('/userPanel/panel/');
});


Route::any('/home', function(){
    return redirect('/userPanel/panel/');
})->name('home');



Route::get('/login', [UserController::class, 'loginPageOrRedirect'])->name('login');
Route::post('/authenticate', [UserController::class, 'authenticateUserOrError'])->name('authenticate');

Route::get('/register', function(){  return view('register'); })->name('register');
Route::post('/registerUser', [UserController::class, 'registerUserOrError'])->name('registerUser');



// admin routes


Route::middleware(['admin'])->group(function(){

    Route::get('/admin/reports', [AdminController::class, 'reports']);



});



Route::middleware([Authenticate::class])->group(function () {

    Route::get('/logout', [UserController::class, 'logOutUser']);




    Route::any('/home1', function(){
        return view('homePage', []);
    })->name('home1');


    Route::get('/userPanel/panel/', PanelController::class );

    Route::get('/userPanel/addActivity/{id?}', [UserActivityController::class, 'create'] );
    Route::post('/userPanel/addActivity/', [UserActivityController::class, 'store'] );
    Route::get('/userPanel/panel/{userActivity}/delete', [UserActivityController::class, 'destroy'] );

    Route::get('/userPanel/panel/{userActivity}/edit', [UserActivityController::class, 'edit'] );
    Route::any('/userPanel/panel/{userActivity}/update', [UserActivityController::class, 'update'] );

    // calendar
    Route::get('/userPanel/calendar/', [UserActivityController::class, 'index_calendar'] );


    // fetch urls for panel
    Route::get('/userPanel/panel/getUserActivityJson/{year}/{month}', [UserActivityController::class, 'getJsonByMonth']);
    Route::get('/userPanel/panel/getUserActivityTypesChart/{year?}', [UserActivityController::class, 'getYearActivityCountPerType']);
    Route::get('/userPanel/panel/getUserActivityPerMonthChart/{year?}', [UserActivityController::class, 'getYearActivityCountPerMonth']);
    Route::get('/userPanel/panel/getUserActivityPerMonthChartAll/', [UserActivityController::class, 'getActivityCountPerMonth']);
    Route::get('/userPanel/panel/getUserActivityPerMonthChartType/{ActivitiesType}', [UserActivityController::class, 'getActivityCountPerMonthType']);


    // notifications
    Route::get('/userPanel/notification/view/{notification:id}', [NotificationController::class, 'show'] );
    Route::get('/userPanel/notification/view/', [NotificationController::class, 'index'] );
    Route::get('/userPanel/notification/unmark/{notification}', [NotificationController::class, 'unmark'] );


    // friendships
    Route::get('/userPanel/friends/', [FriendshipController::class, 'index'] );
    Route::get('/userPanel/friends/{friend}', [FriendshipController::class, 'deleteFriend'] );
    Route::get('/userPanel/friends/send/{user}', [FriendshipController::class, 'sendRequest'] );

    Route::get('/userPanel/friends/fetch/{string}', [FriendshipController::class, 'findByString'] );




    // footwear
    Route::get('/userPanel/footwear/add/', [FootwearController::class, 'create'] );
    Route::post('/userPanel/footwear/add/', [FootwearController::class, 'store'] );
    Route::get('/userPanel/footwear/{footwear}/edit', [FootwearController::class, 'edit'] );
    Route::post('/userPanel/footwear/{footwear}/edit', [FootwearController::class, 'update'] );
    Route::get('/userPanel/footwear/', [FootwearController::class, 'index'] );
    Route::get('/userPanel/footwear/{footwear}/delete', [FootwearController::class, 'destroy'] );

    // user profile

    Route::get('/userPanel/profile/view/{user}', [UserController::class, 'show']);
    Route::get('/userPanel/profile/view', [UserController::class, 'show']);
    Route::post('/userPanel/profile/edit/photo', [UserController::class, 'editPhoto']);


    // personal challenges

    Route::get('userPanel/challenges/', [PersonalChallengeController::class, 'index']);
    Route::get('userPanel/challenges/add', [PersonalChallengeController::class, 'create']);
    Route::post('userPanel/challenges/add', [PersonalChallengeController::class, 'store']);

    // summary

    Route::get('/userPanel/summary', [UserController::class, 'summary']);
    Route::get('/userPanel/summary/type/{ActivitiesType}', [UserController::class, 'summaryByType']);




    // team
    Route::get('/userPanel/team/create', [TeamController::class, 'create']);
    Route::post('/userPanel/team/store', [TeamController::class, 'store']);
    Route::get('/userPanel/team/{team}', [TeamController::class, 'show']);
    Route::get('/userPanel/teams', [TeamController::class, 'listing']);
    Route::get('/userPanel/team/{team}/destroy', [TeamController::class, 'destroy']);
    Route::get('/userPanel/team/{team}/leave', [TeamController::class, 'leaveTeam']);
    Route::get('/userPanel/team/{team}/send_request', [TeamController::class, 'sendRequest']);

    Route::get('/userPanel/team/{team}/action/delete/{user}', [TeamController::class, 'removeMember']);
    Route::get('/userPanel/team/{team}/action/setLeader/{user}', [TeamController::class, 'setLeader']);


    // teamRequests
    Route::get('/userPanel/teamRequest/{TeamRequest}/join', [TeamRequestController::class, 'join']);
    Route::get('/userPanel/teamRequest/{TeamRequest}/delete', [TeamRequestController::class, 'delete']);




});
