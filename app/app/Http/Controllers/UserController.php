<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\ActivitiesType;
use App\Models\Footwear;
use App\Models\BanRequest;


class UserController extends Controller
{

    /**
     * Display a listing of the resource.
     */
     public function index()
    {

    }


    /**
     * Display the specified resource.
     */
    public function show(User $user = null)
    {
        $user = $user ?: Auth::user();
        // dd($user->team);
        // dd($user->id);

        $self_profile = (Auth::user() == $user) ? true : false;
        return view('profile.userProfile', [
            'userData'=> $user,
            'self' => $self_profile,
            'userID'=>$user->id,
            'team' => $user->team,
        ]);

    }


    public function sendBan(User $user){
        if(!$user) return redirect('userPanel/panel');

        $reqExists = BanRequest::where('user_id', $user->id)->first();

        if($reqExists) return redirect()->back()->with('message', 'Wysłano zgłoszenie');


        $ban = new BanRequest();
        $ban->user_id = $user->id;
        $ban->save();

        return redirect()->back()->with('message', 'Wysłano zgłoszenie');

    }


    public function edit(User $user)
    {

        if(Auth::user() != $user){
            return redirect('userPanel/panel')->with('message','Brak uprawnień do edycji tego profilu');
        }

    }


    public function editPhoto(Request $req){

        $user = Auth::user();
        // dd($req);
        if($req->hasFile('profile_img') && $req->file('profile_img')->isValid()){
            $file = $req->file('profile_img');

            $size = $file->getSize();
            if($size > 100000) return back()->with('message', 'Rozmiar zdjęcia jest zbyt duży');

            $file_name = 'profile-img-' . $user->id .'.'. $file->extension();
            $file->storeAs('public/userProfiles', $file_name);

            $user->photo = $file_name;
            $user->save();

            return redirect('userPanel/profile/view')->with('message', 'Dodano zdjęcie');
        }
        return redirect('userPanel/profile/view')->with('message', 'Wystapił problem ze zdjęciem, spróbuj ponownie');


    }


    public function loginPageOrRedirect(Request $req){

        if(Auth::check()){
            return redirect('/home')->with('message','Jesteś już zalogowany');
        }else{
            // return 'red';
            return view('login',['req'=>$req]);
        }
    }


    public function authenticateUserOrError(Request $request){


        $this->validate($request, [
            'email' => 'required|email',
            'haslo' => 'required',
        ]);

        // return'2';

        $remember_me = $request->has('remember') ? true : false;

        if(Auth::attempt(['email' => $request->get('email'), 'password' => $request->get('haslo')], $remember_me)){
            return redirect('/userPanel/panel')->with('message','Zalogowano Poprawnie');
        }


        return redirect('/login')->with('loginError','Niepoprawne dane logowania');

        // $request->session()->flash('flash', ['loginError' => ' dane logowania']);
        // ->with('loginError', 'Niepoprawne dane logowania')

    }

    public function registerUserOrError(Request $request){

        $this->validate($request, [
            'email' => 'required|email',
            'haslo' => 'required',
            'haslo2' => 'required',
            'name' => 'required',
            'login' => 'required',

        ]);

        // dd(1);

        // check if mail arleady exists " return back with msg
        $userExists = User::where('email', $request->get('email'))->first() ? true : false;
        if($userExists) return back()->with('loginError', 'Konto z takim adresem już istnieje');


        // check if nickname arleady exists " return back with msg
        $userExists = User::where('nickname', $request->get('nick'))->first() ? true : false;
        if($userExists) return back()->with('loginError', 'Konto z takim loginem już istnieje');

        // check password | return with message
        $password_diff = ($request->get('haslo') != $request->get('haslo') ) ? true : false;
        if($password_diff) return back()->with('loginError', 'Oba pola z hasłem muszą być takie same');


        $user = new User();
        $user->password = Hash::make($request->get('haslo'));
        $user->email = $request->get('email');
        $user->name =  $request->get('name');
        $user->save();

        // dd($user);

        Auth::login($user);
        return redirect('/userPanel/panel');

    }

    public function logOutUser(Request $req){
        Auth::logout();
        return redirect('/')->with('message', 'Poprawnie wylogowano');
    }


    public function summary(){

        $user = Auth::user();
        $user_all_activities = $user->userActivities()->get();


        $ac_types_data = []; // get info about activities types
        foreach (ActivitiesType::get() as $type) {
            $type_id = $type->id;
            $ac_types_data[$type_id]['model'] = $type;
            $ac_types_data[$type_id]['activities'] = $type->getActivitiesByUser($user->id)->get();
            $ac_types_data[$type_id]['ac_count'] = count($ac_types_data[$type_id]['activities']);

            $total_time = $total_val = 0;
            foreach ($ac_types_data[$type_id]['activities'] as $ac) {
                $total_time += $ac->total_time;
                $total_val += $ac->value;
            }

            $ac_types_data[$type_id]['total_time'] = $total_time;
            $ac_types_data[$type_id]['total_value'] = $total_val;

            $ac_types_data[$type_id]['avg_time'] = ($ac_types_data[$type_id]['ac_count'] > 0) ?  $total_time/$ac_types_data[$type_id]['ac_count'] : 0;
            $ac_types_data[$type_id]['avg_value'] = ($ac_types_data[$type_id]['ac_count'] > 0) ?  $total_val/$ac_types_data[$type_id]['ac_count'] : 0;

        }

        $activitiesByYearData = [];
        $activitiesYears = $user->userActivities()
        ->selectRaw('YEAR(add_date) as year')
        ->groupBy('year')
        ->orderBy('year', 'asc')
        ->get();


        foreach ($activitiesYears as $row) {
            // dd($year->year);
            $year = $row->year;
            $activitiesByYearData[$year]['ac_count'] = $user->userActivities()
            ->whereYear('add_Date', '=', $year)->count();

            $activitiesByYearData[$year]['ac_total_time'] = $user->userActivities()
            ->whereYear('add_Date', '=', $year)->sum('total_time');

            $activitiesByYearData[$year]['ac_avg_time'] = ($activitiesByYearData[$year]['ac_count'] > 0) ? $activitiesByYearData[$year]['ac_total_time'] / $activitiesByYearData[$year]['ac_count'] : 0 ;


            // dd($activitiesByYearData[$year]['ac_avg_time']);
        }

        $footwear = $type->getActivitiesByUser($user->id)
        ->select(DB::raw('COUNT(id) as fAmout'), 'footwear_id')
        ->where('footwear_id', '>', 0)
        ->groupBy('footwear_id')
        ->orderBy('fAmout')->get();


        foreach ($footwear as $f) {
            $f->setAttribute('model', $user->footwear->find($f->footwear_id));
        }

        // dd($activitiesByYearData);

        return view('profile.summary',[
            'userID' => $user->id,
            'ac_types_data' => $ac_types_data,
            'ac_by_year' => $activitiesByYearData,
        ]);
    }


    public function convertMinutesToDHM($minutes) {
        $days = floor($minutes / 1440);
        $minutes %= 1440;
        $hours = floor($minutes / 60);
        $minutes %= 60;

        return $days."d ".$hours."h ".$minutes."m";


    }

    public function summaryByType(ActivitiesType $ActivitiesType){

        $type = $ActivitiesType;

        $ac_types_dict = [
            'run' => ['sprint', 'km'],
            'gym' => ['fitness_center', ''],
            'walk' => ['directions_walk', 'km'],
            'swim' => ['pool', 'm']
        ];

        $type_label = $ac_types_dict[$type->slug];

        $user = Auth::user();

        $generaData = [];
        $activities = $type->getActivitiesByUser($user->id)->get();

        $generalData['count'] = count($activities);
        $generalData['value'] = $activities->sum('value');
        $generalData['avg_value'] =number_format($activities->avg('value'), 1) ;


        $time = $activities->sum('total_time');
        $generalData['time'] = $this->convertMinutesToDHM($time);

        $time = $activities->avg('total_time');
        $generalData['avg_time'] = $this->convertMinutesToDHM($time);

        $footwear = $type->getActivitiesByUser($user->id)
        ->select(DB::raw('COUNT(id) as fAmout'), 'footwear_id')
        ->where('footwear_id', '>', 0)
        ->where('activity_type_id', $type->id)
        ->groupBy('footwear_id')
        ->orderBy('fAmout')->get();


        foreach ($footwear as $f) {
            $f->setAttribute('model', $user->footwear->find($f->footwear_id));
        }

        // dd($footwear);


        // dump($generalData);
        return view('profile.summary_type', [
            'ac' => $type,
            'label'=> $type_label,
            'general' => $generalData,
            'footwear' => $footwear

        ]);


    }

}
