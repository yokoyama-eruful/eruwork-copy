<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">シフト管理</div>
      </div>
      <a class="flex flex-row items-center space-x-3 hover:text-ao-main" href="{{ route('shiftManager.index') }}">
        <i class="fa-solid fa-chevron-left"></i>
        <div>シフト一覧に戻る</div>
      </a>
    </div>
    <livewire:shift::admin.calendar :$manager />
  </x-widget>
</x-dashboard-layout>
