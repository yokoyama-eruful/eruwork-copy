<div>
  @if ($count > 0)
    <x-widget>
      <div class="flex flex-wrap items-center justify-between pb-2">
        <div class="flex flex-row items-center space-x-2">
          <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
          <div class="text-lg font-bold">シフト申請</div>
        </div>
        <a class="text-ao-main hover:text-sky-700" href="{{ route('shift.index') }}">
          詳しく見る
          <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
      </div>
      <div class="flex flex-row space-x-5">
        <p>シフト希望を受け付けています</p>
        <p>{{ $count }}件</p>
      </div>
    </x-widget>
  @endif
</div>
