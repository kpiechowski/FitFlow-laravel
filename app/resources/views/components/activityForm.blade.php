



<div class="activity-container mt-20 bg-light border-light d-f fd-c p-20 w-100">


<form action="{{ url('/userPanel/addActivity/') }}" method="POST" id="activit-form">
    @csrf

    <div class="form-row w-100">

        <div class="form-elem w-50">

            <label for="act_type">Rodzaj aktywności</label>
            <select name="act_type" id="act_type" class="input_button" data-selected="{{ $copy ? $copy->activityType->slug : ''}}">
                <option>Wybierz opcję</option>
                @foreach ($types as $type)

                    @if ($copy && $type->id == $copy->activityType->id)
                        <option data-slug="{{$type->slug}}" value="{{$type->id}}" selected="selected">
                            {{ $type->name }}
                        </option>
                    @else
                        <option data-slug="{{$type->slug}}" value="{{$type->id}}">
                            {{ $type->name }}
                        </option>
                    @endif
                    

                @endforeach
            </select>

        </div>

        <div class="form-elem w-50">
            <label for="act_start">Data </label>
            <input class="input_button" type="date" id="act_start" name="act_start" value="{{ $copy ? $copy->add_date : $date}}" min="2020-01-01" max="2099-12-31">

        </div>

    </div>

    <div class="form-row w-100">

        <div class="form-elem w-50">
            <label for="act_name">Nazwa </label>
            <input type="text" name="act_name" id="act_name" placeholder="Nazwa aktywności" class="input_button" value="{{ $copy ? $copy->title : ''}}" required>
        </div>

        <div class="form-elem w-50">
            <label for="act_time">Całkowity czas [min] </label>
            <input type="text" name="act_time" id="act_time" placeholder="00" class="input_button" value="{{ $copy ? $copy->total_time : ''}}" required>
        </div>


    </div>


    <div class="form-row w-100">

        <div class="form-elem w-50 display--none">
            <label for="act_value" id="select-type-value">Wartość treningu ?? </label>
            <input type="text" name="act_value" id="act_value" placeholder="00" class="input_button" value="{{ $copy ? $copy->value : ''}}">
        </div>

        <div class="form-elem w-50 display--none">
            <label for="act_footwear" id="select-shoe-value">Buty</label>
            @php 
                // dd($copy->footwear);
            @endphp

            <select name="act_footwear" id="act_footwear" class="input_button" >
                <option>Wybierz obuwie</option>
        
                @foreach ($footwear as $shoe)
                <?php //ddd($shoe->id); ?>
                    @if ($copy && $shoe->id == $copy->footwear->id)
                        <option value="{{$shoe->id}}" selected="selected">
                            {{ $shoe->name }}
                        </option>
                    @else
                        <option value="{{$shoe->id}}">
                            {{ $shoe->name }}
                        </option>
                    @endif
                    

                @endforeach
            </select>
        </div>

    </div>


    <div class="form-row w-100">

    <div class="form-elem w-100">
        <label for="desc">Opis</label>
        <textarea rows="6" cols="51" name="desc" id="desc" class="input_button" >{{ $copy ? $copy->description : 'Jak Ci dzisiaj poszło?'}}</textarea>
    </div>


    </div>



    <div class="d-f ai-c jc-s">
        <button type="submit" class="button_form">Dodaj</button>
        <a href="{{ url('/userPanel/panel/') }}" class="button_back">Wstecz</a>
        <a href="{{ url('/userPanel/addActivity/') }}" class="button_back">Wyczyść</a>
    </div>


</form>

<div class="form-row w-100">

    <div class="form-elem w-50">

    </div>

    <div class="form-elem w-50">

    </div>


</div>

</div>



