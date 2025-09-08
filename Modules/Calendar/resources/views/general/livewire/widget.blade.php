<x-main.index class="hidden sm:block">
  <x-main.top>
    <button class="add-schedule" type="button"
      x-on:click="$dispatch('open-modal', 'create-modal-{{ $startDate->format('Y-m-d') }}')">
      <img src="img/icon/add-schedule.png" />
      予定を追加する
    </button>
    <livewire:calendar::general.create-schedule @added="$refresh" :date="$startDate" />
    <div class="flex items-center">
      <button class="calender-move" wire:click="setPreviousWeek">
        <i class="fa-solid fa-angle-left"></i>
        先週
      </button>
      <div class="flex flex-row space-x-[5px]">
        <select class="rounded border border-[#DDDDDD]" wire:model.change="year" wire:change="updateCalendar">
          @foreach ($pullDownMenu['year'] as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="rounded border border-[#DDDDDD]" wire:model.change="month" wire:change="updateCalendar">
          @foreach ($pullDownMenu['month'] as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
        <select class="rounded border border-[#DDDDDD]" wire:model.change="day" wire:change="updateCalendar">
          @foreach ($pullDownMenu['day'] as $day)
            <option value="{{ $day }}">{{ $day }}日</option>
          @endforeach
        </select>
      </div>
      <button class="calender-move2" wire:click="setNextWeek">
        翌週
        <i class="fa-solid fa-angle-right"></i>
      </button>
      <button class="today-btn" wire:click="setToday">今日</button>
      {{-- シフト通知の読み込み --}}
      <livewire:shift::general.widget />
    </div>
  </x-main.top>
  <x-main.container>
    <div class="calendar-body">
      <!-- 左：月（固定）＋ 時間軸（固定） -->
      <div class="calendar-left">
        <div class="month-label">{{ $startDate->isoFormat('M月') }}</div>
        <div class="calender-time-column">
          @for ($h = 0; $h < 24; $h++)
            @php
              $ampm = $h < 12 ? '午前' : '午後';
              $hour = $h % 12 === 0 ? 12 : $h % 12;
            @endphp
            <div class="time-cell"><span @class(['tick-label', 'current-time' => $h == now()->format('H')])>{{ $ampm }} {{ $hour }}時</span>
            </div>
          @endfor
        </div>
      </div>

      <!-- 右：ヘッダー（日付）＋ スケジュール（同じ横スクロール） -->
      <div class="schedule-scroll">
        <!-- ヘッダー（日付） -->
        <div class="top-calender-day-area">
          @foreach ($this->calendar as $key => $content)
            <div @class([
                'top-calender-day' =>
                    $content['date']->format('Y-m-d') !== now()->format('Y-m-d'),
                'top-calender-day calender-today-color' =>
                    $content['date']->format('Y-m-d') === now()->format('Y-m-d'),
            ])>
              <span class="otherday">{{ $content['date']->isoFormat('ddd') }}</span>
              <p>{{ $content['date']->isoFormat('D') }}</p>
            </div>
          @endforeach
        </div>

        <!-- スケジュール本体 -->

        <div class="calender-schedule-grid" style="--current-hour: {{ now()->format('H') }};">
          @foreach ($this->calendar as $key => $content)
            <div class="schedule-day relative">
              @php
                $schedules = $content['schedules'];
                if ($schedules instanceof \Illuminate\Support\Collection) {
                    $schedules = $schedules->all();
                }
                usort($schedules, fn($a, $b) => $a->start_time <=> $b->start_time);

                $drawnSchedules = [];
              @endphp

              @foreach ($schedules as $schedule)
                @php
                  $hourStart = (int) $schedule->start_time->format('H');
                  $minuteStart = (int) $schedule->start_time->format('i');
                  $hourEnd = (int) $schedule->end_time->format('H');
                  $minuteEnd = (int) $schedule->end_time->format('i');

                  $top = $hourStart * 50 + ($minuteStart >= 30 ? 25 : 0);
                  $height = ($hourEnd - $hourStart) * 50 + ($minuteEnd - $minuteStart >= 30 ? 25 : 0);
                  if ($height <= 40) {
                      $height = 40;
                  }

                  // 重なりカウント
                  $overlapIndex = 0;
                  foreach ($drawnSchedules as $d) {
                      $dStart = (int) $d->start_time->format('H') * 60 + (int) $d->start_time->format('i');
                      $dEnd = (int) $d->end_time->format('H') * 60 + (int) $d->end_time->format('i');
                      $sStart = $hourStart * 60 + $minuteStart;
                      $sEnd = $hourEnd * 60 + $minuteEnd;

                      if ($sStart < $dEnd && $sEnd > $dStart) {
                          $overlapIndex++;
                      }
                  }

                  $zIndex = 5 + $overlapIndex;

                  // 一番手前（上に表示される）だけ左をずらす
                  $leftOffset = $overlapIndex > 0 ? $overlapIndex * 8 : 0;

                  $classes =
                      'absolute right-0 cursor-pointer rounded-[10px] border border-[#00A1FF] bg-[#F2FBFF] p-2 text-[#00A1FF] transition-all';
                @endphp

                <div class="{{ $classes }}"
                  x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')"
                  :style="'top: {{ $top }}px; height: {{ $height }}px; z-index: {{ $zIndex }}; left: {{ $leftOffset }}px;'">
                  <p class="font-bold">{{ $schedule->title }}</p>
                  @if ($height > 40)
                    <p>{{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}</p>
                  @endif
                </div>

                <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule :key="$schedule->id . $content['date']->format('Ymd')" />

                @php $drawnSchedules[] = $schedule; @endphp
              @endforeach
            </div>
          @endforeach
        </div>

      </div>
    </div>
  </x-main.container>
</x-main.index>
