

<div id="activities-copy" class="d-f jc-s fd-c  border-light el-round mt-20 p-20">
    <div class="section-title-txt w-100">Poprzednie treningi</div>
    @foreach ($grouped as $item)
        
        <div class="w-100 d-f jc-c ai-c fd-c activities-copy-item el-round color-white bg-light" >

            <div class="w-100 jc-sb ai-c">

                <div class="w-100 d-f fd-c jc-c ai-c">
                    <div class="activity-icon d-f jc-c ai-c"><img src="{{ asset('images/panel/icons/'.$item->activityType->slug.'_icon.png') }}" alt=""></div>
                    {{-- <div> {{$item->activityType->name}} </div> --}}

                </div>

                

            </div>


            <div class=" text-center p-10 text-elipsis" >  {{$item->title}} </div>
            <a class=" button_form " href="{{ url('/userPanel/addActivity/' . $item->id) }}" >  Kopiuj <img src="{{ asset('images/panel/icons/copy_icon.png') }}" alt=""></a>
        </div>

    @endforeach
</div>