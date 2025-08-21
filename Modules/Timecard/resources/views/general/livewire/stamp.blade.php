<div>
  @vite(['Modules/Timecard/resources/css/general/stamp.css'])
  <div class="sidebar-title">
    <h5 class="font-bold">タイムカード</h5>
    <a class="sidebar-link" href="{{ route('timecard.index') }}">
      勤怠記録へ
      <img src="img/icon/transition-link.png" />
    </a>
  </div>
  <div class="timecard-area" wire:poll.1s="updateClock">
    <p class="date">{{ $currentDate }}</p>
    <p class="time-display">{{ $currentTime }}</p>
  </div>
  <div class="timerecord-button-area">
    <button class="shape-stamp-in" wire:click="push('in')" @if (array_search('in', $buttonStatus) === false) disabled @endif>出勤</button>
    <button class="shape-stamp-out" wire:click="push('out')"
      @if (array_search('out', $buttonStatus) === false) disabled @endif>退勤</button>
  </div>
  <div class="timerecord-button-area">
    <button class="shape-stamp-b-start" wire:click="push('break_start')"
      @if (array_search('break_start', $buttonStatus) === false && array_search('out', $buttonStatus) === false) disabled @endif>休憩開始</button>
    <button class="shape-stamp-b-end" wire:click="push('break_end')"
      @if (array_search('break_end', $buttonStatus) === false) disabled @endif>休憩終了</button>
  </div>

  <div class="day-timerecord-area">
    <p class="day-timerecord-title">本日の打刻時間</p>
    <div class="day-timerecord-box">
      <p class="stamp-start">出 勤</p>
      <input value="{{ $workTimes?->in_time->format('H:i') }}" placeholder="--:--" />
    </div>
    <div class="day-timerecord-box">
      <p class="stamp-end">退 勤</p>
      <input value="{{ $workTimes?->out_time?->format('H:i') }}" placeholder="--:--" />
    </div>
    <div class="day-timerecord-box">
      <p class="stamp-break">休 憩</p>
      <input value="{{ $workTimes?->break_start?->format('H:i') }} - {{ $workTimes?->break_end?->format('H:i') }}"
        placeholder="--:--" />
    </div>
  </div>
</div>
