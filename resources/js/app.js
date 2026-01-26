import "./bootstrap";

import flatpickr from 'flatpickr/dist/flatpickr.min.js';
import { Japanese } from "flatpickr/dist/l10n/ja.js";

window.Japanese = Japanese;

/* =========================
   flatpickr 初期化
========================= */
function initializeFlatpickr() {
  document.querySelectorAll('.js-datepicker').forEach(el => {
    if (el._flatpickr) el._flatpickr.destroy();
    flatpickr(el, {
      locale: { ...Japanese, firstDayOfWeek: 1 },
      dateFormat: 'Y-m-d',
      allowInvalidPreload: true,
      disableMobile: true,
    });
  });

  document.querySelectorAll('.js-multiple-datepicker').forEach(el => {
    if (el._flatpickr) el._flatpickr.destroy();
    flatpickr(el, {
      locale: { ...Japanese, firstDayOfWeek: 1 },
      mode: "multiple",
      dateFormat: 'Y-m-d',
      allowInvalidPreload: true,
      disableMobile: true,
    });
  });

  document.querySelectorAll('.js-range-datepicker').forEach(el => {
    if (el._flatpickr) el._flatpickr.destroy();
    flatpickr(el, {
      locale: { ...Japanese, firstDayOfWeek: 1 },
      mode: "range",
      dateFormat: 'Y-m-d',
      allowInvalidPreload: true,
      disableMobile: true,
    });
  });
}

/* =========================
   Livewire連携
========================= */
document.addEventListener('DOMContentLoaded', () => {
  if (window.Livewire) {
    initializeFlatpickr();

    Livewire.on('refreshFlatpickr', () => {
      initializeFlatpickr();
    });
  }
});


/* =========================
   iOS対策 vh fix
========================= */
function setVh() {
  const vh = window.innerHeight * 0.01;
  document.documentElement.style.setProperty('--vh', `${vh}px`);
}

window.addEventListener('resize', setVh);
setVh();
