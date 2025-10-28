<x-dashboard.index>
  <x-dashboard.top>
    <h5 class="text-xl font-bold lg:hidden">時給管理</h5>
  </x-dashboard.top>
  <div class="hidden min-h-[calc(var(--vh)*100-100px)] lg:flex lg:space-x-5">
    <div
      class="top-container mt-[20px] min-h-full w-full rounded-[10px] lg:mt-[13px] lg:w-3/5 lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <div class="flex items-center justify-between">
        <h5 class="hidden text-xl font-bold lg:block">時給管理</h5>
        <livewire:hourlyrate::wage-premiums-create :key="'desktop-create-wage-' . $selectedId" />
      </div>
      <div class="mt-[30px] hidden grid-cols-[15%,58%,13%,14%] lg:grid">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">時給</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b lg:-mx-0 lg:mt-[8px] lg:border">
        @foreach ($this->users as $user)
          <div @class([
              'lg:grid lg:grid-cols-[15%,58%,13%,14%] lg:py-[18px] py-3 text-[15px] lg:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
              'bg-[#F9FAFF] border border-[#3289FA]' => $selectedUser->id === $user->id,
              'rounded-t-lg' => $loop->first,
              'rounded-b-lg' => $loop->last,
          ]) wire:click="selectUser('{{ $user->id }}')">

            <div
              class="ml-[25px] mr-[20px] flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>

            <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>

            <div class="text-[15px]">{{ $user->latestHourlyRate ? $user->latestHourlyRate . '円' : '----' }}</div>

            <div>
              @if ($selectedUser->id === $user->id)
                <div
                  class="w-fit rounded bg-[#3289FA1A] bg-opacity-10 px-[12px] py-[5px] text-xs font-bold text-[#3289FA]">
                  表示中
                </div>
              @endif
            </div>

          </div>
        @endforeach
      </div>
    </div>
    <div
      class="top-container mt-[20px] hidden min-h-full w-full rounded-[10px] lg:mt-[13px] lg:block lg:w-2/5 lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <livewire:hourlyrate::hourly-rate-show :$selectedUser :key="'desktop-show-' . $selectedId" />
    </div>
  </div>

  {{-- モバイル --}}
  <div class="relative h-[calc(var(--vh)*100-100px)] w-full lg:hidden" x-data="{ hourlyRateShow: false }">
    <!-- メインコンテンツ -->
    <div
      class="top-container mt-[20px] h-full w-full rounded-[10px] lg:mt-[13px] lg:min-w-[960px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <div class="flex items-center justify-between">
        <h5 class="hidden text-xl font-bold lg:block">時給管理</h5>

        <livewire:hourlyrate::wage-premiums-create />
      </div>

      <!-- ユーザー一覧 -->
      <div class="mt-[30px] grid grid-cols-[18%,49%,28%,5%]">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">時給</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>

      <div class="mt-2 border-b lg:-mx-0 lg:mt-[8px] lg:border">
        @foreach ($this->users as $user)
          <a href="{{ route('hourlyRate.show', $user->id) }}" @class([
              'grid grid-cols-[15%,55%,25%,5%] lg:py-[18px] py-3 text-[15px] lg:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
              'border-t' => $loop->first,
          ])
            x-on:click="hourlyRateShow = true" wire:click="selectUser('{{ $user->id }}')">

            <div
              class="flex h-[35px] w-[35px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ route('profile.icon', ['id' => $user->id]) }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white">
                  <i class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>

            <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>
            <div class="text-[15px]">{{ $user->latestHourlyRate ? $user->latestHourlyRate . '円' : '----' }}</div>

            <div>
              <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M12.2104 8.60286C12.3157 8.70833 12.3749 8.8513 12.3749 9.00036C12.3749 9.14942 12.3157 9.29239 12.2104 9.39786L6.58536 15.0229C6.47873 15.1222 6.33769 15.1763 6.19197 15.1737C6.04624 15.1712 5.9072 15.1121 5.80414 15.0091C5.70108 14.906 5.64205 14.767 5.63948 14.6213C5.63691 14.4755 5.691 14.3345 5.79036 14.2279L11.0179 9.00036L5.79036 3.77286C5.73509 3.72136 5.69077 3.65926 5.66002 3.59026C5.62928 3.52126 5.61275 3.44678 5.61142 3.37125C5.61008 3.29572 5.62398 3.2207 5.65227 3.15066C5.68056 3.08062 5.72267 3.01699 5.77608 2.96358C5.82949 2.91017 5.89312 2.86806 5.96316 2.83977C6.0332 2.81148 6.10822 2.79758 6.18375 2.79892C6.25928 2.80025 6.33376 2.81678 6.40276 2.84752C6.47176 2.87827 6.53386 2.92259 6.58536 2.97786L12.2104 8.60286Z"
                  fill="#AAB0B6" />
              </svg>
            </div>
          </a>
        @endforeach
      </div>
    </div>
  </div>

</x-dashboard.index>
