

@extends('layouts.userPanelLayout')

@section('content_nav')
Dodaj nowe wyzwanie
@endsection

@section('content')

@if (isset($footwearError))
    <div class="form-error-msg">{{ $footwearError }}</div>
@endif


@php
    $panelActivityHelper = PanelActivityHelper::load();
    $ac_types = $panelActivityHelper->getAllActivitiesTypes();
@endphp

<div class="activity-container mt-20 bg-light border-light d-f fd-c p-20 w-100">


    <form action="{{ url('/userPanel/challenges/add') }}" method="POST" id="activit-form">
        @csrf
    
        <div class="form-row w-100">
    
            <div class="form-elem w-50">
    
                <label for="chall_type">Rodzaj wyzwania</label>
                <select name="chall_type" id="chall_type" class="input_button" data-selected="{{ $copy ? $copy->activityType->slug : ''}}" required>
                    <option>Wybierz opcję</option>
                    <option value="total-distance">Przebyty dystans</option>
                    <option data-per value="total-distance-per-type">Przebyty dystans w ...</option>
                    <option value="total-activities">Liczba treningów</option>
                    <option data-per value="total-activities-per-type">Liczba treningów w ...</option>
                    <option value="total-time">Łączny czas treningów</option>
                    <option data-per value="total-time-per-type">Łączny czas treningów w ...</option>
                </select>
    
            </div>
    

            <div class="form-elem w-50 display--none" id="chall_type_select">
    
                <label for="chall_type_option">Zaliczany rodzaj aktywności</label>
                <select name="chall_type_option" id="chall_type_option" class="input_button" data-selected="{{ $copy ? $copy->activityType->slug : ''}}">
                    <option value="0" selected >Wybierz typ aktywności</option>

                    @foreach ($ac_types as $type):

                        <option value="{{$type->id}}">{{$type->name}}</option>

                    @endforeach

                </select>
    
            </div>
            
    
        </div>

        <div class="form-row w-100">
    
            <div class="form-elem w-50">
                <label for="chall_name">Nazwa wyzwania</label>
                <input type="text" name="chall_name" id="chall_name" placeholder="Nazwa wyzwania" class="input_button" value="{{ $copy ? $copy->title : ''}}" required>
            </div>
    
            <div class="form-elem w-50">
                <label for="chall_value">Oczekiwana wartość [km / min / treningi]</label>
                <input type="text" name="chall_value" id="chall_value" placeholder="00" class="input_button" value="{{ $copy ? $copy->total_time : ''}}" required>
            </div>
    
    
        </div>


        <div class="form-row w-100">

            <div class="form-elem w-50">
                <label for="act_start">Data startu</label>
                <input class="input_button" type="date" id="chall_start" name="chall_start" value="{{ $copy ? $copy->start_date : ''}}" min="2020-01-01" max="2099-12-31">

            </div>

            <div class="form-elem w-50">
                <label for="act_start">Data końca</label>
                <input class="input_button" type="date" id="chall_end" name="chall_end" value="{{ $copy ? $copy->end_date : ''}}" min="2020-01-01" max="2099-12-31">

            </div>
        
        </div>

        <div class="form-row w-100">

            <div class="form-elem w-50 form-element-checkbox">
                <label for="chall_count_prev">Licz dotychczasowe treningi </label>
                <input class="input_button" type="checkbox" id="chall_count_prev" name="chall_count_prev" value="true"  {{ ($copy ? $copy->count_prev : '')}} >
                
            </div>

        </div>


     
    
        <div class="form-row w-100">
    
        <div class="form-elem w-100">
            <label for="chall_desc">Opis wyzwania</label>
            <textarea rows="5" cols="41" name="chall_desc" id="chall_desc" class="input_button" >{{ $copy ? $copy->description : ''}}</textarea>
        </div>
    
    
        </div>
    
    
    
        <div class="d-f ai-c jc-s">
            <button type="submit" class="button_form">Rozpocznij!</button>
            <a href="{{ url('/userPanel/panel/') }}" class="button_back">Wstecz</a>
            <a href="{{ url('/userPanel/challenges/add') }}" class="button_back">Wyczyść</a>
        </div>
    
    
    </form>


@endsection



@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
{{-- <script src="{{ asset('js/footWear.js') }}"></script> --}}


@endsection



@section('small_script')
{{-- <script> --}}

const type_selector = document.querySelector('#chall_type');
const chall_type = document.querySelector('#chall_type_select');
type_selector.addEventListener('change', ()=>{
    let selected = type_selector.value;
    let optionSelected = type_selector.options[type_selector.selectedIndex];
    if(optionSelected.hasAttribute('data-per')) { chall_type.classList.remove('display--none'); } else{ chall_type.classList.add('display--none');}
});
{{-- </script> --}}

@endsection