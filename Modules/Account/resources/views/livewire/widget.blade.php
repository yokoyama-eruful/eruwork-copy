<x-widget>
  <div class="flex flex-wrap items-center justify-between pb-2">
    <div class="flex flex-row items-center space-x-2 py-2">
      <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
      <div class="text-lg font-bold">カレンダー</div>
    </div>
  </div>
  <div class="flex w-full justify-between space-x-5">
    <div class="w-1/2">
      <div>発行済みアカウント</div>
      <div class="flex h-20 items-center justify-center bg-ao-sub text-5xl">{{ $accountCountList['発行済みアカウント数'] }}
      </div>
    </div>
    <div class="w-1/2">
      <div>利用中アカウント</div>
      <div class="flex h-20 items-center justify-center bg-ao-sub text-5xl">{{ $accountCountList['利用中アカウント数'] }}
      </div>
    </div>
  </div>
</x-widget>
