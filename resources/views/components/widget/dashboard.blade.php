<div class="mb-2 rounded-lg border bg-white p-4 shadow">
  <div class="mb-2 flex items-center justify-between">
    <h1 class="border-l-4 border-dashHai-main pl-2 text-xl font-bold">{{ $title }}</h1>
    @if ($url && $actionName)
      <a class="flex items-center justify-end p-1 text-blue-500" href="{{ route($url) }}">
        {{ $actionName }}
        <i class="fa-solid fa-arrow-up-right-from-square ms-1 flex items-center"></i>
      </a>
    @endif
  </div>
  <div class="overflow-hidden rounded-lg bg-white">
    {{ $slot }}
  </div>
</div>
