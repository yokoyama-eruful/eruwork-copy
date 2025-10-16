<x-dashboard.index>
  <x-dashboard.top>
  </x-dashboard.top>
  <div class="flex min-h-[calc(100dvh-100px)] space-x-5">
    <div
      class="top-container mt-[20px] min-h-full w-full rounded-[10px] lg:mt-[13px] lg:min-w-[960px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <div class="flex items-center justify-between">
        <h5 class="hidden text-xl font-bold lg:block">時給管理</h5>
        <livewire:hourlyrate::wage-premiums-create :key="'desktop-create-wage-' . $selectedId" />
      </div>
      <div class="mt-[30px] hidden grid-cols-[10%,70%,10%,10%] lg:grid">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">時給</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b lg:-mx-0 lg:mt-[8px] lg:border">
        @foreach ($this->users as $user)
          <div @class([
              'lg:grid lg:grid-cols-[10%,70%,10%,10%] lg:py-[18px] py-3 text-[15px] lg:px-0 px-5 cursor-pointer items-center',
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
      class="top-container mt-[20px] min-h-full w-full rounded-[10px] lg:mt-[13px] lg:min-w-[320px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <livewire:hourlyrate::hourly-rate-show :$selectedUser :key="'desktop-show-' . $selectedId" />
    </div>
  </div>
</x-dashboard.index>
