

@extends('layouts.userPanelLayout')

@section('content_nav')
Edytuj
@endsection

@section('content')

@if (isset($footwearError))
    <div class="form-error-msg">{{ $footwearError }}</div>
@endif



<div class="activity-container mt-20 bg-light border-light d-f fd-c p-20 w-100">

    <form action="{{ url('/userPanel/footwear/'.$shoe->id.'/edit') }}" method="POST" id="activit-form" enctype="multipart/form-data">
        @csrf

        <div class="form-row w-100">

            <div class="form-elem w-50">
                <label for="fw_name">Nazwa obuwia </label>
                <input class="input_button" type="text" id="fw_name" name="fw_name" value="{{ $shoe->name }}" required>    
            </div>

            <div class="form-elem w-50">
                <label for="fw_model">Model obuwia </label>
                <input class="input_button" type="text" id="fw_model" name="fw_model" value="{{ $shoe->model }}"> 
            </div>

        </div>

        <div class="form-row w-100">
            <div class="text-center w-100 section-title-txt"> Wybierz zdjęcię lub etykietę dla obuwia</div>
            
        </div>

        <div class="w-100 d-f jc-c ai-c mb-50">

            <div class="choice-top-check w-100 d-f jc-c">
                <input type="radio" name="choice-top" id="choice-top-img" value="img" required {{ $shoe->custom_foto ? 'checked' : '' }}>
            </div>

            <div class="choice-top-check w-100 d-f jc-c">
                <input type="radio" name="choice-top" id="choice-top-label" value="label" required {{ $shoe->custom_foto ? '' : 'checked' }}>
            </div>

        </div>

        <div class="form-row w-100 mt-30">

            <div class="form-elem w-50" id="fw-image-choice">

                
                <label for="fw_image" id="fw_upload_image">Dodaj zdjęcię ( max 50kb )</label>
                <input class="input_button" type="file" id="fw_image" name="fw_image" accept="image/png, image/jpeg, image/PNG, image/jpg">  
                
                <div class="w-100 mt-20 el-round" id="footwear-img-preview">
                    @php
                        $shoe_src = $shoe->custom_foto ? asset('storage/footwear_images/'. $shoe->image) : ''
                    @endphp
                    <img src="{{ $shoe_src }}" alt="">
                </div>

            </div>

            <div class="form-elem w-50" id="fw-label-choice">

                

                <label >Wybierz etykietę</label>
                <div class="d-f jc-se ai-c wrap fw_labels_cont">

                    @for($i=1 ; $i<=6 ; $i++)

                    @php
                        $name = "fw_label_".$i;

                    @endphp

                    <label for="{{$name}}" class="{{ $shoe->image == $name ? "active" : ''}}" ><img src="{{ asset('/images/footwear/labels/'.$name.'.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="{{$name}}" value="{{$name}}" {{ $shoe->image == $name ? 'checked' : ''}}>

                    @endfor

                    {{-- <label for="fw_label_1"><img src="{{ asset('/images/footwear/labels/fw_label_1.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_1" value="fw_label_1">
                    <label for="fw_label_2"><img src="{{ asset('/images/footwear/labels/fw_label_2.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_2" value="fw_label_2">
                    <label for="fw_label_3"><img src="{{ asset('/images/footwear/labels/fw_label_3.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_3" value="fw_label_3">
                    <label for="fw_label_4"><img src="{{ asset('/images/footwear/labels/fw_label_4.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_4" value="fw_label_4">
                    <label for="fw_label_5"><img src="{{ asset('/images/footwear/labels/fw_label_5.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_5" value="fw_label_5">
                    <label for="fw_label_6"><img src="{{ asset('/images/footwear/labels/fw_label_6.png') }}" alt="" loading="lazy"></label>
                    <input type="radio" name="fw_label" id="fw_label_6" value="fw_label_6"> --}}
                </div>

            </div>

        </div>

        <div class="d-f ai-c jc-s">
            <button type="submit" class="button_form">Zapis</button>
            <a href="{{ url('/userPanel/panel/') }}" class="button_back">Wstecz</a>
            {{-- <a href="{{ url('/userPanel/addActivity/') }}" class="button_back">Wyczyść</a> --}}
        </div>

    </form>

</div>


@endsection



@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
<script src="{{ asset('js/footWear.js') }}"></script>


@endsection