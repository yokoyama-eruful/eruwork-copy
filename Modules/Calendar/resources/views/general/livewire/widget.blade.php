<div>
  <div class="hidden lg:block">
    <x-main.top>
      <button
        class="mr-5 flex h-[35px] items-center rounded-[5px] bg-[#3289fa] px-5 py-2 text-[14px] font-bold text-white hover:bg-[#3289fa4d]"
        type="button" x-on:click="$dispatch('open-modal', 'create-modal-{{ $startDate->format('Y-m-d') }}')">
        <img class="mr-[5px] h-[14px] w-[14px]" src="img/icon/add-schedule.png" />
        <p>予定</p>
        <p class="hidden tablet:block">を</p>
        <p>追加</p>
        <p class="hidden tablet:block">する</p>
      </button>
      <livewire:calendar::general.create-schedule @added="$refresh" :date="$startDate" />
      <div class="flex items-center">
        <button class="mr-2.5 hidden items-center space-x-1 bg-transparent text-[15px] text-gray-500 tablet:flex"
          wire:click="setPreviousWeek">
          <i class="fa-solid fa-angle-left"></i>
          <p>先週</p>
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
        <button class="ml-2.5 mr-5 hidden items-center space-x-1 bg-transparent text-[15px] text-gray-500 tablet:flex"
          wire:click="setNextWeek">
          <p>翌週</p>
          <i class="fa-solid fa-angle-right"></i>
        </button>
        <button class="today-btn" wire:click="setToday">今日</button>
        {{-- シフト通知の読み込み --}}
        {{-- <livewire:shift::general.widget /> --}}
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
                <div class="deck">
                  @foreach ($content['schedules'] as $schedule)
                    @php
                      $hourStart = (int) $schedule->start_time->format('H');
                      $minuteStart = (int) $schedule->start_time->format('i');
                      $hourEnd = (int) $schedule->end_time->format('H');
                      $minuteEnd = (int) $schedule->end_time->format('i');

                      $top = $hourStart * 50 + ($minuteStart >= 30 ? 25 : 0);
                      $height = ($hourEnd - $hourStart) * 50 + ($minuteEnd - $minuteStart >= 30 ? 25 : 0);
                      if ($height <= 60) {
                          $height = 60;
                      }
                    @endphp

                    {{-- スケジュール --}}
                    <div
                      class="card absolute cursor-pointer rounded-[10px] border border-[#00A1FF] bg-[#F2FBFF] p-2 text-[#00A1FF] transition-all"
                      x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')"
                      :style="'top: {{ $top }}px; height: {{ $height }}px;'">
                      <p class="truncate text-[14px] font-bold">{{ $schedule->title }}</p>
                      {{-- @if ($height > 50) --}}
                      <p class="text-[14px]">
                        {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}</p>
                      {{-- @endif --}}
                    </div>
                    <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule :key="$schedule->id . $content['date']->format('Ymd')" />
                  @endforeach

                  @if (
                      $this->getYesterday($content['date']->format('Y-m-d')) &&
                          $this->getYesterday($content['date']->format('Y-m-d'))->end_time->lt(
                              $this->getYesterday($content['date']->format('Y-m-d'))->start_time))
                    <div
                      class="card absolute cursor-pointer rounded-[10px] border border-[#39A338] bg-[#F6FFF6] p-2 text-[#39A338] transition-all"
                      :style="'top: 0px; height: {{ $this->getYesterdayHeight($content['date']->format('Y-m-d')) }}px;'">
                      <p class="text-[14px] font-bold">出勤日</p>
                      {{-- @if ($height > 50) --}}
                      <p class="text-[14px]">
                        {{ $this->getYesterday($content['date']->format('Y-m-d'))->start_time->format('H:i') . '～' . $this->getYesterday($content['date']->format('Y-m-d'))->end_time?->format('H:i') }}
                      </p>
                      {{-- @endif --}}
                    </div>
                  @endif

                  {{-- シフト --}}
                  @foreach ($content['shifts'] as $shift)
                    {{-- 確定シフト --}}
                    <div
                      class="card absolute cursor-pointer rounded-[10px] border border-[#39A338] bg-[#F6FFF6] p-2 text-[#39A338] transition-all"
                      :style="'top: {{ $this->getShiftHeight($shift)['top'] }}px; height: {{ $this->getShiftHeight($shift)['height'] }}px;'">
                      <p class="text-[14px] font-bold">出勤日</p>
                      {{-- @if ($height > 50) --}}
                      <p class="text-[14px]">
                        {{ $shift->start_time->format('H:i') . '～' . $shift->end_time?->format('H:i') }}</p>
                      {{-- @endif --}}
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>

        </div>
      </div>
    </x-main.container>
  </div>

  <div class="calender-area-sp lg:hidden">
    <h3 class="calender-sp-title">今週の予定</h3>
    <div class="calendar-sp-month-day">
      <h4 class="min-w-[70px]">{{ $selectDate->format('m月') }}</h4>
      <div class="calendar-sp-day">
        <ul>
          @foreach ($this->calendar as $key => $content)
            <li @class([
                'calendar-sp-day-box',
                'current' =>
                    $content['date']->format('Y-m-d') === $selectDate->format('Y-m-d'),
            ]) wire:click="selectedDate('{{ $content['date']->format('Y-m-d') }}')">
              <div class="calendar-sp-ddd">
                <span>{{ $content['date']->isoFormat('ddd') }}</span>
                {{ $content['date']->isoFormat('D') }}
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
    <div class="schedule-box-area">
      <h4>{{ $selectDate->format('m.d') }}の予定</h4>
      <div class="schedule-detail-box space-y-2">
        @if ($mobileSchedules->isNotEmpty() || $mobileShiftSchedules->isNotEmpty())
          @foreach ($mobileShiftSchedules as $shift)
            <div class="rounded-[10px] border border-[#39A338] bg-[#F6FFF6] px-[10px] py-4 text-[#39A338]">
              <div class="text-[15px] font-bold">出勤</div>
              <div class="text-sm font-bold">
                {{ $shift->start_time->isoFormat('H:mm') }}～
                {{ $shift->end_time->isoFormat('H:mm') }}
              </div>
            </div>
          @endforeach
          @foreach ($mobileSchedules as $schedule)
            <div class="rounded-[10px] border border-[#00A1FF] bg-[#F2FBFF] px-[10px] py-4 text-[#00A1FF]"
              x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')">
              <div class="text-[15px] font-bold">{{ $schedule->title }}</div>
              <div class="text-sm font-bold">
                {{ $schedule->start_time->isoFormat('H:mm') }}～
                {{ $schedule->end_time->isoFormat('H:mm') }}
              </div>
            </div>
            <livewire:calendar::general.edit-schedule @updated="$refresh" :$schedule :key="$schedule->id . $content['date']->format('Ymd')" />
          @endforeach
        @else
          <p>予定は入っていません</p>
        @endif
      </div>
    </div>
  </div>
</div>
