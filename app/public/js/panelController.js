
class panelController{

    constructor(){

        this.initNotificationTab()
        this.initProfileTab();
        this.initConfirmBox();
    }

    initNotificationTab(){
        this.notification_tab = document.querySelector('#notification-container');
        this.notification_close = document.querySelector('#notification-close');
        this.notification_box = document.querySelector('#notification-box');
        this.notification_read_all = document.querySelector('#notification-read-all');
        this.notification_counter = document.querySelector('.notification-amout');
        this.notification_elements = document.querySelectorAll('#notification-elements .notification');

        this.notification_elements.forEach(el=>{
            el.querySelector('.notification-unmark').addEventListener('click',()=>{
                this.updateNotifCounter(1);
                fetch('/userPanel/notification/unmark/'+el.getAttribute('data-notId'))
                .then(response=>{
                    if (response.ok){
                        el.classList.add('el-hide');
                        setTimeout(() => {
                            el.classList.add('display--none');
                        }, 500);
                    }
                });
            });
        });

        this.notification_read_all.addEventListener('click', ()=>{
            this.notification_elements.forEach(el=>{
                this.updateNotifCounter(this.notification_counter.textContent);
                this.notification_box.querySelector('.notification-img').classList.remove('notifications--new');
                fetch('/userPanel/notification/unmark/'+el.getAttribute('data-notId'))
                .then(response=>{
                    if (response.ok){
                        el.classList.add('el-hide');
                        setTimeout(() => {
                            el.classList.add('display--none');
                        }, 500);
                    }
                });
            });
        });

        this.notification_box.addEventListener('click', ()=>{this.notification_tab.classList.add('notification--show'); })

        this.notification_close.addEventListener('click', ()=>{this.notification_tab.classList.remove('notification--show'); })

    }

    updateNotifCounter(byValue){
        let amout = this.notification_counter.textContent;
        this.notification_counter.innerHTML = (amout - parseInt(byValue));
    }

    initProfileTab(){
        this.profile_tab = document.querySelector('.upper-bar-profile-popup');
        this.profile_icon = document.querySelector('.upper-bar-profile');

        this.profile_icon.addEventListener('click', ()=>{this.profile_tab.classList.toggle('popup--active')});
    }

    initConfirmBox(){
        this.confirm_bg = document.querySelector('.confirm-box-background');
        this.confirm_bg.addEventListener('click', ()=>{
            // console.log('elo');
            this.confirm_bg.classList.add('display--none');
        });
    }

    openConfirmBox(link, text){
        this.confirm_bg.classList.remove('display--none');
        this.confirm_bg.querySelector('.confirm-box-text').innerHTML = text;
        this.confirm_bg.querySelector('.confirm-box-button').setAttribute('href', link);
    }



}


var  panel_controller;
document.addEventListener('DOMContentLoaded', ()=>{

    panel_controller = new panelController();

});
