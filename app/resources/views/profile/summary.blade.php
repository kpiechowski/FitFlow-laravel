
@extends('layouts.userPanelLayout')

@section('content_nav')

    Statystyki

@endsection


@section('content')

@php
    $userHelper = UserHelper::load($userID);
    $currentUserData = $userHelper->getUserData();
    $panelActivityHelper = PanelActivityHelper::load();
    $newActivities = $panelActivityHelper->getNewestUserActivities();


    $ac_types_dict = [
        'run' => ['sprint', 'km'],
        'gym' => ['fitness_center', ''],
        'walk' => ['directions_walk', 'km'],
        'swim' => ['pool', 'm']
    ];

@endphp

    <div class="element-100 mt-40 bg-light p-20 generic-wrapp">

        <div class="generic-title">Statystyki ogólne</div>

        <div class="w-100 generic-el-wrapper d-f jc-sb">

            <div class="generic-el">
                <div class="generic-value">{{ $currentUserData['ac_count'] }} </div>
                <div class="generic-txt">Łączna liczba treingów</div>
            </div>

            <div class="generic-el">
                <div class="generic-value">--</div>
                <div class="generic-txt small">Średnia liczba treningów w miesiącu</div>
            </div>

            <div class="generic-el">
                <div class="generic-value small">{{ $currentUserData['total_time'] }} </div>
                <div class="generic-txt">Łączny zanotowany czas treningów</div>
            </div>

            <div class="generic-el">
                <div class="generic-value">000</div>
                <div class="generic-txt">---------</div>
            </div>


        </div>


        <div class="stat-break"></div>

        <div class="w-100 d-f jc-c ai-c wrap relative mt-0">

            <div class="w-100 generic-chart-top d-f jc-sb ai-c">
                <div class="w-100 d-f jc-sb ai-c chart-title">
                    Miesięczna aktywność treningowa
                </div>

                <div class="d-f jc-c ai-c wrap generic-chart-config">

                    <div class="date-info-open w-100">
                        Zmień
                        <span class="material-icon">date_range</span>
                        <div class="date-config-popup display--non">

                            <div class="w-100 d-f jc-c ai-c" id="date-pick-start">
                                <label for="generic-start-date"><span class="material-icon">line_start_square</span></label>

                                <input type="number" value="{{ date('Y') }}" min="2022" max="{{ date('Y') }}" id="generic-start-date-year">
                                <input type="number" value="{{ date('1') }}" min="01" max="12" id="generic-start-date-month">
                            </div>

                            <div class="w-100 d-f jc-c ai-c">
                                <label for="generic-start-date"><span class="material-icon">line_end_square</span></label>
                                <input type="number" value="{{ date('Y') }}" min="{{ date('Y') }}" max="{{ date('Y') + 2 }}" id="generic-end-date-year">
                                <input type="number" value="12" min="02" max="12" id="generic-end-date-month">
                            </div>

                            <div class="w-100 d-f jc-c ai-c" id="generic-apply">
                                <span class="material-icon">edit_calendar</span>Zapisz
                            </div>

                        </div>
                    </div>


                </div>

            </div>


            <div id="chart-all-ac-timeline" class="chart-container w-100 mt-50">
                <div class="load"></div>
                <canvas class="w-100" styles="aspect-ratio:1500/800;" width="1100" height="400"></canvas>
            </div>
        </div>

        <div class="stat-break"></div>

        <div class="w-100">

            <div class="generic-title">Podsumowanie poszczegółnych aktywności</div>

            @foreach ($ac_types_data as $AC)

                <div class="ac-stat">

                    <div class="w-100 ac-row-title d-f jc-sb ai-c ">
                        <div class="ac-row-name">{{ $AC['model']->name }}: </div>

                        <div class="ac-row-icon d-f jc-c ai-c">
                            <span class="material-icon"> {{ $ac_types_dict[$AC['model']->slug][0] }} </span>
                        </div>

                    </div>

                    <div class="ac-stat-row d-f jc-sb ai-e">
                        <div class="ac-stat-name">Liczba treningów:</div>
                        <div class="ac-stat-line"></div>
                        <div class="ac-stat-value">{{ $AC['ac_count'] }}</div>
                    </div>

                    <div class="ac-stat-row d-f jc-sb ai-e">
                        <div class="ac-stat-name">Łączny czas treningów:</div>
                        <div class="ac-stat-line"></div>
                        <div class="ac-stat-value">{{ $userHelper->convertMinutesToDHM($AC['total_time']) }}</div>
                    </div>

                    <div class="ac-stat-row d-f jc-sb ai-e">
                        <div class="ac-stat-name">Średni czas treningów:</div>
                        <div class="ac-stat-line"></div>
                        @php
                            $avg_time = $userHelper->convertMinutesToHoursAndMinutes($AC['avg_time']);
                        @endphp
                        <div class="ac-stat-value">{{ $avg_time['hours'].'h '.$avg_time['minutes'].'min'}}</div>
                    </div>

                    @if ($AC['total_value'] > 0)
                        <div class="ac-stat-row d-f jc-sb ai-e">
                            <div class="ac-stat-name">Łączny dystans</div>
                            <div class="ac-stat-line"></div>
                            <div class="ac-stat-value">{{ $AC['total_value'] }} {{ $ac_types_dict[$AC['model']->slug][1] }}</div>
                        </div>

                        <div class="ac-stat-row d-f jc-sb ai-e">
                            <div class="ac-stat-name">Średni dystans treningu</div>
                            <div class="ac-stat-line"></div>
                            <div class="ac-stat-value">{{ round($AC['avg_value'], 1) }} {{ $ac_types_dict[$AC['model']->slug][1] }}</div>
                        </div>

                    @endif

                </div>

            @endforeach

        </div>

    </div>


    <div class="element-100 mt-80 types_summary">
        {{-- <div class="element-title w-100 d-f jc-sb ai-c">
            <div>Statystyki według rodzaju aktywności</div>
        </div> --}}
        <div class="generic-title">Statystyki według rodzaju aktywności</div>
        <div class="w-100 d-f jc-c ai-c wrap ac_types_wrapper">

            @foreach ($ac_types_data as $data)

            <div class="ac_type_box bg-light p-10 {{ $data['ac_count'] == 0 ? 'el-disable':'' }}" >
                <div class="ac_type_icon d-f jc-c ai-c">
                    <span class="material-icon"> {{ $ac_types_dict[$data['model']->slug][0] }} </span>
                </div>
                <div class="ac_name">{{ $data['model']->name }}</div>
                <a href="{{ url('userPanel/summary/type/'.$data['model']->id) }}" class="ac_type_button">Zobacz</a>
                <div class="ac_info w-100 text-center">Łączna liczba treningów: <span>{{$data['ac_count'] }}</span> </div>
            </div>

            @endforeach

        </div>
    </div>

    <div class="element-100 mt-80 bg-light p-20 generic-wrapp year_summary relative">
        <div class="generic-title">Statystyki roczne</div>
        <div class="year-slider-arrows w-100">
            <span class="material-icon" id="year-slider-prev">arrow_back</span>
            <span class="material-icon" id="year-slider-next">arrow_forward</span>
        </div>

        <div class="year-summary-slider-wrapper">


            @foreach ($ac_by_year as $year => $data)

                <div class="element-100 year-summary-wrapp p-20 " data-index="{{ $loop->iteration - 1}}" data-year="{{$year}}">

                    <div class="year-summary-year">{{ $year }}</div>

                    <div class="w-50">

                        <div class="ac-stat-row d-f jc-sb ai-e">
                            <div class="ac-stat-name">Liczba treningów</div>
                            <div class="ac-stat-line"></div>
                            <div class="ac-stat-value">{{$data['ac_count']}}</div>
                        </div>

                        <div class="ac-stat-row d-f jc-sb ai-e">
                            <div class="ac-stat-name">Łączny czas treningów</div>
                            <div class="ac-stat-line"></div>
                            <div class="ac-stat-value">{{ $userHelper->convertMinutesToDHM($data['ac_total_time']) }}</div>
                        </div>

                        <div class="ac-stat-row d-f jc-sb ai-e">
                            <div class="ac-stat-name">Średni czas treningów </div>
                            <div class="ac-stat-line"></div>
                            <div class="ac-stat-value">{{ $userHelper->convertMinutesToDHM($data['ac_avg_time']) }}</div>
                        </div>

                    </div>

                    <div class="stat-break"></div>

                    <div class="element-row d-f jc-sb w-100 mt-80">
                        <x-panel.statChars />
                    </div>

                </div>

            @endforeach

        </div>

    </div>


@endsection


@section('assets')

{{-- <link rel="stylesheet" href="{{asset('css/activityForm.css')}}"> --}}
<link rel="stylesheet" href="{{asset('css/profile.css')}}">

<script src="{{ asset('js/chart.umd.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js/dist/chart.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns/dist/chartjs-adapter-date-fns.bundle.min.js"></script>



<link rel="stylesheet" href="https://unpkg.com/datepicker.js/dist/datepicker.min.css">
<script src="https://unpkg.com/datepicker.js"></script>

<script src="{{asset('js/siema.min.js')}}"></script>

<script src="{{asset('js/summary.js')}}"></script>



@endsection

