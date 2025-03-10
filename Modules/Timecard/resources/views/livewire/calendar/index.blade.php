<div class="flex w-full justify-between">
  <div class="hidden w-3/12 flex-col px-3 py-4 xl:block">
    <div>{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
    <div class="mb-2 flex flex-col space-y-5 border-t-8 border-ao-main bg-ao-sub p-5" wire:key="attendace-view-area">
      <div>
        <div class="flex justify-between">
          <div>勤務時間</div>
          @livewire('timecard::create-work-time', ['selectedDate' => $selectedDate])
        </div>
        <div class="bg-white p-2">
          @forelse ($this->workTime as $key => $attendance)
            <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 bg-white hover:bg-sky-200"
              wire:key="{{ $attendance->id }}">
              <div class="ms-1 min-w-32 leading-5 text-gray-800">
                {{ $attendance->in_time->format('H:i') . ' ～ ' . ($attendance->out_time?->format('H:i') ?? '--:--') }}
              </div>
              @livewire('timecard::edit-work-time', ['attendance' => $attendance], key($attendance->id))
            </div>
          @empty
            <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 hover:bg-sky-200">
              <div class="p-1 leading-5 text-gray-800">
                記録なし
              </div>
            </div>
          @endforelse
        </div>
      </div>

      <div>
        <div class="flex justify-between">
          <div class="">休憩時間</div>
          @livewire('timecard::create-break-time', ['selectedDate' => $selectedDate])
        </div>
        <div class="bg-white p-2">
          @forelse ($this->breakTime as $key => $attendance)
            <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 bg-white hover:bg-sky-200"
              wire:key="{{ $attendance->id }}">
              <div class="ms-1 min-w-32 leading-5 text-gray-800">
                {{ $attendance->start_time->format('H:i') . ' ～ ' . ($attendance->end_time?->format('H:i') ?? ' --:-- ') }}
              </div>
              @livewire('timecard::edit-break-time', ['breakTime' => $attendance], key($attendance->id . now()))
            </div>
          @empty
            <div class="flex items-center rounded-sm border-b border-dashed border-gray-400 hover:bg-sky-200">
              <div class="p-1 leading-5 text-gray-800">
                記録なし
              </div>
            </div>
          @endforelse
        </div>
      </div>
    </div>
  </div>

  <div class="w-full rounded-t bg-white py-2 xl:w-9/12 xl:px-5">
    <div class="flex flex-col justify-center xl:my-5 xl:flex-row xl:items-center xl:justify-between">
      <div class="mb-2 block xl:hidden">{{ $selectedDate->isoFormat('Y年M月D日(ddd)') }}</div>
      {{-- <div class="flex items-center md:ml-0">
        <button
          class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
          wire:click="lastMonth">
          <i class="fa-solid fa-chevron-left"></i>
          <p class="hidden sm:block">前月</p>
        </button>
        <div class="flex flex-row">
          <select class="h-10" wire:model.change="viewYear" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['year'] as $year)
              <option value="{{ $year }}">{{ $year }}年</option>
            @endforeach
          </select>
          <select class="h-10" wire:model.change="viewMonth" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['month'] as $month)
              <option value="{{ $month }}">{{ $month }}月</option>
            @endforeach
          </select>
        </div>
        <button
          class="flex h-10 items-center space-x-1 rounded-r bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
          wire:click="nextMonth">
          <p class="hidden sm:block">翌月</p>
          <i class="fa-solid fa-chevron-right"></i>
        </button>
        <div class="h-10">
          <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main" wire:click="getToday">今月</button>
        </div>
      </div>
      <div class="my-2 text-gray-800 xl:my-0">
        勤怠時間: {{ $this->workingTotalTime }}
      </div>
    </div> --}}
      <div x-data="{ openModal: true }">
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
                  @foreach ($content['attendances'] as $key => $attendance)
                    <div class="flex rounded-sm py-1" wire:key="{{ $attendance->id }}">
                      <span>
                        {{ $attendance->in_time->format('H:i') . ' ～ ' . (is_null($attendance->out_time) ? ' -- : -- ' : $attendance->out_time->format('H:i')) }}
                      </span>
                    </div>
                  @endforeach
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <div class="sm:hidden" style="display: none;" x-show="openModal" @click.outside="openModal = false">
          @include('timecard::livewire.calendar.modal')
        </div>
      </div>
    </div>
  </div>
