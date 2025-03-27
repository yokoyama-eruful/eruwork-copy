<a class="mb-2 flex h-20 w-20 flex-col rounded border bg-ao-sub fill-gray-500 hover:bg-sky-200"
  href="{{ route('calendar.index') }}">
  <svg class="p-1" viewBox="0 0 512 512">
    <rect class="cls-1" style="fill: #6f8184;stroke-width: 0" width="32.6" height="96.1" x="138.4" rx="15.3"
      ry="15.3" />
    <rect style="fill: #6f8184;stroke-width: 0" width="32.6" height="96.1" x="302.3" rx="15.3" ry="15.3" />
    <path fill="none" stroke="#6f8184" stroke-miterlimit="10" stroke-width="15"
      d="M342.3 32.5h44.1c40.9 0 74.3 33.2 74.3 73.8V389c0 40.6-33.4 73.8-74.3 73.8H81.8c-40.9 0-74.3-33.2-74.3-73.8V106.2c0-40.6 33.4-73.8 74.3-73.8h48.9" />
    <path fill="none" stroke="#6f8184" stroke-miterlimit="10" stroke-width="7" d="M178.2 29.5h116.6" />
    <path style="fill: #6f8184;stroke-width: 0"
      d="M14.9 132.4v-28.6c0-39 31.8-70.8 70.8-70.8h41.6v46.3c0 15 12.2 27.2 27.2 27.2s27.2-12.2 27.2-27.2V33h109.6v46.3c0 15 12.2 27.2 27.2 27.2s27.2-12.2 27.2-27.2V33h34.6c39 0 70.8 31.8 70.8 70.8v28.6H14.9Z" />
    <path style="fill: #6f8184;stroke-width: 0"
      d="M380.4 36.5c37.1 0 67.3 30.2 67.3 67.3v25.1H18.4v-25.1c0-37.1 30.2-67.3 67.3-67.3h38.1v42.8c0 17 13.8 30.7 30.7 30.7s30.7-13.8 30.7-30.7V36.5h102.6v42.8c0 17 13.8 30.7 30.7 30.7s30.7-13.8 30.7-30.7V36.5h31.1m.1-7h-38.1v49.8c0 13.1-10.7 23.7-23.7 23.7-13.1 0-23.7-10.7-23.7-23.7V29.5H178.3v49.8c0 13.1-10.7 23.7-23.7 23.7-13.1 0-23.7-10.7-23.7-23.7V29.5H85.8c-41 0-74.3 33.3-74.3 74.3v32.1h443.3v-32.1c0-41-33.3-74.3-74.3-74.3h-.1Z" />
    <text style="font-weight:bold;color:#6f8184" x="112" y="390" font-family="Arial" font-size="200">
      {{ now()->format('d') }}
    </text>
  </svg>
  <div class="rounded-b bg-ao-main">
    <span class="flex items-center justify-center text-xs text-white">カレンダー</span>
  </div>
</a>
