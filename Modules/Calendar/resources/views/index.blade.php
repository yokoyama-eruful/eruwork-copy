<x-app-layout>
  <x-widget>
    @vite('Modules/Calendar/resources/assets/js/app.js')
    <div class="flex space-x-3 pb-2">
      <div class="text-lg font-bold">カレンダー</div>
    </div>
    <div id='calendar'></div>
    @include('calendar::create')
    @include('calendar::edit')
  </x-widget>
</x-app-layout>
