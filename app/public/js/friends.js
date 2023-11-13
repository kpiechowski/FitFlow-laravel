


function displayFetchData(data, div){
    let cont = div.querySelector('.friends-search-inner');
    let copy = div.querySelector('.member-row');

    if(data.status == "found"){

        cont.innerHTML = '';
        data.rows.forEach(el => {

            let row = copy.cloneNode(1);

            row.setAttribute('data-row', el.id);
            row.querySelector('.mb-icon').classList.add(el.iconType);
            row.querySelector('.mb-icon').innerHTML = el.iconContent;
            row.querySelector('.mb-name').innerHTML = el.name;

            row.querySelector('.f-options .add').setAttribute('href', '/userPanel/friends/send/'+el.id)
            row.querySelector('.f-options .profile').setAttribute('href', '/userPanel/profile/view/'+el.id);

            row.classList.remove('display--none');
            cont.appendChild(row);
        });


    }else{
        cont.innerHTML = `<div class="w-100 text-center"> Brak wyników wyszukiwania</div>`;
    }
    console.log(data);
}

document.addEventListener('DOMContentLoaded', ()=>{

    let button = document.querySelector('#friend-search-button');
    let input = document.querySelector('.friend-search input');
    let cont = document.querySelector('.friends-search-content');

    button.addEventListener('click', ()=>{

        let value = input.value;
        if(value.length == 0) return;

        cont.classList.add('active');
        cont.querySelector('.load').classList.remove('display--none');


        fetch('/userPanel/friends/fetch/'+value)
        .then(response=>{
            if(response.ok){
                return response.json()
            }
        }).then(data=>{
            setTimeout(function(){
                cont.querySelector('.load').classList.add('display--none');
                displayFetchData(data, cont);
            }, 1500)
        });



    });



    // document.querySelectorAll('.member-row').forEach(mb=>{
    //     let id= mb.getAttribute('data-id');

    //     mb.querySelectorAll('.mb-option').forEach(option=>{
    //         option.addEventListener('click', ()=>{
    //             let team_id = document.querySelector('.team_main').getAttribute('data-id');
    //             let action = option.getAttribute('data-action');
    //             let link = 'userPanel/team/'+team_id+'/actions/'+action+'/'+id;
    //             console.log(link);
    //             panel_controller.openConfirmBox(link, option.getAttribute('title'));
    //         });
    //     });
    // });

});
