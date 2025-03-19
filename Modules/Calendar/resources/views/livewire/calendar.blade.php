<div>
  <div class="mb-2 flex flex-wrap items-center justify-between">
    <div class="flex items-center md:ml-0">
      <button
        class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <i class="fa-solid fa-chevron-left"></i>
        <p class="hidden sm:block">前月</p>
      </button>
      <div class="flex flex-row">
        <select class="h-10" wire:model.live="year" wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10" wire:model.live="month" wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button
        class="flex h-10 items-center space-x-1 rounded-r bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
        wire:click="clickDate('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="hidden sm:block">翌月</p>
        <i class="fa-solid fa-chevron-right"></i>
      </button>
      <div class="h-10">
        <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main"
          wire:click="clickDate('{{ now()->format('Y-m-d') }}')">今月</button>
      </div>
    </div>
    <livewire:calendar::multi-create-schedule />
  </div>

  <div class="items-center overflow-x-auto">
    <div class="hidden w-full grid-cols-7 border sm:grid">
      <div class="border-x bg-gray-300 text-center text-gray-800">月</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">火</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">水</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">木</div>
      <div class="border-x bg-gray-300 text-center text-gray-800">金</div>
      <div class="border-x bg-sky-200 text-center text-gray-800">土</div>
      <div class="border-x bg-red-200 text-center text-gray-800">日</div>
    </div>

    <div class="grid w-full sm:grid-cols-7" wire:key="calendar-grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'cursor-pointer flex flex-col min-h-24 border',
            'bg-sky-100' => $content['type'] == '土曜日',
            'bg-red-100' => $content['type'] == '日曜日',
            'bg-orange-200' => $content['type'] == '公休日',
            'bg-gray-100 hidden sm:block' => $content['type'] == '補助日',
        ]) wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
          <div class="mx-1 flex items-center justify-between">
            @if ($content['type'] != '補助日')
              <div>
                @if ($content['date']->day == 1 || $key == 1)
                  {{ $content['date']->isoFormat('Y年M月D日') }}
                @else
                  {{ $content['date']->isoFormat('D日') }}
                @endif
              </div>
              <button class="text-2xl opacity-30 hover:text-ao-main hover:opacity-100 xl:text-xl" type="button"
                x-on:click="$dispatch('open-modal', 'create-dialog-{{ $content['date']->format('Y-m-d') }}')">
                <i class="fa-regular fa-square-plus"></i>
              </button>
            @endif
          </div>
          @foreach ($content['shifts'] as $shift)
            <button
              class="mx-1 mb-1 cursor-pointer truncate rounded border border-emerald-500 bg-emerald-300 pb-1 ps-1 hover:bg-emerald-500"
              x-on:click="$dispatch('open-modal','shift-view-modal-{{ $shift->id }}')">
              <div class="flex justify-between">
                <div class="underline decoration-gray-400">
                  シフト
                </div>
                {{-- @if ($this->overlappingSchedules($content['shifts']) || $this->overlappingShifts())
                  <i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>
                @endif --}}
              </div>
              <div class="ms-1 text-start">
                {{ $shift->start_time->format('H:i') . '～' . $shift->end_time?->format('H:i') }}
              </div>
            </button>
            @include('calendar::livewire.layouts.shift-view-modal')
          @endforeach
          @foreach ($content['schedules'] as $schedule)
            @if ($content['type'] != '補助日')
              <button
                class="mx-1 mb-1 cursor-pointer truncate rounded border border-sky-500 bg-sky-300 pb-1 ps-1 hover:bg-sky-500"
                x-on:click="$dispatch('open-modal','schedule-edit-modal-{{ $schedule->id }}')">
                <div class="flex justify-between">
                  <div class="w-full truncate text-left underline decoration-gray-400">
                    {{ $schedule->title }}
                  </div>
                  {{-- @if ($this->overlappingSchedules($content['shifts']) || $this->overlappingShifts())
                  <i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>
                @endif --}}
                </div>
                <div class="ms-1 text-start">
                  {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time?->format('H:i') }}
                </div>
              </button>
              <livewire:calendar::edit-schedule @updated="$refresh" :$schedule :key="$schedule->id . '-' . $selectedDate->format('Ymd')" />
            @endif
          @endforeach
        </div>

        @if ($content['type'] != '補助日')
          <livewire:calendar::create-schedule @added="$refresh" :date="$content['date']" :key="$content['date']->format('Ymd') . $key" />
        @endif
      @endforeach
    </div>
  </div>
