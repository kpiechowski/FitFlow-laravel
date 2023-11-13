
function changeTeamRequestsCounter(element){
    let value = parseInt(element.textContent);
    value --;

    element.innerHTML = value;
    if(value == 0){
        document.querySelector('.team-requests-content').innerHTML = `<div class="p-20 w-full ">Brak próśb o dołączenie</div>`;
    }
}



document.addEventListener('DOMContentLoaded', ()=>{


    document.querySelectorAll('.team-tabs .team-tab').forEach(tab=>{
        tab.addEventListener('click', ()=>{
            if(tab.classList.contains('tab-active')) return;

            document.querySelector('.tab-active').classList.remove('tab-active');
            tab.classList.add('tab-active')
            document.querySelector('.page-page.page-active').classList.remove('page-active');
            document.querySelector('.page-page.'+tab.getAttribute('data-tab')).classList.add('page-active');
        });
    });



    if(document.querySelector('.team-requests')){

        const counter = document.querySelector('#team-req-counter');

        document.querySelectorAll('.team-request-row').forEach(row=>{

            row.querySelectorAll('.team-request-option').forEach(option => {
                option.addEventListener('click', ()=>{
                    let action = option.getAttribute('data-option');
                    let id = row.getAttribute('data-req');
                    fetch('/userPanel/teamRequest/'+ id + '/' + action )
                    .then(res => {
                        if(res.ok){
                            row.classList.add('el-hide');
                            setTimeout(() => {
                                row.classList.add('display--none');
                            }, 500);

                            changeTeamRequestsCounter(counter);
                        }else{
                            row.classList.add('el-disable');
                        }

                    })

                });
            });
        });

    }


    document.querySelectorAll('.member-row').forEach(mb=>{
        let id= mb.getAttribute('data-id');

        mb.querySelectorAll('.mb-option').forEach(option=>{
            option.addEventListener('click', ()=>{
                let team_id = document.querySelector('.team_main').getAttribute('data-id');
                let action = option.getAttribute('data-action');
                let link = 'userPanel/team/'+team_id+'/actions/'+action+'/'+id;
                console.log(link);
                panel_controller.openConfirmBox(link, option.getAttribute('title'));
            });
        });
    });

});
