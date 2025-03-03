import { Calendar } from "@fullcalendar/core";
import interactionPlugin from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import autoprefixer from "autoprefixer";

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
    timeGridWeek: "日",
    listWeek: "リスト",
  },
  noEventsContent: "予定はありません。",
  locale: "ja",

  selectable: true,
  editable: true, 

  select: function (info) {
    const eventName = prompt("イベントを入力してください");
    if (eventName) {
      calendar.addEvent({
        title: eventName,
        start: info.start,
        end: info.end,
        allDay: true,
      });
    }
  },
  eventResize: function (info) {
    console.log(info.event.title + "のサイズが変更されました");
  },
  eventDrop: function (info) {
    console.log(info.event.title + "が移動されました");
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