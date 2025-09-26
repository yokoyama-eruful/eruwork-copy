<x-app-layout>
  @vite(['resources/css/top.css'])
  <div class="sp">
    <livewire:board::widget />
    <livewire:timecard::general.stamp />
    <livewire:calendar::general.widget />
  </div>
</x-app-layout>
