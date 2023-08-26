<?php

namespace App\Http\Controllers;

use App\Models\Footwear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Models\User;

class FootwearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $user = Auth::user();
        $footwears = $user->footwear()->get();

        
        return view('profile.footwearAll', ['footwear' => $footwears]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('profile.footwearAdd');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // dd(Auth::user()->id);

        $name = $request->get('fw_name');
        $model = ($request->get('fw_model') != '') ? $request->get('fw_model') : 'brak';

        $img_choice = $request->get('choice-top');

        if($img_choice == 'img'){
            // dd($request->file('fw_image')->getClientOriginalName());
            if($request->hasFile('fw_image') && $request->file('fw_image')->isValid()) {
                $fw_file =  $request->file('fw_image');
                $fw_img = $fw_file->getClientOriginalName();
                $fw_img_size = $fw_file->getSize();


                if($fw_img_size > 60000){
                    return back()->with('message', 'Rozmiar zdjęcia jest zbyt duży')->withInput();
                }

                $fw_file_name = Auth::user()->id . '-' . $fw_img;
                $custom_foto = 1;
                // dodać zabezpieczenie na rozmiar i wielkośc zdjęcia
                $request->file('fw_image')->storeAs('public/footwear_images', $fw_file_name);
                

            }
        }else{
            $custom_foto = 0;
            $fw_file_name = $request->get('fw_label');

        }
        
        $FW = new Footwear();
        $FW->name = $name;
        $FW->model = $model;
        $FW->custom_foto = 
        $FW->user_id = Auth::user()->id;
        $FW->image = $fw_file_name;

        $FW->save();

        return redirect('userPanel/footwear')->with('message', 'Dodano obuwie do profilu');

    }

    /**
     * Display the specified resource.
     */
    public function show(Footwear $footwear)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Footwear $footwear)
    {
        //
        // dd($footwear);
        if($footwear && $footwear->user_id == Auth::user()->id){
            return view('profile.footwearEdit', ['shoe'=> $footwear]);
        }else{
            return redirect('userPanel/panel');
        }

    }
    
    // $footwear = Footwear::find()
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, Footwear $footwear)
    {
        //
        $footwear->name = $req->get('fw_name');
        $footwear->model = $req->get('fw_model');

        $img_choice = $req->get('choice-top');

        if($img_choice == 'img'){
            // dd($request->file('fw_image')->getClientOriginalName());
            $custom_foto = 1;
            if($req->hasFile('fw_image') && $req->file('fw_image')->isValid()) {
                $fw_file =  $req->file('fw_image');
                $fw_img = $fw_file->getClientOriginalName();
                $fw_img_size = $fw_file->getSize();


                if($fw_img_size > 60000){
                    return back()->with('message', 'Rozmiar zdjęcia jest zbyt duży')->withInput();
                }

                $fw_file_name = Auth::user()->id . '-' . $fw_img;
                // dodać zabezpieczenie na rozmiar i wielkośc zdjęcia
                $req->file('fw_image')->storeAs('public/footwear_images', $fw_file_name);
                $footwear->image = $fw_file_name;
                

            }
        }else{
            $custom_foto = 0;
            $fw_file_name = $req->get('fw_label').'.png';
            $footwear->image = $fw_file_name;

        }

        $footwear->custom_foto = $custom_foto;

        $footwear->save();

        return redirect('userPanel/footwear')->with('message', 'Pomyślnie zapisano');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Footwear $footwear)
    {
        //
    }
}
