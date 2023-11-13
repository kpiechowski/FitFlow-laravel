@extends('layouts.userPanelLayout')

@section('content_nav')
Stwórz drużynę
@endsection


@section('content')

<div class="activity-container mt-20 bg-light border-light d-f fd-c p-20 w-100">

    <div class="element-row d-f jc-sb  w-100 ai-st" data-aos="fade-up" data-aos-duration="1000">
        {{-- <x-activityForm :date="$date" :types="$types" :copy="$copy" :footwear="$footwear" :action="$action" />
         --}}
         <form action="{{ url($action) }}" enctype="multipart/form-data" method="POST" id="activit-form" class="w-100">
            @csrf


            <div class="form-row w-100">
                <div class="form-elem w-50">

                </div>
                <div class="form-elem w-50">
                    <label for="act_name">Nazwa drużyny</label>
                    <input type="text" name="nazwa" id="nazwa" placeholder="Nazwa drużyny" class="input_button" value="{{ $copy ? $copy->nazwa : ''}}" required>
                </div>

            </div>
            <div class="form-row w-100">

                <div class="form-elem w-50 fw-image-choice">
                    <div class="text-center w-100 section-title-txt mb-10"> Wybierz zdjęcię dla drużyny</div>
                    <label for="fw_image" id="fw_upload_image">Dodaj zdjęcię ( max 200kb )</label>
                    <input class="input_button" type="file" id="fw_image" name="fw_image" accept="image/png, image/jpeg, image/PNG, image/jpg">
                    <div class="w-100 mt-20 el-round" id="footwear-img-preview">
                        <img src="#" alt="">
                    </div>

                </div>

                <div class="form-elem w-50">
                    <textarea rows="6" cols="51" name="desc" id="desc" class="input_button" placeholder="Opis drużyny" >{{ $copy ? $copy->opis : ''}}</textarea>
                </div>

            </div>


            <div class="d-f ai-c jc-s">
                <button type="submit" class="button_form">Dodaj</button>
                <a href="{{ url('/userPanel/panel/') }}" class="button_back">Wstecz</a>
                <a href="{{ url('/userPanel/team/create') }}" class="button_back">Wyczyść</a>
            </div>


         </form>



    </div>

</div>
@endsection



@section('assets')

<link rel="stylesheet" href="{{asset('css/activityForm.css')}}">
{{-- <script src="{{ asset('js/activityForm.js') }}"></script> --}}

<script>


document.addEventListener('DOMContentLoaded', ()=>{
console.log('boo');
    var previewImage = document.querySelector('#footwear-img-preview img');
    var imageUploadButton = document.querySelector('#fw_image');

    imageUploadButton.addEventListener('change',()=>{
        if(imageUploadButton.files && imageUploadButton.files[0]){
            const fileReader = new FileReader();

            fileReader.onload = function(e){
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }

            fileReader.readAsDataURL(imageUploadButton.files[0]);
        }
    });
});

    </script>
@endsection
