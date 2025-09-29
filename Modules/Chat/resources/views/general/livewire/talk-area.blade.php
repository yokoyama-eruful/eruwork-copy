<div class="h-full overflow-y-auto" x-data x-init="$nextTick(() => { $el.scrollTop = $el.scrollHeight })"
  @scroll="if ($el.scrollTop === 0) {
        $dispatch('addViewMessage');
        $el.scrollTop += 1;
      }">

  @php
    $previousDate = null;
  @endphp
  @foreach ($this->messages as $message)
    @php
      $messageDate = $message->created_at->format('Y-m-d');
    @endphp

    {{-- 日付ラベル --}}
    @if ($previousDate !== $messageDate)
      <div @class([
          'my-5 flex items-center text-xs font-bold py-[5.5px] px-[10px] rounded',
          'bg-[#3289FA1A] bg-opacity-10 text-[#3289FA] w-fit' =>
              $message->created_at->format('Ymd') == now()->format('Ymd'),
      ])>
        <div class="">{{ $message->created_at->isoFormat('M月D日（ddd）') }}</div>
        @if ($message->created_at->format('Ymd') != now()->format('Ymd'))
          <div class="flex-1 border-t border-gray-300"></div>
        @endif
      </div>
      @php $previousDate = $messageDate; @endphp
    @endif

    <div class="my-5 grid grid-cols-[65px,1fr] gap-2">
      <!-- 左側（1エリア固定） -->
      <div class="flex justify-center">
        @if ($message->user->icon)
          <img class="h-[45px] w-[45px] rounded-full border bg-white" src="{{ $message->user->icon }}" alt="アイコン">
        @else
          <div class="flex h-[45px] w-[45px] items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
      </div>

      <!-- 右側（上下2エリア） -->
      <div class="grid grid-rows-[auto,1fr] gap-2">
        <div class="flex space-x-3">
          <div class="text-xs">{{ $message->user->name }}</div>
          <div class="text-xs text-[#AAB0B6]">{{ $message->created_at->format('H:i') }}</div>
          <div class="text-xs text-[#AAB0B6]">{{ $message->readStatuses }}</div>
        </div>
        <div class="w-fit break-all rounded-bl-xl rounded-br-xl rounded-tr-xl bg-[#F7F7F7] px-5 py-[11px]">
          {!! $message->message !!}
          <div class="flex flex-row space-x-2">
            @foreach ($message->images as $image)
              <div x-data="{ viewImage{{ $image->id }}: false }">
                <img class="max-h-20 rounded hover:cursor-zoom-in" src="{{ $image->file_path }}"
                  x-on:click="viewImage{{ $image->id }} = true">

                <div class="fixed inset-0 z-10 flex items-center justify-center"
                  x-show="viewImage{{ $image->id }} == true" x-cloak x-transition>
                  <button
                    class="hover:bg-gray-5900hover:text-red-600 absolute right-5 top-5 z-10 h-10 w-10 rounded-md bg-gray-400"
                    x-on:click="viewImage{{ $image->id }} = false"><i class="fa-solid fa-xmark"></i></button>
                  <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                  <div class="relative z-10 flex max-h-[100vh] max-w-[100vh] items-center justify-center">
                    <img class="max-h-[90vh] max-w-[90vw] object-contain" src="{{ $image->file_path }}"
                      x-on:click.away="viewImage{{ $image->id }} = false">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
