
@props(['footwear' => false])


@if ($footwear)


<div class="w-100 mt-50">
    <div class="generic-title mb-20 pb-20">
        Podsumowanie obuwia:
    </div>


    <div class="w-100 footwer-ranking d-f ai-e jc-c mt-50">

        @php
            $order = [
                'first',
                'second',
                'third'
            ];
        @endphp


        @foreach ($footwear as $f )
        {{-- @dump($loop) --}}
                <div class="footwear-{{ $order[$loop->index] }} footwear-podium">
                    <div class="footwear-box-info">
                        <div>
                            <div class="footwear-img">
                                <img src="{{ asset('storage/footwear_images/'. $f->model->image) }}" alt="" loading="lazy">
                            </div>
                        </div>
                        <div class="text-center confirm-box-text mb-10 p-10">{{ $f->model->name . ' | ' . $f->model->model  }} </div>
                    </div>

                    <div class="footwear-box-holder">
                        <div class="footwear-stats">

                            <p>Liczba treningów: <span class="key"> {{ $f->fAmout }}</span></p>
                            <p>Czas użytkowania: <span class="key"> {{ $f->time }}</span></p>
                            <p>Przebyty dystans: <span class="key"> {{ $f->fValue }}km</span></p>

                        </div>
                        <div class="footwear-box-holder-bottom">{{ $loop->iteration  }}</div>
                    </div>
                </div>

        @endforeach




</div>


@endif
