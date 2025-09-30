<x-dashboard.index>
  <div x-data="{
      selectAll: false,
      selectUsers: @entangle('selectUsers'),
      toggleAll() {
          this.selectUsers = this.selectAll ? @entangle('selectUsers') : [];
          @this.set('selectUsers', this.selectUsers);
      },
      submitForm() {
          if (this.selectUsers.length === 0) {
              alert('選択してください');
          } else {
              @this.call('downloadExcel');
          }
      }
  }">
    <form class="flex items-center" @submit.prevent="submitForm">
      <x-dashboard.top>
        <div class="hidden items-center sm:flex">
          <button
            class="flex items-center space-x-[6px] rounded bg-[#3289FA] px-[20px] py-[5px] font-bold text-white hover:opacity-40"
            type="submit">
            <svg width="16" height="16" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M0.5 11.5V10C0.5 9.72386 0.723858 9.5 1 9.5C1.27614 9.5 1.5 9.72386 1.5 10V11.5C1.5 11.7652 1.60543 12.0195 1.79297 12.207C1.98051 12.3946 2.23478 12.5 2.5 12.5H11.5L11.599 12.4948C11.8278 12.472 12.043 12.3711 12.207 12.207C12.3946 12.0195 12.5 11.7652 12.5 11.5V10C12.5 9.72386 12.7239 9.5 13 9.5C13.2761 9.5 13.5 9.72386 13.5 10V11.5C13.5 12.0304 13.2891 12.539 12.9141 12.9141C12.539 13.2891 12.0304 13.5 11.5 13.5H2.5C1.96957 13.5 1.46101 13.2891 1.08594 12.9141C0.710865 12.539 0.5 12.0304 0.5 11.5ZM6.5 1C6.5 0.723858 6.72386 0.5 7 0.5C7.27614 0.5 7.5 0.723858 7.5 1V8.79297L9.64648 6.64648C9.84175 6.45122 10.1583 6.45122 10.3535 6.64648C10.5488 6.84175 10.5488 7.15825 10.3535 7.35352L7.35352 10.3535C7.15825 10.5488 6.84175 10.5488 6.64648 10.3535L3.64648 7.35352C3.45122 7.15825 3.45122 6.84175 3.64648 6.64648C3.84175 6.45122 4.15825 6.45122 4.35352 6.64648L6.5 8.79297V1Z"
                fill="white" />
            </svg>
            <div class="text-[14px]">ダウンロード</div>
          </button>

          <div class="ml-[30px] text-[15px] text-[#5E5E5E]">勤怠管理：</div>

          <div class="flex items-center gap-2">
            <!-- 開始日 -->
            <div class="relative">
              <input class="js-datepicker w-[150px] rounded border border-gray-300 py-1 pl-3 pr-8" type="text"
                wire:model="startDate">
              <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>

            <div>～</div>

            <!-- 終了日 -->
            <div class="relative">
              <input class="js-datepicker w-[150px] rounded border border-gray-300 py-1 pl-3 pr-8" type="text"
                wire:model="endDate">
              <svg class="pointer-events-none absolute right-3 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0
        002-2V7a2 2 0 00-2-2H5a2 2 0
        00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>

        </div>

        <h5 class="block text-xl font-bold sm:hidden">勤怠管理</h5>
      </x-dashboard.top>
      <x-dashboard.container>
        <h5 class="hidden text-xl font-bold sm:block">勤怠管理</h5>
        <div class="mt-[30px] hidden grid-cols-[5%,4.5%,35.5%,18%,20%,18%] items-end sm:grid">
          <button class="pl-[20px] text-left text-xs font-normal text-[#3289FA] hover:opacity-40" type="button"
            @click="selectAll = !selectAll; document.querySelectorAll('.checkbox').forEach(checkbox => checkbox.checked = selectAll); $wire.set('selectUsers', Array.from(document.querySelectorAll('.checkbox:checked')).map(checkbox => checkbox.value));">
            全選択</button>
          <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">勤務時間</div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">支給額（勤怠時間×時給）</div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">※休憩を考慮しない<br>見込（確定シフト×時給）</div>
        </div>
        <div class="mt-[24px] rounded-lg sm:-mx-0 sm:mt-[8px] sm:border sm:border-b">
          @foreach ($this->users as $user)
            <div @class([
                'sm:grid sm:grid-cols-[5%,4.5%,35.5%,18%,20%,18%] sm:py-[18px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer items-center hidden',
                'border-b' => !$loop->last,
            ])>

              <input class="checkbox ml-[30px] h-[18px] w-[18px] rounded border-[#DDDDDD]" type="checkbox"
                value="{{ $user->id }}" wire:model="selectUsers">

              <div
                class="flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
                @if ($user->icon)
                  <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
                @else
                  <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                      class="fa-solid fa-image"></i>
                  </div>
                @endif
              </div>

              <div class="text-[15px] font-bold">{{ $user->profile?->name }}</div>

              <div class="text-[15px]">{{ $this->workingTime($user->id) }}</div>

              <div class="text-[15px]">{{ $this->getTotalPay($user->id) }}</div>

              <div class="text-[15px]">{{ $this->prospectHourlyRate($user->id) }}</div>
            </div>
          @endforeach

          <div class="block sm:hidden">
            <div class="border-b px-5 pb-[30px]">
              <div class="text-xs font-bold text-[#5E5E5E]">勤怠管理</div>
              <div class="mt-2 flex items-center justify-between">
                <input class="js-datepicker w-[150px] rounded border-[#DDDDDD] px-6 py-1" type="text"
                  wire:model.live="startDate">
                <div>　～　</div>
                <input class="js-datepicker w-[150px] rounded border-[#DDDDDD] px-6 py-1" type="text"
                  wire:model.live="endDate">
              </div>
            </div>

            @foreach ($this->users as $user)
              <div class="flex items-center justify-between border-b px-5 py-[15px]">
                <div class="flex items-center space-x-[10px]">
                  <div
                    class="flex h-[25px] w-[25px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
                    @if ($user->icon)
                      <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
                    @else
                      <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                          class="fa-solid fa-image"></i>
                      </div>
                    @endif
                  </div>
                  <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>
                </div>
                <div class="flex flex-col items-end space-y-3">
                  <div class="flex items-center space-x-2">
                    <div class="text-[10px] text-[#AAB0B6]">勤務時間:</div>
                    <div class="text-xs">{{ $this->workingTime($user->id) }}</div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <div class="text-[10px] text-[#AAB0B6]">支給額(勤怠時間×時給):</div>
                    <div class="text-xs">{{ $this->getTotalPay($user->id) }}</div>
                  </div>
                  <div class="flex items-center space-x-2">
                    <div class="text-[10px] text-[#AAB0B6]">見込(確定シフト×時給):</div>
                    <div class="text-xs">{{ $this->prospectHourlyRate($user->id) }}</div>
                  </div>
                </div>
              </div>
            @endforeach
          </div>

          {{ $this->users->links('vendor.pagination.tailwind') }}
      </x-dashboard.container>
    </form>
  </div>
</x-dashboard.index>
