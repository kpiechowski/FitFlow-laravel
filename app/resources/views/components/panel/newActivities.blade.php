

@php
// dd($data);
@endphp

<div class="element-100 newAc bg-light p-10 el-round color-white" >

    <div class="element-title w-100 d-f jc-sb ai-c">
        <div>Najnowsze aktywności</div>
    </div>

    <div class="newAc-header w-100 d-f">
        <div class="newAc-header-label label-small">LP</div>
        <div class="newAc-header-label">Data</div>
        <div class="newAc-header-label">Rodzaj</div>
        <div class="newAc-header-label label-wide">Tytuł</div>
        <div class="newAc-header-label">Czas trwania</div>
        <div class="newAc-header-label">Wartość</div>
        <div class="newAc-header-label label-wide desc-type">Opis</div>

    </div>

    <div class="newAc-content w-100 d-f fd-c pb-20">

        @if ($data)

            @foreach ($data as $item)
                <div class="newAc-content-row w-100 d-f mb-10">

                    <div class="newAc-content-field label-small">{{ $loop->index + 1}}</div>
                    <div class="newAc-content-field">{{ $item->add_date }}</div>
                    <div class="newAc-content-field d-f jc-fs ai-c">
                        <div class="activity-icon d-f jc-c ai-c mr-5"><img src="{{ asset('images/panel/icons/'.$item->activityType->slug.'_icon.png') }}" alt=""></div>
                        <div class="d-f jc-c ai-c p-0">
                            <a href="{{ url('/userPanel/panel/summary/type' . $item->activity_type_id) }}">  {{ $item->activityType->name}}</a>
                        </div>
                    </div>
                    <a class="newAc-content-field label-wide" href="{{ url('/userPanel/panel/' . $item->id . '/view') }}"> {{ $item->title }}</a>
                    <div class="newAc-content-field">{{ $item->total_time }}</div>
                    <div class="newAc-content-field">{{ $item->value }}</div>
                    <div class="newAc-content-field label-wide desc-type">{{ $item->description }}</div>

                </div>
            @endforeach
            
        @else
            <div class="w-100 d-f jc-c mt-30">Brak aktywności do wyświetlenia</div>
        @endif

    </div>

</div>
