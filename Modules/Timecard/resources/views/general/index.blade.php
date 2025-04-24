<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">タイムカード</div>
      </div>
    </div>
    @livewire('timecard::general.calendar')
  </x-widget>
</x-dashboard-layout>
