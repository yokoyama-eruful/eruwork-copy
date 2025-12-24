<div class="flex h-[90%] w-[550px] flex-col items-center rounded-xl bg-white px-[60px] py-[30px] shadow">
  <div @class([
      'relative flex max-h-[80px] min-h-[80px] min-w-[80px] max-w-[80px] items-center justify-center rounded-full border-[2px] ',
      'border-[#48CBFF]' => in_array('in', $buttonStatus, true) === false,
      'border-[#B7B7B7]' => in_array('out', $buttonStatus, true) === false,
  ])>
    @if ($user?->icon)
      <img class="max-h-[70px] min-h-[70px] min-w-[70px] max-w-[70px] rounded-full object-cover"
        src="{{ route('profile.icon', ['id' => $user?->id]) }}">
    @else
      <div
        class="flex max-h-[70px] min-h-[70px] min-w-[70px] max-w-[70px] items-center justify-center rounded-full border bg-white">
        <i class="fa-solid fa-image"></i>
      </div>
    @endif
  </div>
  <div class="mt-[10px] text-xl font-bold">{{ $user?->name }}</div>
  <div class="h-full w-full">
    @vite(['Modules/Timecard/resources/css/punch/stamp.css'])

    <div class="timecard-area" wire:poll.1s="updateClock">
      <p class="date">{{ $currentDate }}</p>
      <p class="time-display">{{ $currentTime }}</p>
    </div>

    <div class="timerecord-button-area">
      <button class="shape-stamp-in" wire:click="push('in')"
        @if (array_search('in', $buttonStatus) === false) disabled @endif>出勤</button>
      <button class="shape-stamp-out" wire:click="push('out')"
        @if (array_search('out', $buttonStatus) === false) disabled @endif>退勤</button>
    </div>
    <div class="timerecord-button-area">
      <button class="shape-stamp-b-start" wire:click="push('break_start')"
        @if (array_search('break_start', $buttonStatus) === false && array_search('out', $buttonStatus) === false) disabled @endif>休憩開始</button>
      <button class="shape-stamp-b-end" wire:click="push('break_end')"
        @if (array_search('break_end', $buttonStatus) === false) disabled @endif>休憩終了</button>
    </div>

    <div class="">
      <p class="font-bold">本日の打刻時間</p>
      <div class="mt-3 max-h-[100px] overflow-y-auto">
        @foreach ($workTimes as $workTime)
          <div class="flex items-center justify-between space-x-2">
            <div class="flex items-center rounded border p-1">
              <p class="stamp-start">出 勤</p>
              <input class="w-[80%] border-none text-end text-sm focus:border-gray-300 focus:outline-none focus:ring-0"
                value="{{ $workTime->in_time ? \Carbon\Carbon::parse($workTime->in_time)->format('Y/m/d H:i') : '--:--' }}"
                readonly />
            </div>

            <div class="flex items-center rounded border p-1">
              <p class="stamp-end">退 勤</p>
              <input class="w-[80%] border-none text-end text-sm focus:border-gray-300 focus:outline-none focus:ring-0"
                value="{{ $workTime->out_time ? \Carbon\Carbon::parse($workTime->out_time)->format('Y/m/d H:i') : '--:--' }}"
                readonly />
            </div>
          </div>
        @endforeach
      </div>
      <div class="mt-2 flex items-center rounded border p-1">
        <p class="stamp-break">休 憩</p>
        <input
          class="w-[90%] border-none text-end text-sm outline-none focus:border-transparent focus:outline-none focus:ring-0 focus:ring-transparent"
          value="{{ $breakTime }}" placeholder="--:--" readonly />
      </div>
    </div>
  </div>
</div>
