function updateClock() {
  const now = new Date();

  const dateEl = document.getElementById('js-current-date');
  const timeEl = document.getElementById('js-current-time');

  if (!dateEl || !timeEl) return;

  const week = ['日', '月', '火', '水', '木', '金', '土'];

  const date =
    now.getFullYear() + '/' +
    (now.getMonth() + 1) + '/' +
    now.getDate() +
    ' (' + week[now.getDay()] + ')';

  const time =
    String(now.getHours()).padStart(2, '0') + ':' +
    String(now.getMinutes()).padStart(2, '0');

  dateEl.textContent = date;
  timeEl.textContent = time;
}

updateClock();
setInterval(updateClock, 1000);
