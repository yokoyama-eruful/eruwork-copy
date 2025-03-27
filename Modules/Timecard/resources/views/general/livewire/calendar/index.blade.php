<div class="flex w-full justify-between">
  @include('timecard::general.livewire.calendar.desktop.input-area')
  <div class="w-full rounded-t bg-white py-2 xl:w-9/12 xl:px-5">
    <div class="flex flex-col justify-center xl:my-5 xl:flex-row xl:items-center xl:justify-between">
      <div class="mb-2 block xl:hidden">{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
      <div class="flex items-center md:ml-0">
        <button
          class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
          wire:click="selectedMonth('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
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
          wire:click="selectedMonth('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
          <p class="hidden sm:block">翌月</p>
          <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="h-10">
          <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main"
            wire:click="selectedMonth('{{ now()->format('Y-m-d') }}')">今月</button>
        </div>
      </div>
      <div class="my-2 text-gray-800 xl:my-0">
        勤怠時間: {{ $totalWorkingTime }}
      </div>
    </div>
    <div x-data="{ openModal: false }">
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
          @foreach ($this->calendar as $content)
            <div @click="openModal ='true'" @class([
                'cursor-pointer flex flex-col min-h-24 border',
                'bg-sky-100' => $content['type'] == '土曜日',
                'bg-red-100' => $content['type'] == '日曜日',
                'bg-orange-200' =>
                    $content['type'] == '公休日' &&
                    $content['date']->format('Y-m-d') != $selectedDate->format('Y-m-d'),
                'bg-yellow-200' =>
                    $content['date']->format('Y-m-d') === $selectedDate->format('Y-m-d'),
                'bg-gray-100 hidden sm:block' => $content['type'] == '補助日',
            ])
              wire:click="clickDate('{{ $content['date'] }}')"
              wire:key="calendar-box-{{ $content['date']->format('Y-m-d') }}">
              <div class="flex justify-between">
                <div class="ms-1">{{ $content['date']->isoFormat('D日') }}</div>
              </div>
              <div class="flex flex-col items-center justify-center px-1 text-center sm:text-sm">
                @foreach ($content['workTimes'] as $key => $time)
                  <div class="flex rounded-sm py-1" wire:key="{{ $time->id }}">
                    <span>
                      {{ (is_null($time->in_time) ? ' -- : -- ' : $time->in_time->format('H:i')) . ' ～ ' . (is_null($time->out_time) ? ' -- : -- ' : $time->out_time->format('H:i')) }}
                    </span>
                  </div>
                @endforeach
              </div>
            </div>
          @endforeach
        </div>
      </div>
      <div class="sm:hidden" style="display: none;" x-show="openModal" @click.outside="openModal = false">
        @include('timecard::general.livewire.calendar.modal')
      </div>
    </div>
  </div>
</div>
