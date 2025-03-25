<div>
  <div class="flex flex-row items-center space-x-5">
    <div class="hidden flex-row xl:flex">
      <button class="flex items-center justify-center border border-ao-main bg-ao-main px-7 text-white"
        @click="schedule = 'week'">週</button>
      <button class="flex items-center justify-center border border-ao-main px-7 text-ao-main hover:bg-ao-sub"
        @click="schedule = 'day'">日</button>
    </div>
    <div class="text-xl font-bold">
      {{ $startDate->isoFormat('Y/M/D日(ddd)') }}~{{ $endDate->isoFormat('Y/M/D日(ddd)') }}
    </div>
  </div>

  <div class="my-3 flex flex-row items-center md:ml-0">
    <button
      class="flex h-10 items-center space-x-1 rounded-l bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
      wire:click="setPreviousWeek">
      <i class="fa-solid fa-chevron-left"></i>
      <p>前週</p>
    </button>
    <div class="hidden flex-row xl:flex">
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
      <select class="h-10" wire:model.change="viewDay" wire:change="pullDownDateMenu">
        @foreach ($pullDownMenu['day'] as $day)
          <option value="{{ $day }}">{{ $day }}日</option>
        @endforeach
      </select>
    </div>
    <button
      class="flex h-10 items-center space-x-1 rounded-r bg-gray-800 px-4 text-gray-300 hover:bg-gray-900 hover:text-gray-400 xl:px-2"
      wire:click="setNextWeek">
      <p>翌週</p>
      <i class="fa-solid fa-chevron-right"></i>
    </button>
    <div class="h-10">
      <button class="mx-2 h-10 rounded border bg-ao-sub px-2 hover:bg-ao-main" wire:click="setToday">今日</button>
    </div>
  </div>

  <div class="hidden overflow-x-auto xl:block">
    <table class="min-w-full border-collapse border border-gray-300">
      <thead>
        <tr>
          <th class="border border-gray-300 px-4 py-1"></th>
          @foreach ($this->calendar as $content)
            <th @class([
                ' border border-gray-300 px-4 py-1 text-lg',
                'bg-blue-200' => $content['type'] === '土曜日',
                'bg-rose-200' => $content['type'] === '日曜日',
                'bg-orange-200' => $content['type'] === '公休日',
                'bg-ao-sub' => $content['type'] === '平日',
            ])>
              {{ $content['date']->isoFormat('M/D(ddd)') }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($this->shiftSchedules as $user)
          <tr class="h-12">
            <td class="border border-gray-300 px-4">{{ $user['name'] }}</td>
            @foreach ($user['schedules'] as $daySchedules)
              <td class="border border-gray-300 px-4">
                @foreach ($daySchedules as $schedule)
                  <div class='my-1 truncate bg-ao-sub text-center'>
                    {{ $schedule->start_time->format('H:i') . '～' . $schedule->end_time->format('H:i') }}
                  </div>
                @endforeach
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

  <div class="block xl:hidden">
    <table class="w-full border-collapse border-t-4 border-ao-main">
      <thead class="bg-ao-sub">
        <tr>
          <th class="border border-gray-300 py-1"></th>
          @foreach ($this->calendar as $content)
            <th @class([
                'border border-gray-300 py-1',
                'bg-blue-200' => $content['type'] === '土曜日',
                'bg-rose-200' => $content['type'] === '日曜日',
                'bg-orange-200' => $content['type'] === '公休日',
                'bg-ao-sub' => $content['type'] === '平日',
            ]) wire:click="selectDate('{{ $content['date'] }}')">
              {{ $content['date']->isoFormat('M/D') }}
            </th>
          @endforeach
        </tr>
      </thead>
      <tbody>
        @foreach ($this->shiftSchedules as $user)
          <tr class="h-10">
            <td class="max-w-20 truncate border border-gray-300">{{ $user['name'] }}</td>
            @foreach ($user['schedules'] as $daySchedules)
              <td class="border border-gray-300">
                @if (!$daySchedules->isEmpty())
                  <div class="flex items-center justify-center rounded bg-rose-400 text-white">出勤</div>
                @endif
              </td>
            @endforeach
          </tr>
        @endforeach
      </tbody>
    </table>

    <x-modal-alert name="open-attendance-modal">
      <div class="p-4">
        <div class="mb-12">
          <div class="mb-2 flex flex-col space-y-5 px-5 pt-2 text-base">
            @if ($this->userSchedules)
              <div>{{ $selectDay?->format('Y年m月d日') }}</div>
              @foreach ($this->userSchedules as $key => $shifts)
                <div class="flex flex-row justify-between border-b">
                  <div>{{ $key }}</div>
                  <div class="flex flex-col">
                    @foreach ($shifts as $shift)
                      <div class="border-b">
                        ・{{ $shift->start_time ? $shift->start_time->format('H:i') : '--:--' }} ~
                        {{ $shift->end_time ? $shift->end_time->format('H:i') : '--:--' }}
                      </div>
                    @endforeach
                  </div>
                </div>
              @endforeach
            @else
              <div>{{ $selectDay?->format('Y年m月d日') }}</div>
              <div>出勤者無し</div>
            @endif
          </div>
        </div>
        <div class="flex justify-end space-x-2">
          <x-secondary-button x-on:click="show = false">キャンセル</x-secondary-button>
        </div>
      </div>
    </x-modal-alert>
  </div>
</div>
