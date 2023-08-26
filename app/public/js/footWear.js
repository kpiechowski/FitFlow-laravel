

document.addEventListener('DOMContentLoaded', ()=>{

    document.querySelectorAll('.fw_labels_cont label').forEach(label =>{
        label.addEventListener('click', ()=>{

            document.querySelector('#choice-top-label').checked = true;

            document.querySelector('#fw-image-choice').classList.add('choice-off');
            document.querySelector('#fw-label-choice').classList.remove('choice-off');
            if(aktywny = document.querySelector('.fw_labels_cont label.active')){
                aktywny.classList.remove('active');
            }

            label.classList.add('active');
            
        });
    });


    document.querySelector('#fw-image-choice').addEventListener('click', ()=>{
            document.querySelector('#choice-top-img').checked = true;
            // document.querySelector('#choice-top-img').parentNode.classList.add('choice-checked');

            document.querySelector('#fw-image-choice').classList.remove('choice-off');
            document.querySelector('#fw-label-choice').classList.add('choice-off');
    });



    var previewImage = document.querySelector('#footwear-img-preview img');
    var imageUploadButton = document.querySelector('#fw_image');

    imageUploadButton.addEventListener('change',()=>{
        if(imageUploadButton.files && imageUploadButton.files[0]){
            const fileReader = new FileReader();

            fileReader.onload = function(e){
                previewImage.src = e.target.result;
                previewImage.style.display = 'block';
            }

            fileReader.readAsDataURL(imageUploadButton.files[0]);
        }
    });


    

});