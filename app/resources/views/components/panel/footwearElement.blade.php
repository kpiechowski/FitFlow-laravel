

@php
    // dd($shoe)
@endphp
<div class="footwear-box round d-f ai-c jc-sb">

    <div class="footwear-profile d-f fd-c jc-c ai-c">
        <div class="footwear-img">
            <img src="{{ asset('storage/footwear_images/'. $shoe->image) }}" alt="" loading="lazy">
        </div>
        <div class="footware-name">{{ $shoe->name }}</div>
    </div>
    

    <div class="footwear-info-wrapp d-f fd-c jc-c ai-c">

        <div class="footwear-options w-100 d-f jc-e ai-c">
            
            <a href="{{ url('userPanel/footware/' . $shoe->id . '/edit/') }}" class="footware-option-el">
                <span class="material-icon">edit</span>
            </a>

        </div>

        <div class="footwear-info">
            
        </div>

    </div>

</div>
