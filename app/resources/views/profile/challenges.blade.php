@extends('layouts.userPanelLayout')

@section('content_nav')
Wyzwania
@endsection

@section('resource_button')

<div class="w-100 mt-20 d-f jc-e ai-c">
    <a href="{{url('userPanel/challenges/add/')}}" class="challenge-add d-f jc-sb ai-c">Dodaj nowe wyzwanie <span class="material-icon">add_circle</span></a>
</div>
@endsection

@section('content')


@php
    $panelActivityHelper = PanelActivityHelper::load();

@endphp




<div class="w-100 mt-50">
    <div class="challenge-title">Aktywne wyzwania</div>
</div>

<div class="challenge-wrapper w-100 mt-50">

    @if ($onGoing->isEmpty())
        <div class="challenge-empty w-100 p-40">Brak wyzwań do wyświetlenia</div>
    @else
        @foreach ($onGoing as $chall)
            <x-panel.challenge :obj="$chall" :panelHelper="$panelActivityHelper" />
        @endforeach
    @endif

</div>

<div class="w-100 mt-50">
    <div class="challenge-title">Ukończone wydarzenia</div>
</div>

<div class="challenge-wrapper w-100 mt-20">

    @if ($completed->isEmpty())
        <div class="challenge-empty w-100 p-40">Brak wyzwań do wyświetlenia</div>
    @else 
        @foreach ($completed as $chall)
            <x-panel.challenge :obj="$chall" :panelHelper="$panelActivityHelper" />
        @endforeach
    @endif

</div>

<div class="w-100 mt-50">
    <div class="challenge-title">Stare wydarzenia</div>
</div>

<div class="challenge-wrapper w-100 mt-20">

    @if ($expired->isEmpty())
        <div class="challenge-empty w-100 p-40">Brak wyzwań do wyświetlenia</div>
    @else
        @foreach ($expired as $chall)
            <x-panel.challenge :obj="$chall" :panelHelper="$panelActivityHelper" />
        @endforeach
    @endif

</div>




@endsection


@section('assets')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection