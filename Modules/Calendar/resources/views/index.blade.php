<x-app-layout>
  <x-widget>
    @vite('Modules/Calendar/resources/assets/js/app.js')
    <div id='calendar'></div>
    @include('calendar::create')
    @include('calendar::edit')
  </x-widget>
</x-app-layout>
