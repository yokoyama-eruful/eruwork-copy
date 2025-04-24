<div class="h-full rounded-r bg-white p-4 shadow-sm">
  <div class="mb-3">
    <div class="flex items-center">
      <div class="mr-2 h-6 w-1 bg-hai-main"></div>
      <h2 class="text-xl font-semibold">メニュー</h2>
    </div>
  </div>
  <nav class="mb-4">
    <ul class="grid grid-cols-4 gap-2 sm:grid-cols-6 xl:grid-cols-2">
      <li class="mb-2">
        <a class="mb-2 flex h-20 w-20 flex-col rounded border bg-ao-sub shadow hover:bg-sky-200"
          href="{{ route('dashboard') }}">
          <svg class="p-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M256.7,17.8l245.9,175.7v299.9h-185.2v-165.9h-121.3v165.9H10.8V193.4L256.7,17.8M256.7,9.3L3.9,189.9v310.3h199.1v-165.9h107.4v165.9h199.1V189.9L256.7,9.3h0Z"
              fill="#6f8184" stroke="#6f8184" stroke-miterlimit="10" stroke-width="8" />
          </svg>
          <div class="rounded-b bg-hai-main">
            <span class="flex items-center justify-center text-xs text-white">ホーム</span>
          </div>
        </a>
      </li>
      <li class="mb-2">
        @include('account::icon')
      </li>
      <li class="mb-2">
        @include('calendar::admin.icon')
      </li>
      <li class="mb-2">
        @include('shift::admin.icon')
      </li>
      <li class="mb-2">
        @include('chat::admin.icon')
      </li>
      <li class="mb-2">
        @include('hourlyrate::icon')
      </li>
      <li class="mb-2">
        @include('timecard::admin.icon')
      </li>
      <li class="mb-2">
        @include('timecard::general.icon')
      </li>
    </ul>
  </nav>

  <div class="mb-3">
    <div class="flex items-center">
      <div class="mr-2 h-6 w-1 bg-ao-main"></div>
      <h2 class="text-xl font-semibold">一般</h2>
    </div>
  </div>
  <nav>
    <ul class="grid grid-cols-4 gap-2 sm:grid-cols-6 xl:grid-cols-2">
      <li class="mb-2">
        <a class="mb-2 flex h-20 w-20 flex-col rounded border bg-ao-sub shadow hover:bg-sky-200"
          href="{{ route('home') }}">
          <svg class="p-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path
              d="M256.7,17.8l245.9,175.7v299.9h-185.2v-165.9h-121.3v165.9H10.8V193.4L256.7,17.8M256.7,9.3L3.9,189.9v310.3h199.1v-165.9h107.4v165.9h199.1V189.9L256.7,9.3h0Z"
              fill="#6f8184" stroke="#6f8184" stroke-miterlimit="10" stroke-width="8" />
          </svg>
          <div class="rounded-b bg-ao-main">
            <span class="flex items-center justify-center text-xs text-white">一般</span>
          </div>
        </a>
      </li>
    </ul>
  </nav>
</div>
