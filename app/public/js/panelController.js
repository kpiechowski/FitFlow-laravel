
class panelController{

    constructor(){

        this.initNotificationTab()
        this.initProfileTab();
    }

    initNotificationTab(){
        this.notification_tab = document.querySelector('#notification-container');
        this.notification_close = document.querySelector('#notification-close');
        this.notification_box = document.querySelector('#notification-box');

        this.notification_box.addEventListener('click', ()=>{this.notification_tab.classList.add('notification--show'); })

        this.notification_close.addEventListener('click', ()=>{this.notification_tab.classList.remove('notification--show'); })

    }

    initProfileTab(){
        this.profile_tab = document.querySelector('.upper-bar-profile-popup');
        this.profile_icon = document.querySelector('.upper-bar-profile');

        this.profile_icon.addEventListener('click', ()=>{this.profile_tab.classList.toggle('popup--active')});
    }

}


var  panel_controller;
document.addEventListener('DOMContentLoaded', ()=>{

    panel_controller = new panelController();

});
