



<div class="activity-container mt-20 bg-light border-light d-f fd-c p-20 w-100">


<form action="{{ url('/userPanel/addActivity/') }}" method="POST" id="activit-form">
    @csrf

    <div class="form-row w-100">

        <div class="form-elem w-50">

            <label for="act_type">Activity Type</label>
            <select name="act_type" id="act_type" class="input_button" data-selected="{{ $copy ? $copy->activityType->slug : ''}}">
                <option>Select type</option>
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
            <label for="act_start">Date </label>
            <input class="input_button" type="date" id="act_start" name="act_start" value="{{ $copy ? $copy->add_date : $date}}" min="2020-01-01" max="2099-12-31">

        </div>

    </div>

    <div class="form-row w-100">

        <div class="form-elem w-50">
            <label for="act_name">Name </label>
            <input type="text" name="act_name" id="act_name" placeholder="Activity name" class="input_button" value="{{ $copy ? $copy->title : ''}}" required>
        </div>

        <div class="form-elem w-50">
            <label for="act_time">Total time [min] </label>
            <input type="text" name="act_time" id="act_time" placeholder="00" class="input_button" value="{{ $copy ? $copy->total_time : ''}}" required>
        </div>


    </div>


    <div class="form-row w-100">

        <div class="form-elem w-50 display--none">
            <label for="act_value" id="select-type-value">Activity value</label>
            <input type="text" name="act_value" id="act_value" placeholder="00" class="input_button" value="{{ $copy ? $copy->value : ''}}">
        </div>

    </div>


    <div class="form-row w-100">

    <div class="form-elem w-100">
        <label for="desc">Activity description</label>
        <textarea rows="6" cols="51" name="desc" id="desc" placeholder="Any thoughts?" class="input_button" >{{ $copy ? $copy->description : ''}}"</textarea>
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



