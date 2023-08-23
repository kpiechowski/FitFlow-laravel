
function drawActivityEventPopup(info, calendarPopup){

    let id = info.event.id ,
        el = info.el,
        title = info.event.title;


    el.appendChild(calendarPopup);

    calendarPopup.querySelector('.activityPopup-title').innerHTML = title;
    calendarPopup.querySelector('.activityPopup-edit').href = `/userPanel/panel/${id}/edit`;
    calendarPopup.classList.remove('display--none');

}




document.addEventListener('DOMContentLoaded', function() {
    var dateObj = new Date();
    var calendarPopup = document.querySelector('.calendarPopupBox');


    var monthNumber = dateObj.getMonth() + 1;
    console.log('/userPanel/panel/getUserActivityJson/'+monthNumber);
    var calendarEl = document.getElementById('activityCalendar');
    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        dayMaxEventRows: 2,
        events: calendarCurrentEvents,

        eventClick: function(info) {

        // console.log(info);info
        drawActivityEventPopup(info, calendarPopup);

        // change the border color just for fun
        info.el.style.borderColor = 'red';
    }


    // events:'/userPanel/panel/getUserActivityJson/'+monthNumber,
    // events:
    //     {
    //         url: '/userPanel/panel/getUserActivityJson/'+monthNumber,
    //         method: 'GET',
    //         failure: function() {
    //             alert('there was an error while fetching events!');
    //         }

    //     }


  });
  calendar.render();


  calendar.on('dateClick', function(info) {
    console.log('clicked on ' + info.dateStr);
  });
});
