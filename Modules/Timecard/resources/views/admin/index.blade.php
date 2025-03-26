<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2 py-1">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">勤怠管理</div>
      </div>
      <livewire:timecard::admin.recoard-show />
    </div>
  </x-widget>
</x-dashboard-layout>
