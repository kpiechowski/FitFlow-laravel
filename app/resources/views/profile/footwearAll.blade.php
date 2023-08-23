




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

