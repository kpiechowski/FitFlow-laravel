<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Team;
use App\Models\User;
use App\Models\TeamRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

use App\Http\Controllers\NotificationController;

class TeamController extends Controller
{
    //

    public function listing(){
        // dd('jebać');
        // return view('team.create');

        $teams = Team::get();

        foreach ($teams as $t){
            $t->setAttribute('member_count', count($t->users));
            $t->setAttribute('leader', User::find($t->leader_id));

        }

        return view('team.team_list', ['teams'=> $teams, 'hasTeam'=>Auth::user()->team_id !== null]);
    }

    public function create(){

        return view('team.create',[
            'dupa' =>'dupa',
            'copy' =>false,
            'action' => 'userPanel/team/store'
        ]);
    }


    public function store(Request $req){
        $validator = Validator::make(
            $req->all(),
            [
                'nazwa'=> 'required|unique:teams',
                'desc' => 'required',
            ]
            );

        if($validator->passes()){

            $name =  $req->get('nazwa');
            $desc =  $req->get('desc');

            // dd(Team::where('nazwa', $name)->first());
            if(Team::where('nazwa', $name)->first()){
                return back()->with('message', 'Podana nazwa drużyny jest już zajęta')->withInput();
            }

            // img
            // dd($req);
            if($req->hasFile('fw_image') && $req->file('fw_image')->isValid()) {

                $fw_file =  $req->file('fw_image');
                $fw_img = $fw_file->getClientOriginalName();
                $fw_img_size = $fw_file->getSize();

                if($fw_img_size > 200000){
                    return back()->with('message', 'Rozmiar zdjęcia jest zbyt duży')->withInput();
                }



                $req->file('fw_image')->storeAs('public/teams', $name.'-logo');
                $logo = $name.'-logo';

            }else{

                return back()->with('message', 'Wystapił problem z zdjęciem, spróbuj ponownie.')->withInput();
            }


            $team = new Team();
            $team->nazwa = $name;
            $team->logo = $logo;
            $team->opis = $desc;
            $team->leader_id = Auth::user()->id;
            $team->save();

            Auth::user()->team_id = $team->id;
            Auth::user()->save();

            return redirect('userPanel/team/'.$team->id)->with('message', 'Poprawnie utworzono drużynę');
        }else{
            return redirect()->back()->with('message', 'Nazwa druzyny jest już zajęta lub nie wypełniono wszystkich pól')->withInput();
        }

    }


    public function show(Team $team){

        // $team = Auth::user()->team();

        // dump($team);
        $isLeader = $team->leader_id == Auth::user()->id;
        $isMember = Auth::user()->team_id == $team->id;

        $existingRequest = TeamRequest::where('user_id', Auth::user()->id)
                            ->where('team_id', $team->id)
                            ->where('status', 'send')
                            ->first();



        $requests = $team->activeTeamRequests;
        foreach ($requests as $req) {
            $req->setAttribute('user', User::find($req->user_id));
        }

        // dump();
        // dump(Auth::user()->team);

        return view('team.index', [
            'isLeader' => $isLeader,
            'isMember'=> $isMember,
            'userHasTeam' => Auth::user()->team_id !== null,
            'leader' => User::find($team->leader_id),
            'team' => $team,
            'team_members' =>  $team->users,
            'team_info' => $team->getTeamData(),
            'user' => Auth::user(),
            'req_send' => ($existingRequest) ? true : false,
            'requests' => $requests,
         ]);

    }


    public function leaveTeam(Team $team){
        $this->authorize('leave', $team);

        Auth::user()->team_id = null;
        Auth::user()->save();
    }

    public function sendRequest(Team $team){
        // dump($team);

        $user = Auth::user();
        if($user->team_id !== null) return redirect('userPanel/team/'.$user->team_id)->with('message', 'Należysz już do drużyny');


        $existingRequest = TeamRequest::where('user_id', $user->id)
                            ->where('team_id', $team->id)
                            ->where('status', 'send')
                            ->first();


        if($existingRequest) return redirect('userPanel/team/'.$user->team_id)->with('message', 'Wysłałeś już prośbę o dołączenie. Poczekaj na odpowiedź');


        $req = new TeamRequest();
        $req->status = 'send';
        $req->team_id = $team->id;
        $req->user_id = $user->id;
        $req->save();

        NotificationController::create_team_request_entry($team, $user);

        return redirect()->back()->with('message', 'Wysłano prośbę o dołączenie');


    }


    public function removeMember(Team $team, User $user){
        $this->authorize('delete', $team);

        $user->team_id = null;
        $user->save();

        return redirect()->back()->with('message', 'Użytkownik '.$user->name . ' został usunięty z drużyny');
    }

    public function setLeader(Team $team, User $user){
        $this->authorize('delete', $team);

        // $currentLeader = User::find($team->leader_id);

        $team->leader_id = $user->id;
        $team->save();

        return redirect()->back()->with('message', 'Użytkownik '.$user->name . ' liderem drużyny');
    }


    public function destroy(Team $team){

        $this->authorize('delete', $team);


        Auth::user()->team_id = null;
        Auth::user()->save();
        $team->delete();
        return redirect('userPanel/panel')->with('message', 'Poprawnie usunięto drużynę');
    }



}
