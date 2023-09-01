<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\Authenticate;
use Illuminate\Http\RedirectResponse;

use App\Models\User;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserActivityController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\FootwearController;
use App\Http\Controllers\PersonalChallengeController;


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

Route::middleware([Authenticate::class])->group(function () {

    Route::get('/logout', [UserController::class, 'logOutUser']);

    Route::get('/test', function(){
        return 'lol';
    });


    Route::any('/home1', function(){
        return view('homePage', []);
    })->name('home1');


    Route::get('/userPanel/panel/', PanelController::class );

    Route::get('/userPanel/addActivity/{id?}', [UserActivityController::class, 'create'] );
    Route::post('/userPanel/addActivity/', [UserActivityController::class, 'store'] );

    Route::get('/userPanel/panel/{id}/edit', [UserActivityController::class, 'edit'] );
    
    // calendar
    Route::get('/userPanel/calendar/', [UserActivityController::class, 'index_calendar'] );


    // fetch urls for panel
    Route::get('/userPanel/panel/getUserActivityJson/{month}', [UserActivityController::class, 'getJsonByMonth']);
    Route::get('/userPanel/panel/getUserActivityTypesChart/{year?}', [UserActivityController::class, 'getYearActivityCountPerType']);
    Route::get('/userPanel/panel/getUserActivityPerMonthChart/{year?}', [UserActivityController::class, 'getYearActivityCountPerMonth']);


    // notifications
    Route::get('/userPanel/notification/view/{notification:id}', [NotificationController::class, 'show'] );
    Route::get('/userPanel/notification/view/', [NotificationController::class, 'index'] );

    // footwear
    Route::get('/userPanel/footwear/add/', [FootwearController::class, 'create'] );
    Route::post('/userPanel/footwear/add/', [FootwearController::class, 'store'] );
    Route::get('/userPanel/footwear/{footwear}/edit', [FootwearController::class, 'edit'] );
    Route::post('/userPanel/footwear/{footwear}/edit', [FootwearController::class, 'update'] );
    Route::get('/userPanel/footwear/', [FootwearController::class, 'index'] );
    Route::get('/userPanel/footwear/{footwear}/delete', [FootwearController::class, 'destroy'] );

    // user profile

    Route::get('/userPanel/profile/{user:nickname}/view', [UserController::class, 'show']);
    Route::get('/userPanel/profile/view', [UserController::class, 'show']);


    // personal challenges

    Route::get('userPanel/challenges/', [PersonalChallengeController::class, 'index']);
    Route::get('userPanel/challenges/add', [PersonalChallengeController::class, 'create']);
    Route::post('userPanel/challenges/add', [PersonalChallengeController::class, 'store']);
});
