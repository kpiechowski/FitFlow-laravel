




@extends('layouts.userPanelLayout')

@section('content_nav')
Moje buty:
@endsection

@section('content')


    @php
        // dd($footwear);
    @endphp

        <div class="footwear-full-wrapper --scrollable w-100 d-f mt-20">

            @foreach ($footwear as $shoe)
                
                    <x-panel.footwearElement :shoe="$shoe" />
                
            @endforeach

        </div>

@endsection



@section('assets')
    <link rel="stylesheet" href="{{asset('css/profile.css')}}">

@endsection


@section('small_script')

console.log('el');
document.querySelectorAll('.footwear-option-delete').forEach(el=>{
    el.addEventListener('click', function(e){
        e.preventDefault();
        panel_controller.openConfirmBox(el.getAttribute('href'), "Czy na pewno chcesz usunąć ten element?");
    });
});

@endsection