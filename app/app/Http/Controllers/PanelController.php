<?php

namespace App\Http\Controllers;
use App\Models\UserActivity;
use App\Models\Notification;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\UserActivityController;

class PanelController extends Controller
{
    //

    public function __invoke(){
        // dd(1);

        $user = Auth::user();

        return view('userPanel', [
            'latest'=> UserActivityController::get_latest_activity(),
            'allActivities' => UserActivityController::index_list(),


        ]);
    }
}
