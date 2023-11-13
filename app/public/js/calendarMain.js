
function drawActivityEventPopup(info){

    let el = info.el,
        title = info.event.title,
        id = info.event.id,
        date = info.event.startStr;



    // el.appendChild(calendarPopup);

    calendarPopup.querySelector('.activityPopup-date').innerHTML = date;
    calendarPopup.querySelector('.activityPopup-title').innerHTML = title;
    calendarPopup.querySelector('.activityPopup-edit').href = `/userPanel/panel/${id}/edit`;
    calendarPopup.querySelector('.activityPopup-delete').href = `/userPanel/panel/${id}/edit`;
    calendarPopup.classList.remove('display--none');



}


// function get

var calendarPopup;


document.addEventListener('DOMContentLoaded', function() {
    var dateObj = new Date();
    calendarPopup = document.querySelector('.calendarPopUp-wrapper');

    calendarPopup.addEventListener('click', ()=>{
      calendarPopup.classList.add('display--none');
    });

    calendarPopup.querySelector('.calendarPopupBox').addEventListener('click',function(e){
      e.stopImmediatePropagation();
    });
    calendarPopup.querySelector('.activityPopup-delete').addEventListener('click',function(e){
      e.stopImmediatePropagation();
      e.preventDefault();
      panel_controller.openConfirmBox(calendarPopup.querySelector('.activityPopup-delete').getAttribute('href'), "Czy na pewno chcesz usunąć tę aktywność?");
    });




    var monthNumber = dateObj.getMonth() + 1;
    var yearNumber = dateObj.getFullYear();

    // var eventSource = {
    //   url: '/userPanel/panel/getUserActivityJson/'+yearNumber+'/'+monthNumber,
    //   method: 'GET',
    //   extraParams: {
    
    //   },
    //   failure: function(e) {
    //   },
    // };

    var calendarEl = document.getElementById('activityCalendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        dayMaxEventRows: 3,
        locale: 'pl',
        events:calendarCurrentEvents,
        dayPopoverMoreLinkText: function(num) {
          return " +" + num + " więcej";
        },
        buttonText: {
          today: 'Dzisiaj' // Customize the "Today" button text
      },
        // eventSources: [eventSource],
        // events: '/userPanel/panel/getUserActivityJson/'+yearNumber+'/'+monthNumber,
        eventClick: function(info) {
          console.log(info);
          // info.el.style.borderColor = 'red';
          drawActivityEventPopup(info);
        }

  });
  console.log(calendar.calendarCurrentEvents);

  calendar.render();


  calendar.on('dateClick', function(info) {
    console.log(info);
  });
});


    // fetch('/userPanel/panel/getUserActivityJson/'+year+'/'+month)
    // .then(response => {
    //   if (!response.ok) {
    //     throw new Error('Network response was not ok');
    //   }
    //   return response.json();
    // })
    // .then(data => {
    //   console.log(data);
    //   calendar.events = data;
    // })