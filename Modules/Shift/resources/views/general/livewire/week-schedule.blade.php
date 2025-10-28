<x-main.index>
  <x-main.top>
    <div class="hidden flex-row items-center space-x-5 lg:flex">
      <div class="flex flex-row">
        <a class="rounded-l border border-[#3289FA] bg-[#3289FA] px-[22px] text-[15px] text-white"
          href="{{ route('shift.schedule', ['category' => 'week']) }}">週</a>
        <a class="rounded-r border border-[#3289FA] bg-white px-[22px] text-[15px] text-[#3289FA]"
          href="{{ route('shift.schedule', ['category' => 'day']) }}">日</a>
      </div>
      <div class="flex items-center md:ml-0">
        <button class="flex items-center space-x-1 rounded-l text-[15px] xl:px-2" wire:click="setPreviousWeek">
          <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-l.png') }}" alt="先週">
          <p class="hidden lg:block">先週</p>
        </button>
        <div class="flex flex-row space-x-[5px]">
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewYear" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['year'] as $year)
              <option value="{{ $year }}">{{ $year }}年</option>
            @endforeach
          </select>
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewMonth" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['month'] as $month)
              <option value="{{ $month }}">{{ $month }}月</option>
            @endforeach
          </select>
          <select class="rounded border border-[#DDDDDD]" wire:model.change="viewDay" wire:change="pullDownDateMenu">
            @foreach ($pullDownMenu['day'] as $day)
              <option value="{{ $day }}">{{ $day }}日</option>
            @endforeach
          </select>
        </div>
        <button class="flex items-center space-x-1 rounded-r text-[15px] xl:px-2" wire:click="setNextWeek">
          <p class="hidden lg:block">翌週</p>
          <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-r.png') }}" alt="翌週">
        </button>
        <div class="">
          <button class="mx-2 h-[25px] rounded border bg-[#77829C] px-2 text-xs text-white"
            wire:click="setToday">今日</button>
        </div>
      </div>
    </div>

    <div class="flex w-full flex-col lg:hidden">
      <div class="flex items-center justify-between">
        <div class="text-xl font-bold">シフト表</div>
        <div class="flex items-center space-x-2">
          <a class="flex items-center space-x-1 hover:opacity-40" href="{{ route('shift.submission.index') }}">
            <p class="text-xs text-[#3289FA]">シフト一覧</p>
            <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path fill-rule="evenodd" clip-rule="evenodd"
                d="M9.84375 1.40625H13.125C13.2493 1.40625 13.3685 1.45564 13.4565 1.54354C13.5444 1.63145 13.5938 1.75068 13.5938 1.875V5.15625C13.5938 5.28057 13.5444 5.3998 13.4565 5.48771C13.3685 5.57561 13.2493 5.625 13.125 5.625C13.0007 5.625 12.8815 5.57561 12.7935 5.48771C12.7056 5.3998 12.6562 5.28057 12.6562 5.15625V3.00625L5.01875 10.6438C4.92989 10.7266 4.81236 10.7716 4.69092 10.7695C4.56949 10.7673 4.45362 10.7181 4.36774 10.6323C4.28185 10.5464 4.23266 10.4305 4.23052 10.3091C4.22837 10.1876 4.27345 10.0701 4.35625 9.98125L11.9938 2.34375H9.84375C9.71943 2.34375 9.6002 2.29436 9.51229 2.20646C9.42439 2.11855 9.375 1.99932 9.375 1.875C9.375 1.75068 9.42439 1.63145 9.51229 1.54354C9.6002 1.45564 9.71943 1.40625 9.84375 1.40625ZM3.28125 4.21875C3.03261 4.21875 2.79415 4.31752 2.61834 4.49334C2.44252 4.66915 2.34375 4.90761 2.34375 5.15625V11.7188C2.34375 11.9674 2.44252 12.2058 2.61834 12.3817C2.79415 12.5575 3.03261 12.6562 3.28125 12.6562H9.84375C10.0924 12.6562 10.3308 12.5575 10.5067 12.3817C10.6825 12.2058 10.7812 11.9674 10.7812 11.7188V6.5625C10.7812 6.43818 10.8306 6.31895 10.9185 6.23104C11.0065 6.14314 11.1257 6.09375 11.25 6.09375C11.3743 6.09375 11.4935 6.14314 11.5815 6.23104C11.6694 6.31895 11.7188 6.43818 11.7188 6.5625V11.7188C11.7188 12.216 11.5212 12.6929 11.1696 13.0446C10.8179 13.3962 10.341 13.5938 9.84375 13.5938H3.28125C2.78397 13.5938 2.30706 13.3962 1.95542 13.0446C1.60379 12.6929 1.40625 12.216 1.40625 11.7188V5.15625C1.40625 4.65897 1.60379 4.18206 1.95542 3.83042C2.30706 3.47879 2.78397 3.28125 3.28125 3.28125H8.4375C8.56182 3.28125 8.68105 3.33064 8.76896 3.41854C8.85686 3.50645 8.90625 3.62568 8.90625 3.75C8.90625 3.87432 8.85686 3.99355 8.76896 4.08146C8.68105 4.16936 8.56182 4.21875 8.4375 4.21875H3.28125Z"
                fill="#3289FA" />
            </svg>
          </a>
          <livewire:shift::general.pattern-create-modal />
        </div>
      </div>
      @if ($manager)
        <div class="mt-[30px]">
          <div class="text-[11px] font-bold">シフト提出依頼</div>
          <div class="mt-2 grid grid-cols-[80%,20%] bg-[#F7F7F7] px-5 py-2">
            <div class="grid grid-rows-2">
              <div class="flex items-center">
                <div @class([
                    'truncate px-[10px] w-fit font-bold text-xs text-white rounded-full py-[3px]',
                    'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                    'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                    'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
                ])>
                  {{ $manager->ReceptionStatus }}
                </div>
                <div class="ml-[8px] text-sm text-[#FF4A62]">
                  {{ $manager->submission_end_date->isoFormat('MM.DD（ddd）まで') }}</div>
              </div>
              <div class="mt-1 text-[16px] font-bold">{{ $manager->start_date->isoFormat('YYYY.MM.DD') }}～
                {{ $manager->end_date->isoFormat('MM.DD') }}</div>
            </div>
            <a class="flex items-center justify-end text-sm text-[#3289FA] hover:opacity-40"
              href="{{ route('shift.submission.show', ['manager' => $manager->id]) }}">入力する</a>
          </div>
        </div>
      @endif
    </div>
  </x-main.top>
  <x-main.container>
    <div class="hidden items-center justify-between lg:flex">
      <h5 class="text-xl font-bold">シフト表</h5>
      <div class="flex items-center space-x-[30px]">
        @if ($manager)
          <div class="flex items-center">
            <p class="text-xs">シフト提出依頼：</p>
            <div class="ml-3 flex h-[45px] items-center rounded bg-[#F7F7F7] px-5">
              <div @class([
                  'hidden truncate px-[10px] w-fit font-bold lg:block text-xs text-white rounded-full py-[3px]',
                  'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                  'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                  'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
              ])>
                {{ $manager->ReceptionStatus }}
              </div>
              <div class="ml-[11px] font-semibold">{{ $manager->start_date->isoFormat('MM/DD（ddd）') }}～
                {{ $manager->end_date->isoFormat('MM/DD（ddd）') }}</div>
              <a class="ml-[10px] text-xs text-[#3289FA] hover:opacity-40"
                href="{{ route('shift.submission.show', ['manager' => $manager]) }}">シフトを入力する</a>
              <hr class="mx-5 h-5 border-r" />

              <p class="text-xs">期限：</p>
              <div class="ml-[8px] font-semibold text-[#FF4A62]">
                {{ $manager->submission_end_date->isoFormat('YYYY年MM/DD（ddd）まで') }}</div>
            </div>
          </div>
        @endif
      </div>
    </div>

    <div class="mb-[12px] mt-[35px] flex items-center justify-between px-5 lg:mb-[14px] lg:mt-[17px] lg:px-0">
      <div class="flex items-center">
        <p class="text-xs text-[#AAB0B6]">期間：</p>
        <div class="pl-1 text-sm font-semibold lg:text-xl">
          {{ $startDate->isoFormat('M/D日（ddd）') }} ～ {{ $endDate->isoFormat('M/D日（ddd）') }}</div>
      </div>
      <div class="hidden items-center space-x-5 lg:flex">
        <a class="flex items-center space-x-1 hover:opacity-40" href="{{ route('shift.submission.index') }}">
          <p class="text-xs text-[#3289FA]">シフト一覧</p>
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M9.84375 1.40625H13.125C13.2493 1.40625 13.3685 1.45564 13.4565 1.54354C13.5444 1.63145 13.5938 1.75068 13.5938 1.875V5.15625C13.5938 5.28057 13.5444 5.3998 13.4565 5.48771C13.3685 5.57561 13.2493 5.625 13.125 5.625C13.0007 5.625 12.8815 5.57561 12.7935 5.48771C12.7056 5.3998 12.6562 5.28057 12.6562 5.15625V3.00625L5.01875 10.6438C4.92989 10.7266 4.81236 10.7716 4.69092 10.7695C4.56949 10.7673 4.45362 10.7181 4.36774 10.6323C4.28185 10.5464 4.23266 10.4305 4.23052 10.3091C4.22837 10.1876 4.27345 10.0701 4.35625 9.98125L11.9938 2.34375H9.84375C9.71943 2.34375 9.6002 2.29436 9.51229 2.20646C9.42439 2.11855 9.375 1.99932 9.375 1.875C9.375 1.75068 9.42439 1.63145 9.51229 1.54354C9.6002 1.45564 9.71943 1.40625 9.84375 1.40625ZM3.28125 4.21875C3.03261 4.21875 2.79415 4.31752 2.61834 4.49334C2.44252 4.66915 2.34375 4.90761 2.34375 5.15625V11.7188C2.34375 11.9674 2.44252 12.2058 2.61834 12.3817C2.79415 12.5575 3.03261 12.6562 3.28125 12.6562H9.84375C10.0924 12.6562 10.3308 12.5575 10.5067 12.3817C10.6825 12.2058 10.7812 11.9674 10.7812 11.7188V6.5625C10.7812 6.43818 10.8306 6.31895 10.9185 6.23104C11.0065 6.14314 11.1257 6.09375 11.25 6.09375C11.3743 6.09375 11.4935 6.14314 11.5815 6.23104C11.6694 6.31895 11.7188 6.43818 11.7188 6.5625V11.7188C11.7188 12.216 11.5212 12.6929 11.1696 13.0446C10.8179 13.3962 10.341 13.5938 9.84375 13.5938H3.28125C2.78397 13.5938 2.30706 13.3962 1.95542 13.0446C1.60379 12.6929 1.40625 12.216 1.40625 11.7188V5.15625C1.40625 4.65897 1.60379 4.18206 1.95542 3.83042C2.30706 3.47879 2.78397 3.28125 3.28125 3.28125H8.4375C8.56182 3.28125 8.68105 3.33064 8.76896 3.41854C8.85686 3.50645 8.90625 3.62568 8.90625 3.75C8.90625 3.87432 8.85686 3.99355 8.76896 4.08146C8.68105 4.16936 8.56182 4.21875 8.4375 4.21875H3.28125Z"
              fill="#3289FA" />
          </svg>
        </a>
        <livewire:shift::general.pattern-create-modal />
      </div>
    </div>
    <hr class="border-t">

    <div class="mt-5 flex w-full items-center justify-between px-5 lg:hidden">
      <button class="flex items-center space-x-1 rounded-l text-[15px] text-[#5E5E5E] xl:px-2"
        wire:click="setPreviousWeek">
        <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-l.png') }}" alt="先週">
        <p>先週</p>
      </button>
      <div class="text-xl font-bold">{{ $startDate->isoFormat('M月') }}</div>
      <button class="flex items-center space-x-1 rounded-r text-[15px] text-[#5E5E5E] xl:px-2" wire:click="setNextWeek">
        <p>翌週</p>
        <img class="h-[18px] w-[18px]" src="{{ asset('img/icon/arrow-r.png') }}" alt="翌週">
      </button>
    </div>

    <div class="mt-[15px] w-full overflow-x-auto lg:mt-6 lg:overflow-hidden">
      <!-- thead -->
      <table class="sticky -top-6 w-full min-w-full table-fixed border-separate border-spacing-0 bg-white">
        <thead>
          <tr>
            <th class="w-[100px] text-xs font-normal text-[#3289FA] lg:w-32"></th>
            @foreach ($this->calendar as $content)
              <th
                class="{{ $content['date']->format('Ymd') === now()->format('Ymd')
                    ? 'font-bold text-[#3289FA] bg-[#3289FA] bg-opacity-10 rounded-lg'
                    : ($content['type'] === '土曜日'
                        ? 'font-normal text-[#48CBFF]'
                        : ($content['type'] === '日曜日'
                            ? 'font-normal text-[#FF0000]'
                            : ($content['type'] === '公休日'
                                ? 'font-normal text-orange-200'
                                : 'font-normal text-black'))) }} w-[100px] py-[6px] text-[15px] lg:w-32">
                <p class="hidden lg:block">{{ $content['date']->isoFormat('M/D(ddd)') }}</p>
                <div class="block lg:hidden">
                  <p>{{ $content['date']->isoFormat('ddd') }}</p>
                  <p>{{ $content['date']->isoFormat('D') }}</p>
                </div>
              </th>
            @endforeach
          </tr>
        </thead>
      </table>

      <div class="mt-[9px] w-full rounded-lg border-gray-300 lg:overflow-x-auto lg:border">
        <table class="min-w-full table-fixed border-collapse border border-gray-300 lg:border-none">
          <tbody>
            @foreach ($this->shiftSchedules as $user)
              <tr class="h-[100px] lg:h-[137px]">
                <td
                  class="min-w-[100px] max-w-[100px] break-words border-b border-r border-gray-300 px-[15px] text-[15px] font-bold lg:min-w-32 lg:max-w-32">
                  {{ $user['name'] }}
                </td>
                @foreach ($user['schedules'] as $daySchedules)
                  <td
                    class="min-w-[100px] max-w-[100px] border-b border-r border-gray-300 py-[10px] align-top lg:min-w-32 lg:max-w-32 lg:py-[15px]">
                    @foreach ($daySchedules as $schedule)
                      <div
                        class="mr-[10px] truncate rounded-lg border border-[#39A338] bg-[#F6FFF6] px-2 py-1 text-[#39A338] lg:px-[10px] lg:py-2">
                        <div class="text-sm font-bold">出勤</div>
                        <div class="hidden text-sm lg:block">
                          {{ $schedule->start_time->isoFormat('H:mm') . '～' . $schedule->end_time->isoFormat('H:mm') }}
                        </div>
                        <div class="block text-sm lg:hidden">
                          {{ $schedule->start_time->isoFormat('H:mm') }}<br>
                          {{ '～' . $schedule->end_time->isoFormat('H:mm') }}
                        </div>
                      </div>
                    @endforeach
                  </td>
                @endforeach
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

  </x-main.container>
</x-main.index>
