<?php

namespace App\Http\Controllers;

use App\Models\TeamRequest;
use App\Http\Requests\StoreTeamRequestRequest;
use App\Http\Requests\UpdateTeamRequestRequest;

class TeamRequestController extends Controller
{
    public function delete(TeamRequest $TeamRequest){

        if(!$TeamRequest) return;
        $this->authorize('isAuthorized', $TeamRequest);

        $TeamRequest->status = 'rejected';
        $TeamRequest->save();

        $user = $TeamRequest->user;
        $team = $TeamRequest->team;
        NotificationController::create_team_reject_entry($team, $user);
    }

    public function join(TeamRequest $TeamRequest ){

        // dd($TeamRequest);
        $this->authorize('isAuthorized', $TeamRequest);

        $user = $TeamRequest->user;
        $team = $TeamRequest->team;

        if($user->team_id !== null) return;

        $user->team_id = $team->id;
        $user->save();

        $TeamRequest->status = "accepted";
        $TeamRequest->save();

        NotificationController::create_team_join_entry($team, $user);

    }

}
