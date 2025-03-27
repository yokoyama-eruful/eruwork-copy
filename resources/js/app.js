import "./bootstrap";

import flatpickr from 'flatpickr/dist/flatpickr.min.js';
import { Japanese } from "flatpickr/dist/l10n/ja.js"

window.Japanese=Japanese;
document.addEventListener("DOMContentLoaded", function() {
  function initializeFlatpickr() {
      flatpickr('.js-datepicker', {
        locale:{
            ...Japanese,
            "firstDayOfWeek": 1
        } ,
          dateFormat: 'Y-m-d',
          allowInvalidPreload:true,
          disableMobile: "true"
      });

      flatpickr('.js-multiple-datepicker', {
          locale:{
            ...Japanese,
            "firstDayOfWeek": 1
        } ,
        mode: "multiple",
        dateFormat: 'Y-m-d',
        allowInvalidPreload:true,
        disableMobile: "true"
      });

      flatpickr('.js-range-datepicker', {
        locale:{
            ...Japanese,
            "firstDayOfWeek": 1
        } ,
          mode: "range",
          dateFormat: 'Y-m-d',
          allowInvalidPreload:true,
          disableMobile: "true"
      });
  }

  initializeFlatpickr();

  Livewire.on('refreshFlatpickr', () => {
      initializeFlatpickr();
  });
});