{{-- @dump($reports) --}}


@extends('layouts.userPanelLayout')


@section('content_nav')
Aktywności użytkownika {{ $user->name }}
@endsection


@section('resource_button')

@if ($user->isBanned)
<div class="w-100 mt-20 d-f jc-e ai-c">
    <a href="{{url('/admin/user/'.$user->id.'/unban')}}" class="challenge-add  d-f jc-sb ai-c">Odblokuj uzytkownika <span class="material-icon">lock_open_right</span></a>
</div>
@else
<div class="w-100 mt-20 d-f jc-e ai-c">
    <a href="{{url('/admin/user/'.$user->id.'/ban')}}" class="challenge-add  d-f jc-sb ai-c">Zablokuj uzytkownika <span class="material-icon">block</span></a>
</div>
@endif


@endsection


@section('content')



<div class="w-100 ">


    <div class="element-row profile-info-row w-100 d-f jc-sb ai-st relative">

        <div class="profile-section-50">
            <div class="profile-section-content">
                <p>
                    <span class="key">Imię</span> : {{ $user->name }}
                </p>

                <p>
                    @php
                        $joinDate = explode(' ', $user->created_at);
                        $joinDate = $joinDate[0];
                    @endphp
                    <span class="key">Data dołączenia</span> : {{ $joinDate}}
                </p>
                @if($team)
                <p>
                    <span class="key">Druzyna</span> : <a class="color-blue1" href="{{ url('userPanel/team/'.$team->id) }}" >{{ $team->nazwa }} </a>
                </p>
                @endif
            </div>
        </div>

        <div class="profile-section-50">

            <div class="admin-profile-holder profile-image-holder d-f jc-c ai-c {{ $user->data['iconType'] }}">
                {!! $user->data['iconContent'] !!}
            </div>

            <div class=""></div>

        </div>

    </div>


    <div class="w-full">

        <div class="element-100 newAc bg-light mt-50 p-10 el-round color-white" >

            <div class="newAc-header w-100 d-f">
                <div class="newAc-header-label label-small">LP</div>
                <div class="newAc-header-label">Data</div>
                <div class="newAc-header-label">Rodzaj</div>
                <div class="newAc-header-label label-wide">Tytuł</div>
                <div class="newAc-header-label">Czas trwania</div>
                <div class="newAc-header-label">Wartość</div>

            </div>

            <div class="newAc-content w-100 d-f fd-c pb-20">

                @if ($activities)

                    @foreach ($activities as $item)
                        <div class="newAc-content-row w-100 d-f mb-10">

                            <div class="newAc-content-field label-small">{{ $loop->index + 1}}</div>
                            <div class="newAc-content-field">{{ $item->add_date }}</div>
                            <div class="newAc-content-field d-f jc-fs ai-c">
                                <div class="activity-icon d-f jc-c ai-c mr-5"><img src="{{ asset('images/panel/icons/'.$item->activityType->slug.'_icon.png') }}" alt=""></div>
                                <div class="d-f jc-c ai-c p-0">
                                    <a href="{{ url('/userPanel/panel/summary/type' . $item->activity_type_id) }}">  {{ $item->activityType->name}}</a>
                                </div>
                            </div>
                            <a class="newAc-content-field label-wide" href="{{ url('/userPanel/panel/' . $item->id . '/view') }}"> {{ $item->title }}</a>
                            <div class="newAc-content-field">{{ $item->total_time }}</div>
                            <div class="newAc-content-field">{{ $item->value }}</div>


                        </div>
                    @endforeach

                @else
                    <div class="w-100 d-f jc-c mt-30">Brak aktywności do wyświetlenia</div>
                @endif

            </div>

        </div>


    </div>


    {{-- @foreach ($reports as $row )

        <div class="d-f jc-sb ai-c el-round bg-light p-20 mb-10">
            <div class="section-title-txt">{{ $row->user->name }} </div>

            <div>Data zgłoszenia: {{  $row->created_at }}</div>


            <a href="{{ url('admin/user/'.$row->user->id.'/view') }}" class="confirm-box-button"> Zobacz</a>
        </div>
    @endforeach --}}

</div>



@endsection



@section('assets')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
