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
              {{-- alert('選択してください'); --}}
          } else {
              @this.call('downloadExcel');
          }
      }
  }">
    <form @submit.prevent="submitForm">
      <x-dashboard.top>
        <div class="hidden items-center lg:flex">
          <button
            class="flex items-center space-x-[6px] rounded bg-[#3289FA] px-[20px] py-[5px] font-bold text-white hover:opacity-40"
            id="downloadBtn" type="submit">
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
            <div class="relative flex items-center">
              <input class="js-datepicker w-[150px] rounded border border-gray-300 py-1 pl-3 pr-8" type="text"
                wire:model.live="startDate" placeholder="開始日">
              <svg class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>

            <span>～</span>

            <!-- 終了日 -->
            <div class="relative flex items-center">
              <input class="js-datepicker w-[150px] rounded border border-gray-300 py-1 pl-3 pr-8" type="text"
                wire:model.live="endDate" placeholder="終了日">
              <svg class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
              </svg>
            </div>
          </div>

        </div>

        <div class="block w-full lg:hidden">
          <div class="flex w-full items-center justify-between">
            <h5 class="block text-xl font-bold">勤怠管理</h5>
            <button class="flex items-center space-x-1 hover:opacity-40" type="button"
              @click="$dispatch('open-modal','wage-premium-modal')">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M6.75 5.625L9 9M9 9L11.25 5.625M9 9V12.9375M11.25 9H6.75M11.25 11.25H6.75M15.75 9C15.75 9.88642 15.5754 10.7642 15.2362 11.5831C14.897 12.4021 14.3998 13.1462 13.773 13.773C13.1462 14.3998 12.4021 14.897 11.5831 15.2362C10.7642 15.5754 9.88642 15.75 9 15.75C8.11358 15.75 7.23583 15.5754 6.41689 15.2362C5.59794 14.897 4.85382 14.3998 4.22703 13.773C3.60023 13.1462 3.10303 12.4021 2.76381 11.5831C2.42459 10.7642 2.25 9.88642 2.25 9C2.25 7.20979 2.96116 5.4929 4.22703 4.22703C5.4929 2.96116 7.20979 2.25 9 2.25C10.7902 2.25 12.5071 2.96116 13.773 4.22703C15.0388 5.4929 15.75 7.20979 15.75 9Z"
                  stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <p class="text-sm font-bold text-[#3289FA]">給与算出設定</p>
            </button>
          </div>
        </div>
      </x-dashboard.top>
      <x-dashboard.container>
        <div class="block lg:hidden">
          <livewire:timecard::admin.calculate-salary :$startDate :$endDate key="{{ $startDate . $endDate }}" />
        </div>

        <div class="flex items-center justify-between">
          <h5 class="hidden text-xl font-bold lg:block">勤怠管理</h5>

          <div class="hidden items-center space-x-3 lg:flex">
            <button class="flex items-center space-x-1 hover:opacity-40" type="button"
              @click="$dispatch('open-modal','wage-premium-modal')">
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M6.75 5.625L9 9M9 9L11.25 5.625M9 9V12.9375M11.25 9H6.75M11.25 11.25H6.75M15.75 9C15.75 9.88642 15.5754 10.7642 15.2362 11.5831C14.897 12.4021 14.3998 13.1462 13.773 13.773C13.1462 14.3998 12.4021 14.897 11.5831 15.2362C10.7642 15.5754 9.88642 15.75 9 15.75C8.11358 15.75 7.23583 15.5754 6.41689 15.2362C5.59794 14.897 4.85382 14.3998 4.22703 13.773C3.60023 13.1462 3.10303 12.4021 2.76381 11.5831C2.42459 10.7642 2.25 9.88642 2.25 9C2.25 7.20979 2.96116 5.4929 4.22703 4.22703C5.4929 2.96116 7.20979 2.25 9 2.25C10.7902 2.25 12.5071 2.96116 13.773 4.22703C15.0388 5.4929 15.75 7.20979 15.75 9Z"
                  stroke="#3289FA" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
              <p class="text-sm font-bold text-[#3289FA]">給与算出設定</p>
            </button>
            <livewire:timecard::admin.calculate-salary :$startDate :$endDate
              key="desktop-{{ $startDate . $endDate }}" />
          </div>
        </div>
        <div
          class="mt-[30px] hidden grid-cols-[10%,10%,30%,25%,25%] items-end lg:grid tablet:grid-cols-[8%,6.5%,30.5%,26%,30%]">
          <button class="pl-[20px] text-left text-xs font-normal text-[#3289FA] hover:opacity-40" type="button"
            @click="selectAll = !selectAll; document.querySelectorAll('.checkbox').forEach(checkbox => checkbox.checked = selectAll); $wire.set('selectUsers', Array.from(document.querySelectorAll('.checkbox:checked')).map(checkbox => checkbox.value));">
            全選択</button>
          <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">勤務時間</div>
          <div class="text-left text-xs font-normal text-[#AAB0B6]">支給額（勤怠時間×時給）</div>
          {{-- <div class="text-left text-xs font-normal text-[#AAB0B6]">※休憩を考慮しない<br>見込（確定シフト×時給）</div> --}}
        </div>
        <div class="mt-[24px] rounded-lg lg:-mx-0 lg:mt-[8px] lg:border lg:border-b">
          @foreach ($this->users as $user)
            <div @class([
                'lg:grid grid-cols-[10%,10%,30%,25%,25%] tablet:grid-cols-[8%,6.5%,30.5%,26%,30%] lg:py-[18px] py-3 text-[15px] lg:px-0 px-5 cursor-pointer items-center hidden',
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

              <div class="text-[15px]">
                {{ $this->getTotalPay($user->id) == 0 ? '--' : $this->getTotalPay($user->id) . '円' }}
              </div>

              {{-- <div class="text-[15px]">{{ $this->prospectHourlyRate($user->id) }}</div> --}}
            </div>
          @endforeach

          <div class="block lg:hidden">
            <div class="border-b px-5 pb-[30px]">
              <div class="text-xs font-bold text-[#5E5E5E]">勤怠管理</div>
              <div class="mt-2 flex items-center justify-between">
                <div class="relative flex items-center">
                  <input class="js-datepicker w-[150px] rounded border-[#DDDDDD] px-6 py-1" type="text"
                    wire:model.live="startDate">
                  <svg class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
                <div>　～　</div>
                <div class="relative flex items-center">
                  <input class="js-datepicker w-[150px] rounded border-[#DDDDDD] px-6 py-1" type="text"
                    wire:model.live="endDate">
                  <svg class="pointer-events-none absolute right-2 top-1/2 h-4 w-4 -translate-y-1/2 text-[#3289FA]"
                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                  </svg>
                </div>
              </div>
            </div>

            @foreach ($this->users as $user)
              <div class="border-b px-5 py-[15px]">
                <div class="flex items-center space-x-[12px]">
                  <div
                    class="flex h-[40px] w-[40px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
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
                <div class="mt-5 rounded border">
                  <div class="flex items-center justify-between px-3 py-[15px]">
                    <div class="text-sm text-[#5E5E5E]">勤務時間</div>
                    <div>{{ $this->workingTime($user->id) }}</div>
                  </div>
                  <div class="flex items-center justify-between border-t px-3 py-[15px]">
                    <div class="flex flex-col items-start text-sm text-[#5E5E5E]">
                      <div>支給額</div>
                      <div class="text-[11px]">勤怠時間×時給(割増時間含む)</div>
                    </div>
                    <div>{{ $this->getTotalPay($user->id) }}円</div>
                  </div>
                </div>

                {{-- <div class="flex items-center space-x-2">
                    <div class="text-[10px] text-[#AAB0B6]">見込(確定シフト×時給):</div>
                    <div class="text-xs">{{ $this->prospectHourlyRate($user->id) }}</div>
                  </div> --}}
              </div>
            @endforeach
          </div>

          {{ $this->users->links('vendor.pagination.tailwind') }}
      </x-dashboard.container>
    </form>
  </div>
</x-dashboard.index>
