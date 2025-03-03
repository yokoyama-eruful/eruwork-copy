import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import tippy from 'tippy.js';
import 'tippy.js/dist/tippy.css'; 

var calendarEl = document.getElementById("calendar");

function isMobile() {
  return window.innerWidth <= 768;
}

let calendar = new Calendar(calendarEl, {
  height: 800,
  plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
  initialView: "dayGridMonth",
  headerToolbar: isMobile()
    ? { left: "prev,next today", center: "title", right: "" }
    : {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
      },
  buttonText: {
    prev: "前",
    next: "次",
    today: "今日",
    dayGridMonth: "月",
    timeGridWeek: "週",
    timeGridDay: "日",
    listWeek: "リスト",
  },
  noEventsContent: "予定はありません。",
  locale: "ja",

  selectable: true,
  editable: true,

  select: function (info) {
    var options = { year: 'numeric', month: '2-digit', day: '2-digit', timeZone: 'Asia/Tokyo' };
    var startDate = new Intl.DateTimeFormat('ja-JP', options).format(info.start);
    
    var endDateObj = new Date(info.end);
    endDateObj.setDate(endDateObj.getDate() - 1);
    var endDate = new Intl.DateTimeFormat('ja-JP', options).format(endDateObj);

    startDate = startDate.replace(/\//g, '-'); 
    endDate = endDate.replace(/\//g, '-'); 

    console.log(startDate, endDate);
    document.getElementById('start_date').value = startDate;
    document.getElementById('end_date').value = endDate;

    dispatchEvent(new CustomEvent("open-modal", { detail: "open-schedule-create-modal" }));
  },
  eventResize: function (info) {
    const scheduleId = info.event.id;
   const updatedTime = {
     start_time: info.event.start.toTimeString().slice(0, 5), 
     end_time: info.event.end.toTimeString().slice(0, 5),
   };
   
   fetch(`/api/resize-schedule/${scheduleId}`, {
     method: 'POST',
     headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      "Content-Type": "application/json",
     },
     body: JSON.stringify(updatedTime),
   })
     .then(response => {
       if (response.ok) {
         return response.json(); 
       }
       throw new Error('Network response was not ok.');
     })
     .then(data => {
       console.log('スケジュール更新成功:', data);
     })
     .catch(error => {
       console.error('スケジュール更新エラー:', error);
     });
  },
  eventDrop: function (info) {

    var options = { year: 'numeric', month: '2-digit', day: '2-digit', timeZone: 'Asia/Tokyo' };
    var startDate = new Intl.DateTimeFormat('ja-JP', options).format(info.event.start);
    var endDate = new Intl.DateTimeFormat('ja-JP', options).format(info.event.end);

   const scheduleId = info.event.id;
   const updatedData = {
     start_date: startDate, 
     end_date: endDate,
   };
   
   fetch(`/api/drag-schedule/${scheduleId}`, {
     method: 'POST',
     headers: {
      'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
      "Content-Type": "application/json",
     },
     body: JSON.stringify(updatedData),
   })
     .then(response => {
       if (response.ok) {
         return response.json(); 
       }
       throw new Error('Network response was not ok.');
     })
     .then(data => {
       console.log('スケジュール更新成功:', data);
     })
     .catch(error => {
       console.error('スケジュール更新エラー:', error);
     });
  },
  eventClick: function(info) {
    const editForm=document.getElementById('edit-schedule-form');
    const deleteForm=document.getElementById('delete-schedule-form');

    editForm.action = `/calendar/${info.event.id}`;
    deleteForm.action = `/calendar/${info.event.id}`;
    editForm.querySelector('#title').value = info.event.title;
    editForm.querySelector('#description').value = info.event.extendedProps.description;
    editForm.querySelector('#start_date').value = info.event.start.toISOString().slice(0, 10);  
    editForm.querySelector('#end_date').value = info.event.end.toISOString().slice(0, 10);  
    editForm.querySelector('#start_time').value = info.event.start.toTimeString().slice(0, 5); 
    editForm.querySelector('#end_time').value = info.event.end.toTimeString().slice(0, 5); 
    dispatchEvent(new CustomEvent("open-modal", { detail: "open-schedule-edit-modal" }));
  },
  eventDidMount: (e)=>{
		tippy(e.el, {
			content: e.event.extendedProps.description,
		});
	},

  events: function (fetchInfo, successCallback, failureCallback) {
    fetch("/api/schedules") 
      .then((response) => response.json())
      .then((data) => {
        console.log("イベントデータの取得に成功しました:", data);
        successCallback(data);
      })
      .catch((error) => {
        console.error("イベントデータの取得に失敗しました:", error);
        failureCallback(error);
      });
  },
});

calendar.render();

window.addEventListener("resize", function () {
  calendar.setOption("headerToolbar", isMobile()
    ? { left: "prev,next today", center: "title", right: "" }
    : {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,listWeek",
      });
});