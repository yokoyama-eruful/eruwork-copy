<div class="flex w-full flex-row space-x-10">
  <div class="h-full w-1/2 min-w-96">
    <div>
      <div class="h-[5%] text-lg font-bold">時給一覧</div>
      <div class="h-[95%] min-w-full bg-white">
        <div class="border-t-ao-dash sticky top-0 z-10 h-[6%] w-full border-t-4 bg-ao-sub text-left">
          <div class="flex">
            <div class="w-3/6 px-4 py-2 text-left text-gray-600">名　前</div>
            <div class="w-2/6 px-4 py-2 text-left text-gray-600">時　給</div>
            <div class="w-1/6 px-4 py-2 text-left text-gray-600"></div>
          </div>
        </div>
        <div class="h-[94%] w-full overflow-y-auto">
          @foreach ($this->users as $user)
            <div class="flex w-full items-center border-b">
              <div class="w-3/6 px-4 py-2">{{ $user->name }}</div>
              <div class="w-2/6 px-4 py-2">{{ $user->latestHourlyRate ? $user->latestHourlyRate . '円' : '----' }}</div>
              <div class="flex w-1/6 justify-end px-4 py-3">
                <button class="flex items-center rounded bg-gray-200 px-5 hover:bg-green-600 hover:text-white md:py-2"
                  wire:click="selectUser('{{ $user->id }}')">
                  表示
                </button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>

  <!-- 右側の部分 -->
  <div class="w-1/2 min-w-96">
    @isset($selectedId)
      <livewire:hourlyrate::hourly-rate-show :userId="$selectedId" :key="$selectedId" />
    @endisset
  </div>
</div>
