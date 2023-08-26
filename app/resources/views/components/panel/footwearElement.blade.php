

@php
    // dd($shoe)
@endphp
<div class="footwear-box round d-f  jc-sb">

    <div class="footwear-profile d-f fd-c jc-c ai-c">
        <div class="footwear-img">
            <img src="{{ asset('storage/footwear_images/'. $shoe->image) }}" alt="" loading="lazy">
        </div>
        <div class="footware-name">{{ $shoe->name }}</div>
    </div>
    
    <div class="footwear-options w-100 d-f jc-e ai-c">
            
        <a href="{{ url('userPanel/footwear/' . $shoe->id . '/edit/') }}" class="footware-option-el">
            <span class="material-icon">edit</span>
        </a>
        <a href="{{ url('userPanel/footwear/' . $shoe->id . '/edit/') }}" class="footware-option-el">
            <span class="material-icon">delete</span>
        </a>

    </div>

    <div class="footwear-info-wrapp d-f">

        <div class="footwear-info">

           <p> <span class="key">Model</span> : {{$shoe->model}} </p>
           <p> <span class="key">Łączny dystans</span> : {{$shoe->total_km}} km</p>
           <p> <span class="key">Łączny czas</span> : {{$shoe->total_time}} </p>
           <p> <span class="key">Data dodania</span> : {{$shoe->created_at}} </p>

        </div>

    </div>

</div>
