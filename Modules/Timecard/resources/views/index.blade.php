<x-app-layout>
  <x-widget>
    @vite('Modules/Timecard/resources/assets/js/app.js')
    <div class="flex space-x-3 py-2">
      <div class="text-lg font-bold">タイムカード</div>
    </div>
    <div id='calendar'></div>
    @include('timecard::create')
    @include('timecard::edit')
  </x-widget>
</x-app-layout>
