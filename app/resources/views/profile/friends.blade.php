
@extends('layouts.userPanelLayout')

@section('content_nav')

    Znajomi

@endsection


@section('content')


    {{-- @dump($friends)
    @dump($requests) --}}


    <div class="w-100">
        <div class=" friends-search-bar">
            Znajdź uzytkowników
            <div class="friend-search d-f jc-e ai-c ">
                <input type="text" id="name" name="name">
                <div class="material-button" id="friend-search-button"><span class="material-icon">search</span></div>
            </div>
        </div>

        <div class="friends-search-content relative">

            <div class="load display--none"></div>

            <div class="friends-search-inner">

                <x-friend-row :friend="null" :type="'user'" class="display--none" />
            </div>


        </div>

        <div class="stat-break"></div>

        <div class="w-100">
            <div class="generic-title">Lista znajomych</div>

            <div class="el-round w-100 p-20">


                @if(count($friends) > 0)
                    @foreach ($friends as $f )

                        <x-friend-row :friend="$f" :type="'friend'" />

                    @endforeach
                @else
                    <div class="w-100"> Brak danych do wyświetlenia</div>
                @endif

            </div>
        </div>
    </div>

@endsection


@section('assets')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">

<script src="{{asset('js/friends.js')}}"> </script>

@endsection
