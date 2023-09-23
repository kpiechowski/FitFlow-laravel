<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

use App\Models\User;
use App\Models\ActivitiesType;


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
        // dd($user);
        $user = $user ?: Auth::user();
        // dd($user->id);

        $self_profile = (Auth::user() == $user) ? true : false;
        return view('profile.userProfile', ['userData'=> $user, 'self' => $self_profile, 'userID'=>$user->id]);

    }


    public function edit(User $user)
    {
        
        if(Auth::user() != $user){
            return redirect('userPanel/panel')->with('message','Brak uprawnień do edycji tego profilu');
        }

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
        // dd($ac_types_data);

        return view('profile.summary',[
            'userID' => $user->id,
            'ac_types_data' => $ac_types_data,
        ]);
    }

}
