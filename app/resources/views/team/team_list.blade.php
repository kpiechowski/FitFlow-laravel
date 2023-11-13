{{-- @dump(get_defined_vars()) --}}

@extends('layouts.userPanelLayout')



@section('content_nav')


        Lista drużyn

@endsection


@section('resource_button')




@endsection


@section('content')


<div class="mt-20 w-100">

    <div class="listing-container ">
        <div class="listing-labels">
            <div class="switch-full-teams section-title-txt">
                <div class="team-full-checkbox"> </div> Ukryj pełne drużyny
            </div>

            <div class="team-search d-f jc-e ai-c">
                <input type="text">
                <div class="material-button"><span class="material-icon">search</span></div>
            </div>
        </div>

        <div class="stat-break"></div>

        <div class="bg-light el-round">

            @foreach ($teams as $t)

            {{-- @dump($t) --}}
            <div class="list_row " {{ $t->isTeamFull() ? 'data-full' : '' }}>

                <div class="team_img d-f">
                    <div class="list_img_field"><img src="{{ asset('storage/teams/'. $t->logo) }}" style="" class="" alt="" loading="lazy"></div>
                    <div class="team_name d-f jc-c fd-c ai-s">
                        <div class="section-title-txt "> {{ $t->nazwa }}</div>
                        <div> <span class="material-icon">social_leaderboard</span> {{ $t->leader->name }}</div>
                    </div>
                </div>

                {{-- @dd($t) --}}
                <div class="team_info">
                    <div class="d-f jc-c ai-c section-title-txt">
                        <span class="material-icon">groups</span> {{ $t->member_count }} / {{ $t->getMaxMember() }}
                    </div>
                    @if($t->isTeamFull())
                    <div class="text-center w-100 color-red text-up fontw-600">
                        brak miejsc
                    </div>
                    @endif
                </div>

                <div>
                    <a href="{{ url('userPanel/team/'.$t->id)  }}" class=" confirm-box-button"> Zobacz </a>
                </div>

            </div>

            @endforeach
        </div>

    </div>

</div>


@endsection

@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
{{-- <link rel="stylesheet" href="{{asset('css/profile.css')}}"> --}}

<link rel="stylesheet" href="{{asset('css/team.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

<script src="{{ asset('js/team.js') }}"></script>
@endsection
