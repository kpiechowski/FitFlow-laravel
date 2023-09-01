<?php

namespace App\Http\Controllers;

use App\Models\PersonalChallenge;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class PersonalChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('profile.challenges', 
        [
            'onGoing' => Auth::user()->activeChallenges()->get(),
            'completed' => Auth::user()->completeChallenges()->get(),
            'expired' => Auth::user()->expiredChallenges()->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profile.challengeForm', ['copy'=>false]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validator = Validator::make(
            $request->all(),
            [
                'chall_type'=> 'required',
                'chall_name'=> 'required',
                'chall_value'=> 'required|numeric',
                'chall_start'=> 'required|date',
                'chall_end'=> 'required|date',

            ]
        );

        if($validator->passes()){

            $chall = new PersonalChallenge();

            $chall->type = $request->get('chall_type');
            $chall->title = $request->get('chall_name');
            $chall->goal_value = $request->get('chall_value');
            $chall->current_value = 0;
            $chall->start_date = $request->get('chall_start');
            $chall->end_date = $request->get('chall_end');
            $chall->user_id = Auth::user()->id;
            $chall->complete = 0;
            $chall->expired = 0;
            $chall->description = $request->get('chall_desc');
            
            $chall->allowed_activity = $request->get('chall_type_option');

            if( $chall->start_date >= $chall->end_date){
                return redirect('/userPanel/challenges/add')->with('message', 'Wprowadzono niepoprawną datę końca lub startu');
            }


            $chall->save();

            if($request->has('chall_count_prev')) $chall->updateByPreviousActivities();

            return redirect('/userPanel/challenges')->with('message', 'Pomyślnie dodano wyzwanie. Powodzenia!');
            
        }else{
            return redirect('/userPanel/challenges/add')->with('message', 'Wystąpił błąd, spróbuj ponownie');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(PersonalChallenge $personalChallenge)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PersonalChallenge $personalChallenge)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PersonalChallenge $personalChallenge)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PersonalChallenge $personalChallenge)
    {
        //
    }
}
