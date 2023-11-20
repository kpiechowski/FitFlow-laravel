{{-- @dump($reports) --}}


@extends('layouts.userPanelLayout')


@section('content_nav')
Zgłoszenia
@endsection





@section('content')



<div class="w-100 ">

    @foreach ($reports as $row )

        <div class="d-f jc-sb ai-c el-round bg-light p-20 mb-10">
            <div class="section-title-txt">{{ $row->user->name }} </div>

            <div>Data zgłoszenia: {{  $row->created_at }}</div>


            <a href="{{ url('admin/user/'.$row->user->id.'/view') }}" class="confirm-box-button"> Zobacz</a>
        </div>
    @endforeach

</div>



@endsection



@section('assets')
<link rel="stylesheet" href="{{asset('css/profile.css')}}">
@endsection
