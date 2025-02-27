<div class="h-full rounded-r bg-white p-4 shadow-sm">
  <div class="mb-3">
    <div class="flex items-center">
      <div class="mr-2 h-6 w-1 bg-sky-600"></div>
      <h2 class="text-xl font-semibold">メニュー</h2>
    </div>
  </div>
  <nav>
    <ul class="grid grid-cols-4 gap-2 sm:grid-cols-2">
      <li class="mb-2">
        {{-- ここにicon --}}
        <a class="flex h-20 w-20 flex-col items-end rounded-md border hover:bg-gray-100" href="#">
          <div class="h-2/3 bg-sky-100">
            <x-application-logo />
          </div>
          <div class="h-1/3 w-full rounded-b-md bg-sky-600">
          </div>
        </a>
      </li>
      <li class="mb-2"><a class="block h-20 w-20 rounded border bg-sky-100 hover:bg-gray-100" href="#">掲示板</a>
      </li>
      <li class="mb-2"><a class="block h-20 w-20 rounded border bg-sky-100 hover:bg-gray-100"
          href="#">タイムカード</a></li>
      <li class="mb-2"><a class="block h-20 w-20 rounded border bg-sky-100 hover:bg-gray-100"
          href="#">タイムカード</a></li>
      <li class="mb-2"><a class="block h-20 w-20 rounded border bg-sky-100 hover:bg-gray-100"
          href="#">タイムカード</a></li>
    </ul>
  </nav>
</div>
