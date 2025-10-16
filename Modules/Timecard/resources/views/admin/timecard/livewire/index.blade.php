<x-dashboard.index>
  <x-dashboard.top>
    <h5 class="block text-xl font-bold lg:hidden">タイムカード管理</h5>
    <div class="hidden items-center space-x-[10px] lg:flex">
      <div class="text-[15px] text-[#5E5E5E]">出勤日表示：</div>
      <div class="flex items-center space-x-[5px]">
        <select class="h-10 w-[115px] rounded border-[#DDDDDD]" wire:model.live="year" wire:change="changeDate">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10 w-[100px] rounded border-[#DDDDDD]" wire:model.live="month" wire:change="changeDate">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
        <select class="h-10 w-[100px] rounded border-[#DDDDDD]" wire:model.live="day" wire:change="changeDate">
          @foreach (range(1, $this->daysInMonth) as $day)
            <option value="{{ $day }}">{{ $day }}日</option>
          @endforeach
        </select>
      </div>
      <button class="rounded bg-[#77829C] px-[11px] py-[5px] text-white" type="button" wire:click="today">今日</button>
    </div>
  </x-dashboard.top>
  <div class="min-h-[calc(100dvh-100px)] lg:flex">

    <div class="mt-[30px] block px-5 lg:hidden">
      <div class="text-xs font-bold">出勤日表示</div>
      <div class="mt-2 flex w-full items-center space-x-[5px]">
        <select class="h-10 w-1/3 rounded border-[#DDDDDD]" wire:model.live="year" wire:change="changeDate">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10 w-1/3 rounded border-[#DDDDDD]" wire:model.live="month" wire:change="changeDate">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
        <select class="h-10 w-1/3 rounded border-[#DDDDDD]" wire:model.live="day" wire:change="changeDate">
          @foreach (range(1, $this->daysInMonth) as $day)
            <option value="{{ $day }}">{{ $day }}日</option>
          @endforeach
        </select>
      </div>
    </div>
    <div
      class="top-container mt-[20px] h-auto min-h-full w-full rounded-[10px] lg:mt-[13px] lg:min-w-[960px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold lg:block">タイムカード管理</h5>
      <div class="block px-5 font-bold lg:hidden">{{ $selectDate?->format('Y.m.d') }}出勤者</div>
      <div
        class="mb-[9px] mt-4 grid grid-cols-[15%,44%,36%,5%] lg:mb-0 lg:mt-[30px] lg:grid-cols-[10%,40%,20%,20%,10%]">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">勤務時間</div>
        <div class="hidden text-left text-xs font-normal text-[#AAB0B6] lg:block">休憩時間</div>
        <div class="hidden text-left text-xs font-normal text-[#AAB0B6] lg:block"></div>
      </div>
      <div class="rounded-lg border-b lg:-mx-0 lg:mt-[8px] lg:border">
        @foreach ($this->users as $user)
          <div @class([
              'lg:grid hidden lg:grid-cols-[10%,40%,20%,20%,10%] grid-cols-[15%,45%,35%,5%] lg:py-[18px] lg:py-3 py-[15px] text-[15px] lg:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
              'lg:bg-[#F9FAFF] border lg:border-[#3289FA]' =>
                  $this->user->id === $user->id,
              'lg:rounded-t-lg' => $loop->first,
              'lg:rounded-b-lg' => $loop->last,
          ]) wire:click="selectUser('{{ $user->id }}')">

            <div
              class="flex h-[25px] w-[25px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800 lg:ml-[25px] lg:mr-[20px] lg:h-[45px] lg:w-[45px]">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>

            <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>

            <div class="truncate text-[15px]">
              @foreach ($this->getWorkTimeList($user) as $attendance)
                <div>
                  {{ $attendance->in_time?->isoFormat('H:mm') }} - {{ $attendance->out_time?->isoFormat('H:mm') }}
                </div>
              @endforeach
            </div>

            <div class="hidden truncate text-[15px] lg:block">
              @foreach ($this->getBreakTimeList($user) as $attendance)
                <div>
                  {{ $attendance->in_time?->isoFormat('H:mm') }} - {{ $attendance->out_time?->isoFormat('H:mm') }}
                </div>
              @endforeach
            </div>

            @if ($this->user->id === $user->id)
              <div
                class="hidden w-fit rounded bg-[#3289FA1A] bg-opacity-10 px-[12px] py-[5px] text-[12px] font-bold text-[#3289FA] lg:block">
                表示中
              </div>
            @endif

          </div>

          <!-- タイムカード管理アイコン・名前出勤時間調整 -->
          <a href="{{ route('timecardManager.show', ['id' => $user->id, 'date' => $selectDate?->format('Y-m-d')]) }}"
            @class([
                'grid lg:grid-cols-[10%,40%,20%,20%,10%] grid-cols-[12%,48%,32%,5%] lg:py-[18px] lg:py-3 py-[15px] text-[15px] lg:px-0 px-5 cursor-pointer items-center lg:hidden',
                'border-b' => !$loop->last,
                'lg:bg-[#F9FAFF] border lg:border-[#3289FA]' =>
                    $this->user->id === $user->id,
                'lg:rounded-t-lg' => $loop->first,
                'lg:rounded-b-lg' => $loop->last,
            ]) wire:click="selectUser('{{ $user->id }}')">

            <div
              class="flex h-[25px] w-[25px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800 lg:ml-[25px] lg:mr-[20px] lg:h-[45px] lg:w-[45px]">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>

            <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>

            <div class="truncate text-[12px] lg:text-[15px]">
              @foreach ($this->getWorkTimeList($user) as $attendance)
                <div>
                  {{ $attendance->in_time?->isoFormat('H:mm') }} - {{ $attendance->out_time?->isoFormat('H:mm') }}
                </div>
              @endforeach
            </div>

            <!-- アローアイコン入れる -->
            <div class="flex items-center lg:hidden">
              <svg width="28" height="28" viewBox="0 0 28 28" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M8.25 4.5L15.75 12L8.25 19.5" stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round"
                  stroke-linejoin="round" />
              </svg>

            </div>

          </a>
        @endforeach
      </div>
    </div>
    <div
      class="top-container mt-[20px] hidden h-auto min-h-full w-full rounded-[10px] lg:ml-5 lg:mt-[13px] lg:block lg:min-w-[320px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold lg:block">タイムカード詳細</h5>
      <div class="mt-[30px] flex items-center space-x-5">
        <div
          class="flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
          @if ($this->user->icon)
            <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $this->user->id]) }}">
          @else
            <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                class="fa-solid fa-image"></i>
            </div>
          @endif
        </div>
        <div class="text-xl font-bold">{{ $this->user->profile?->name }}</div>
      </div>
      <div class="mt-[30px] flex items-center justify-between bg-[#F7F7F7] px-5 py-[18px]">
        <div class="flex flex-col items-start">
          <div class="font-bold">{{ $this->month }}月度</div>
          <div class="text-[11px]">勤怠時間合計</div>
        </div>
        <div class="text-2xl font-bold">{{ $this->totalWorkTime() }}</div>
      </div>
      <div class="mt-[30px] font-bold">
        {{ $selectDate?->isoFormat('YYYY.MM.DD（ddd曜）') }}
      </div>
      <div class="mt-6">
        <div class="text-[11px] font-bold">本日の勤務時間</div>
      </div>
      <div class="mt-[9px] flex flex-col justify-center space-y-[10px]">
        @foreach ($this->getWorkTimeList($this->user) as $workTime)
          <div class="flex items-center justify-between rounded border border-[#DDDDDD] px-[10px] py-3"
            wire:key="work-time-edit-{{ $workTime->id }}">
            <div>
              {{ $workTime->in_time?->isoFormat('H:mm') }} - {{ $workTime?->out_time?->isoFormat('H:mm') }}
            </div>

            <livewire:timecard::admin.timecard-work-time-edit :workTime="$workTime" @updated="$refresh" :key="'work-time-edit' . $workTime->id . $selectDate->format('Y-m-d')" />

          </div>
        @endforeach

        <livewire:timecard::admin.timecard-work-time-create :user="$this->user" :selectDate="$selectDate->format('Y-m-d')" @updated="$refresh"
          :key="'work-time-create' . $this->user->id . $selectDate->format('Y-m-d')" />

        <hr class="mt-5 border-t border-[#DDDDDD]" />
      </div>

      <div class="mt-5">
        <div class="text-[11px] font-bold">本日の休憩時間</div>
      </div>
      <div class="mt-[9px] flex flex-col justify-center space-y-[10px]">
        @foreach ($this->getBreakTimeList($this->user) as $breakTime)
          <div class="flex items-center justify-between rounded border border-[#DDDDDD] px-[10px] py-3"
            wire:key="break-time-edit-{{ $breakTime->id }}">
            <div>
              {{ $breakTime->in_time?->isoFormat('H:mm') }} - {{ $breakTime->out_time?->isoFormat('H:mm') }}
            </div>

            <livewire:timecard::admin.timecard-break-time-edit :breakTime="$breakTime" @updated="$refresh"
              :key="'break-time-edit-' . $breakTime->id . $selectDate->format('Y-m-d')" />
          </div>
        @endforeach

        <livewire:timecard::admin.timecard-break-time-create :user="$this->user" :selectDate="$selectDate->format('Y-m-d')" @updated="$refresh"
          :key="'break-time-create-' . $this->user->id . $selectDate->format('Y-m-d')" />
      </div>
    </div>
  </div>
</x-dashboard.index>
