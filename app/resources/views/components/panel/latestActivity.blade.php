

{{-- {{ dd($la) }} --}}


<div class="bg-light p-10 element-50 d-f jc-c ai-c el-round color-white">

    <div class="w-100 d-f fd-c">
        <div class="element-title w-100 d-f jc-sb ai-c">
            <div>Ostatnia aktywność:</div>
            <div class="font-small mr-5">Dodano: {{ ($la) ? $la['activity']->add_date : 'brak'  }}</div>
        </div>

        <div class="d-f jc-sb ai-c p-10">
            
            @if (!$la)
                <div class="w-100 d-f jc-sb ai-c">Brak danych
                    <div class="el-round color-white bg-main p-10 text-up fontw-600">
                        <a href="">Dodaj aktywność</a>
                    </div>
                </div>
            @else
                <div class="d-f jc-c ai-c fd-c activity-type-content">
                    <div class="activity-icon d-f jc-c ai-c"><img src="{{ asset('images/panel/icons/'.$la['category']->slug.'_icon.png') }}" alt=""></div>
                    <div class="d-f jc-c ai-c p-0 mt-10"><a href="{{ url('/userPanel/panel/summary/type' . $la['activity']->activity_type_id) }}">  {{ $la['category']->name}}</a></div>
                </div>

                <a href="{{ url('/userPanel/panel/' . $la['activity']->id . '/view') }}" class="d-f jc-fs ai-c fd-c">
                    <div> {{ $la['activity']->title }} </div>
                    <div class="font-small mt-10">{{ $la['activity']->description}}</div>
                </a>

                <div class="section-title-txt ">
                    <a href="{{ url('/userPanel/panel/' . $la['activity']->id . '/view') }}">  {{ $la['activity']->total_time}} min</a>
                </div>
            @endif
            

        </div>

    </div>




</div>
