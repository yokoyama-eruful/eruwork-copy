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
            <button class="hover:opacity-40" type="button"
              x-on:click="$dispatch('open-modal', 'edit-work-time-modal-{{ $workTime->id }}')">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1.6875 14.0623V6.18726C1.68755 5.59059 1.92477 5.01835 2.34668 4.59644C2.76863 4.17454 3.34081 3.93726 3.9375 3.93726H7.5C7.8106 3.93726 8.0624 4.18918 8.0625 4.49976C8.0625 4.81042 7.81066 5.06226 7.5 5.06226H3.9375C3.63918 5.06226 3.35306 5.18093 3.14209 5.39185C2.93116 5.60278 2.81255 5.88895 2.8125 6.18726V14.0623C2.8125 14.3606 2.93117 14.6467 3.14209 14.8577C3.35307 15.0686 3.63913 15.1873 3.9375 15.1873H11.8125C12.1109 15.1873 12.3969 15.0686 12.6079 14.8577C12.8188 14.6467 12.9375 14.3606 12.9375 14.0623V10.4998C12.9376 10.1892 13.1894 9.93726 13.5 9.93726C13.8106 9.93726 14.0624 10.1892 14.0625 10.4998V14.0623C14.0625 14.6589 13.8252 15.2311 13.4033 15.6531C12.9814 16.075 12.4092 16.3123 11.8125 16.3123H3.9375C3.34076 16.3123 2.76864 16.075 2.34668 15.6531C1.92478 15.2311 1.6875 14.6589 1.6875 14.0623ZM15.75 3.09351C15.75 2.86975 15.6614 2.65481 15.5032 2.49658C15.3449 2.33837 15.13 2.24976 14.9062 2.24976C14.6825 2.24976 14.4676 2.33837 14.3093 2.49658L13.4414 3.3645L14.6353 4.55835L15.5032 3.69043C15.6614 3.53217 15.75 3.31729 15.75 3.09351ZM12.646 4.15991L6.3457 10.4609C6.05679 10.75 5.83412 11.0981 5.69385 11.4805L5.63892 11.6467L5.33569 12.6633L6.35303 12.3608L6.51929 12.3059C6.90167 12.1657 7.24973 11.9437 7.53882 11.6548L13.8398 5.35376L12.646 4.15991ZM16.875 3.09351C16.875 3.61566 16.6678 4.1166 16.2986 4.48584L8.33423 12.4502C7.87171 12.9124 7.30126 13.2523 6.67456 13.439L4.6604 14.0388C4.46249 14.0977 4.24832 14.0435 4.10229 13.8975C3.95632 13.7514 3.90198 13.5373 3.96094 13.3394L4.56079 11.3259C4.74741 10.6991 5.08724 10.1281 5.54956 9.66553L13.5139 1.7019C13.8832 1.33272 14.3841 1.12476 14.9062 1.12476C15.4284 1.12476 15.9293 1.33198 16.2986 1.70117C16.6678 2.07037 16.875 2.57138 16.875 3.09351Z"
                  fill="#3289FA" />
              </svg>
            </button>

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
            <button class="hover:opacity-40" type="button"
              x-on:click="$dispatch('open-modal', 'edit-break-time-modal-{{ $breakTime->id }}')">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1.6875 14.0623V6.18726C1.68755 5.59059 1.92477 5.01835 2.34668 4.59644C2.76863 4.17454 3.34081 3.93726 3.9375 3.93726H7.5C7.8106 3.93726 8.0624 4.18918 8.0625 4.49976C8.0625 4.81042 7.81066 5.06226 7.5 5.06226H3.9375C3.63918 5.06226 3.35306 5.18093 3.14209 5.39185C2.93116 5.60278 2.81255 5.88895 2.8125 6.18726V14.0623C2.8125 14.3606 2.93117 14.6467 3.14209 14.8577C3.35307 15.0686 3.63913 15.1873 3.9375 15.1873H11.8125C12.1109 15.1873 12.3969 15.0686 12.6079 14.8577C12.8188 14.6467 12.9375 14.3606 12.9375 14.0623V10.4998C12.9376 10.1892 13.1894 9.93726 13.5 9.93726C13.8106 9.93726 14.0624 10.1892 14.0625 10.4998V14.0623C14.0625 14.6589 13.8252 15.2311 13.4033 15.6531C12.9814 16.075 12.4092 16.3123 11.8125 16.3123H3.9375C3.34076 16.3123 2.76864 16.075 2.34668 15.6531C1.92478 15.2311 1.6875 14.6589 1.6875 14.0623ZM15.75 3.09351C15.75 2.86975 15.6614 2.65481 15.5032 2.49658C15.3449 2.33837 15.13 2.24976 14.9062 2.24976C14.6825 2.24976 14.4676 2.33837 14.3093 2.49658L13.4414 3.3645L14.6353 4.55835L15.5032 3.69043C15.6614 3.53217 15.75 3.31729 15.75 3.09351ZM12.646 4.15991L6.3457 10.4609C6.05679 10.75 5.83412 11.0981 5.69385 11.4805L5.63892 11.6467L5.33569 12.6633L6.35303 12.3608L6.51929 12.3059C6.90167 12.1657 7.24973 11.9437 7.53882 11.6548L13.8398 5.35376L12.646 4.15991ZM16.875 3.09351C16.875 3.61566 16.6678 4.1166 16.2986 4.48584L8.33423 12.4502C7.87171 12.9124 7.30126 13.2523 6.67456 13.439L4.6604 14.0388C4.46249 14.0977 4.24832 14.0435 4.10229 13.8975C3.95632 13.7514 3.90198 13.5373 3.96094 13.3394L4.56079 11.3259C4.74741 10.6991 5.08724 10.1281 5.54956 9.66553L13.5139 1.7019C13.8832 1.33272 14.3841 1.12476 14.9062 1.12476C15.4284 1.12476 15.9293 1.33198 16.2986 1.70117C16.6678 2.07037 16.875 2.57138 16.875 3.09351Z"
                  fill="#3289FA" />
              </svg>
            </button>

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
