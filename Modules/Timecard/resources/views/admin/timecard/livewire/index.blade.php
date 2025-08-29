<x-dashboard.index>
  <x-dashboard.top>
    <div class="flex items-center space-x-[10px]">
      <div class="text-[15px] text-[#5E5E5E]">出勤日表示：</div>
      <div class="flex items-center space-x-[5px]">
        <select class="h-10 w-[115px] rounded border-[#DDDDDD]" wire:model.live="year">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="h-10 w-[100px] rounded border-[#DDDDDD]" wire:model.live="month">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
        <select class="h-10 w-[100px] rounded border-[#DDDDDD]" wire:model.live="day">
          @foreach (range(1, $this->daysInMonth) as $day)
            <option value="{{ $day }}">{{ $day }}日</option>
          @endforeach
        </select>
      </div>
      <button class="rounded bg-[#77829C] px-[11px] py-[5px] text-white" type="button">今日</button>
    </div>
  </x-dashboard.top>
  <div class="flex h-[calc(100vh-100px)] space-x-5">
    <div
      class="top-container mt-[20px] h-full w-full rounded-[10px] sm:mt-[13px] sm:min-w-[860px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold sm:block">タイムカード管理</h5>
      <div class="mt-[30px] hidden grid-cols-[10%,40%,25%,25%,10%] sm:grid">
        <div class="pl-[25px] pr-[20px] text-left text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">名前</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">勤務時間</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">休憩時間</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b sm:-mx-0 sm:mt-[8px] sm:border">
        @foreach ($this->users as $user)
          <div @class([
              'sm:grid sm:grid-cols-[10%,40%,25%,25%,10%] sm:py-[18px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
              'bg-[#F9FAFF] border border-[#3289FA]' => $this->user->id === $user->id,
              'rounded-t-lg' => $loop->first,
              'rounded-b-lg' => $loop->last,
          ]) wire:click="selectUser('{{ $user->id }}')">

            <div
              class="ml-[25px] mr-[20px] flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ $user->icon }}">
              @else
                <div class="flex h-full w-full items-center justify-center rounded-full border bg-white"><i
                    class="fa-solid fa-image"></i>
                </div>
              @endif
            </div>

            <div class="truncate text-[15px] font-bold">{{ $user->profile?->name }}</div>

          </div>
        @endforeach
        {{-- @foreach ($this->users as $user)
          <div @class([
              'sm:grid sm:grid-cols-[10%,70%,10%,10%] sm:py-[18px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer items-center',
              'border-b' => !$loop->last,
              'bg-[#F9FAFF] border border-[#3289FA]' => $selectedUser->id === $user->id,
              'rounded-t-lg' => $loop->first,
              'rounded-b-lg' => $loop->last,
          ]) wire:click="selectUser('{{ $user->id }}')">

            <div
              class="ml-[25px] mr-[20px] flex h-[45px] w-[45px] items-center justify-center overflow-hidden rounded-full bg-gray-200 text-3xl text-gray-800">
              @if ($user->icon)
                <img class="h-full w-full object-cover" src="{{ $user->icon }}">
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
        @endforeach --}}
      </div>
    </div>
    <div
      class="top-container mt-[20px] h-full w-full rounded-[10px] sm:mt-[13px] sm:min-w-[420px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold sm:block">タイムカード詳細</h5>
    </div>
  </div>
</x-dashboard.index>
