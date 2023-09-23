
@extends('layouts.userPanelLayout')

@section('content_nav')

    @if($self)
        Profil 
    @else
        Profil użytkownika {{ $userData->name }}
    @endif

@endsection


@section('content')

@php
    $userHelper = UserHelper::load($userID);
    $currentUserData = $userHelper->getUserData();

    $monthStats = $userHelper->getUserMonthStats();
    // $monthStatsBySlug = $userHelper->getUserMonthStats($monthStats['month_user_top_activity']['slug']);
    // $monthStatsByType = $userHelper->getUserMonthStatsByType($monthStats['month_user_top_activity']['slug']);
    // dd($monthStats);

    $panelActivityHelper = PanelActivityHelper::load();
    $newActivities = $panelActivityHelper->getNewestUserActivities();
@endphp

    <div id="profile-container" class="mt-20 bg-light el-round  d-f fd-c p-20 w-100">
        <div class="element-row profile-portrait-row  w-100 d-f jc-e relative">
            <div class="profile-portrait">
                <div class="profile-image-holder d-f jc-c ai-c {{ $currentUserData['iconType'] }}">
                    {{ $currentUserData['iconContent'] }} 
                </div>
            </div>
        </div>

        <div class="element-row profile-info-row w-100 d-f jc-sb ai-st relative">

            <div class="profile-section-50">
                <div class="profile-section-title text-center">Informacje</div>
                <div class="profile-section-content">
                    <p>
                        <span class="key">Imię</span> : {{ $userData->name }} 
                    </p>

                    <p>
                        @php
                            $joinDate = explode(' ', $userData->created_at);
                            $joinDate = $joinDate[0];
                        @endphp
                        <span class="key">Data dołączenia</span> : {{ $joinDate}} 
                    </p>
                    <p>
                        <span class="key">Liczba treningów</span> : {{ $currentUserData['ac_count'] }} 
                    </p>
                    <p>
                        <span class="key">Łączny czas treningów</span> : {{ $currentUserData['total_time'] }} 
                    </p>
                </div>
            </div>

            <div class="profile-section-50">
                <div class="profile-section-title text-center">Drużyna</div>
                

                    @if ($userData->team_id !== NULL)
                    <div class="profile-section-content">
                        <p>
                            <span class="key">Imię</span> : {{ $userData->name }} 
                        </p>

                        <p>
                            <span class="key">Data dołączenia</span> : {{ $userData->created_at }} 
                        </p>
                        <p>
                            <span class="key">Liczba treningów</span> : {{ $currentUserData['ac_count'] }} 
                        </p>
                    </div>
                    @else
                        <div class="profile-no-team d-f jc-c ai-c">Użytkownik nie należy do żadnej drużyny</div>
                    @endif 

                   
                
            </div>

        </div>
 
    </div>


    <div class="element-row d-f jc-sb w-100 mt-80">
        <x-panel.newActivities :data="$newActivities" />
    </div>

    <div id="profile-stats" class="w-100 mt-80 relative">

        <div class="element-title w-100 d-f jc-sb ai-c">
            <div>Statystyki</div>
        </div>

        <div class="bg-light element-row el-round  p-20 w-100" data-aos="fade-up" data-aos-duration="1000">

            <div class="text-center w-100 d-f jc-c ai-c stat-row-title">Miesięczne</div>
            <div class="profile-stat-row w-100 d-f jc-c mt-50">
                <div class="profile-stat-el">

                    <div class="stat-icon"><img src="{{ asset('/images/panel/icons/calendar_icon.png') }}" alt="" loading="lazy"></div>
                    <div class="stat-el-title w-100">Liczba treningów</div>

                    <div class="stat-el-value">
                        {{ $monthStats['month_user_count']['value'] }}
                    </div>

                    <div class="stat-el-desc">
                        Więcej niż <span class="{{ $monthStats['month_user_count']['all_label'] }}">{{ $monthStats['month_user_count']['all_percent'] }}%</span> użytkowników  
                    </div>

                </div>

                <div class="profile-stat-el">

                    <div class="stat-icon"><img src="{{ asset('/images/panel/icons/podium_icon.png') }}" alt="" loading="lazy"></div>
                    <div class="stat-el-title w-100">Najczęstszy rodzaj aktywności</div>

                    <div class="stat-el-value">
                        <img src="{{ asset('/images/panel/icons/' .$monthStats['month_user_top_activity']['model']->slug. '_icon.png') }}" alt="" loading="lazy">
                    </div>

                    <div class="stat-el-desc">
                        {{ $monthStats['month_user_top_activity']['model']->name }}<br>
                        Zanotowano <span class="average">{{ $monthStats['month_user_top_activity']['count'] }}</span> 
                        
                        @php
                           $amountCount = $monthStats['month_user_top_activity']['count'];
                        //    $amountCount = 21;
                           if($amountCount == 0){

                           }elseif ($amountCount%10==1  && $amountCount < 10) {
                               echo 'trening';
                            
                            }elseif ($amountCount%10==1) {
                                echo 'treningów';
                            
                            }elseif ($amountCount%10 <5) {
                                echo 'treningi';
                            }else {
                                echo 'treningów';
                            }
                        @endphp
                        
                    </div>

                </div>

                
                <div class="profile-stat-el">

                    <div class="stat-icon"><img src="{{ asset('/images/panel/icons/timer_icon.png') }}" alt="" loading="lazy"></div>
                    <div class="stat-el-title w-100">Średni czas treningów</div>

                    @if ($monthStats['month_avg_time']['hours'] == 0)
                        <div class="stat-el-value med-value">
                            {{$monthStats['month_avg_time']['minutes']}}
                            <br>min
                        </div>
                    @else
                        <div class="stat-el-value small-value">
                            {{$monthStats['month_avg_time']['hours']}}h <br>
                            {{$monthStats['month_avg_time']['minutes']}}min
                        </div>
                    @endif

                    

                    <div class="stat-el-desc ">
                        Więcej niż <span class="{{ $monthStats['month_avg_time']['all_label'] }}"> {{ $monthStats['month_avg_time']['all_percent'] }}%</span> użytkowników  
                    </div>

                </div>
{{-- 
                <div class="profile-stat-el">

                    <div class="stat-icon"><img src="{{ asset('/images/panel/icons/timer_icon.png') }}" alt="" loading="lazy"></div>
                    <div class="stat-el-title w-100">Średni czas jednego treningu [min]</div>

                    <div class="stat-el-value">
                        32
                    </div>

                    <div class="stat-el-desc ">
                        Więcej niż <span class="average">{{ $monthStats['month_avg_time']['all_percent'] }}%</span> użytkowników  
                    </div>

                </div> --}}
            </div>  

            <div class="text-center w-100 d-f jc-c ai-c stat-row-title"><b><a href="{{ url('/userPanel/summary/') }}">Zobacz podsumowanie</a></b></div>
            {{-- <div class="w-100 d-f jc-c mt-50">

                <div class="profile-stat-el">

                    <div class="stat-icon"><img src="{{ asset('/images/panel/icons/calendar_icon.png') }}" alt="" loading="lazy"></div>
                    <div class="stat-el-title w-100">Łączna liczba treningów</div>

                    <div class="stat-el-value">
                        {{ 40 }}
                    </div>

                    <div class="stat-el-desc">
                        Więcej niż <span class="above">{{ 70 }}%</span> użytkowników  
                    </div>

                </div>

            </div> --}}

        </div>

    </div>

    

@endsection


@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
<link rel="stylesheet" href="{{asset('css/profile.css')}}">


@endsection