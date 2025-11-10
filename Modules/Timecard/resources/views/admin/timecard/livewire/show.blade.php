<x-dashboard.index>
  <x-dashboard.top>
    <div class="text-xl font-bold">タイムカード詳細</div>
  </x-dashboard.top>
  <x-dashboard.container>
    <div class="top-container mt-[20px] h-full w-full rounded-[10px] px-5">
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
        {{ $this->date?->isoFormat('YYYY.MM.DD（ddd曜）') }}
      </div>
      <div class="mt-6">
        <div class="text-[11px] font-bold">本日の勤務時間</div>
      </div>
      <div class="mt-[9px] flex flex-col justify-center space-y-[10px]">
        @foreach ($this->getWorkTimeList($this->user) as $workTime)
          <div class="flex items-center justify-between rounded border border-[#DDDDDD] px-[10px] py-3"
            wire:key="work-time-edit-{{ $workTime->id }}">
            <div>
              {{ $workTime->in_time?->isoFormat('H:mm') }} - {{ $workTime->out_time?->isoFormat('H:mm') }}
            </div>

            <livewire:timecard::admin.timecard-work-time-edit :workTime="$workTime" @updated="$refresh"
              key="work-time-edit-{{ $workTime->id }}" />

          </div>
        @endforeach

        <livewire:timecard::admin.timecard-work-time-create :user="$this->user" :selectDate="$this->date->format('Y-m-d')" @updated="$refresh"
          :key="'work-time-create-' . $this->user->id" />

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
              key="break-time-edit-{{ $breakTime->id }}" />
          </div>
        @endforeach

        <livewire:timecard::admin.timecard-break-time-create :user="$this->user" :selectDate="$this->date->format('Y-m-d')" @updated="$refresh"
          :key="'break-time-create-' . $this->user->id" />
      </div>
    </div>
  </x-dashboard.container>
</x-dashboard.index>
