<x-widget>
  <div class="flex flex-wrap items-center justify-between pb-2">
    <div class="flex flex-row items-center space-x-2">
      <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
      <div class="text-lg font-bold">タイムカード</div>
    </div>
    <a class="text-ao-main hover:text-sky-700" href="{{ route('timecard.index') }}">
          詳しく見る
          <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
  </div>
  <div class="my-5 flex w-full flex-col items-center justify-center space-y-5 sm:flex-row sm:space-x-5 sm:space-y-0">
    <div class="my-2 flex w-full flex-col items-center sm:w-3/5">
      <div class="mb-5 flex flex-row items-center font-extrabold sm:space-x-3" wire:poll.20s="updateClock">
        <p class="text-xl">{{ $currentDate }}</p>
        <p class="text-4xl">{{ $currentTime }}</p>
      </div>

      <div class="flex w-full flex-row justify-center space-x-5">
        <button class="shape-stamp-in relative h-16 w-full text-xl font-extrabold sm:w-1/2" wire:click="push('in')"
          @if (array_search('in', $buttonStatus) === false) disabled @endif>
          出　勤
        </button>
        <button class="shape-stamp-out relative h-16 w-full text-xl font-extrabold sm:w-1/2" wire:click="push('out')"
          @if (array_search('out', $buttonStatus) === false) disabled @endif>
          退　勤
        </button>
      </div>

      <div class="flex w-full flex-row justify-center space-x-5">
        <div class="mt-4 flex h-10 w-full flex-row space-x-7">
          <button class="shape-stamp-in flex w-1/2 items-center justify-center text-sm" wire:click="push('break_start')"
            @if (array_search('break_start', $buttonStatus) === false && array_search('out', $buttonStatus) === false) disabled @endif>
            休憩開始
          </button>
          <button class="shape-stamp-in flex w-1/2 items-center justify-center text-sm" wire:click="push('break_end')"
            @if (array_search('break_end', $buttonStatus) === false) disabled @endif>
            休憩終了
          </button>
        </div>
      </div>
    </div>
    <div
      class="flex w-full flex-row justify-center space-x-3 rounded-md bg-ao-sub p-5 text-xl font-bold text-gray-500 sm:h-56 sm:w-56 sm:flex-col sm:space-y-5">
      <div class="flex flex-col items-center">
        <p>出　勤</p>
        <input class="h-10 w-full bg-white text-center outline-none" value="{{ $workTimes?->in_time->format('H:i') }}"
          placeholder="--:--" readonly>
      </div>
      <div class="flex flex-col items-center">
        <p>退　勤</p>
        <input class="flex h-10 w-full bg-white text-center outline-none"
          value="{{ $workTimes?->out_time?->format('H:i') }}" placeholder="--:--" readonly>
      </div>
    </div>
  </div>
</x-widget>
