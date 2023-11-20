<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Http\RedirectResponse;

use App\Models\User;
use App\Models\BanRequest;

class AdminController extends Controller
{
    //


    public function reports(){

        $reports = BanRequest::get();

        foreach($reports as $r){
            $r->setAttribute('user', $r->user);
        }

        return view('admin.reports', ['reports' => $reports]);

    }


    public function userView(User $user){

        $user->setAttribute('data', $user->getUserData());
        $activities = $user->userActivities;

        $team = $user->team;

        foreach ($activities as $ac) {
            $ac->setAttribute('ac_type', $ac->activityType);
        }

        return view('admin.userView', ['user'=> $user, 'activities' => $activities, 'team'=>$team]);
    }


    public function banUser(User $user){

        $req = BanRequest::where('user_id', $user->id)->first();
        // dd($req);
        if($req) $req->delete();

        $user->isBanned = true;
        $user->save();

        return redirect()->back()->with('message', 'Uzytkownik został zablokowany');

    }

    public function unbanUser(User $user){

        $user->isBanned = false;
        $user->save();

        return redirect()->back()->with('message', 'Uzytkownik został odblokowany');

    }


    public function userList(){

        $users = User::paginate(10);

        foreach ($users as $u) {
            $u->setAttribute('data', $u->getUserData());
            $u->setAttribute('ac', $u->userActivities->sortByDesc('created_at')->first());
        }

        return view('admin.users', ['data' => $users, 'title'=> "Lista użytkowników"]);

    }

    public function blockedList(){

        $users = User::where('isBanned', 1)->paginate(10);

        foreach ($users as $u) {
            $u->setAttribute('data', $u->getUserData());
            $u->setAttribute('ac', $u->userActivities->sortByDesc('created_at')->first());
        }

        return view('admin.users', ['data' => $users, 'title'=>"Użytkownicy zablokowani"]);

    }
}
