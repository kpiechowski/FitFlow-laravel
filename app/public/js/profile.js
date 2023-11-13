

document.addEventListener('DOMContentLoaded', ()=>{

    let image_input = document.querySelector('#profile_img');
    let image_holder = document.querySelector('.input-image-holder img');

    let modal = document.querySelector('#modal-edit-form');

    document.querySelector('.profile-image-edit').addEventListener('click', ()=>{
        modal.classList.remove('display--none');
    });


    modal.addEventListener('click', function(e){
        console.log(e.target);

        if(e.target == modal){
            modal.classList.add('display--none');
        }
    });

    image_input.addEventListener('change',()=>{
        if(image_input.files && image_input.files[0]){
            const fileReader = new FileReader();

            fileReader.onload = function(e){
                image_holder.src = e.target.result;
                image_holder.style.display = 'block';
            }

            fileReader.readAsDataURL(image_input.files[0]);
        }
    });

});
