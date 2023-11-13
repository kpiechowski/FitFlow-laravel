@props(['user' => null])


@if($user)

    <div id="modal-edit-form" class="confirm-box-background d-f jc-c ai-c display--none">
        <div class="confirm-box d-f jc-c ai-c fd-c">

            <form action="{{ url('userPanel/profile/edit/photo') }} " method="POST" enctype="multipart/form-data">
                @csrf
                <label for="profile_img" class="button_form">Dodaj zdjęcię</label>

                <input class="input_button display--none" type="file" id="profile_img" name="profile_img" accept="image/png, image/jpeg, image/PNG, image/jpg" required>

                <div class="input-image-holder">
                    <img src="#" alt="">
                </div>

                <button type="submit" class="button_form">Prześlij</button>
            </form>

        </div>
    </div>

@endif
