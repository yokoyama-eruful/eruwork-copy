<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  <div class="sidebar">
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    <livewire:board::widget />
  </div>
  <x-main.index>
    <livewire:calendar::general.widget />
  </x-main.index>
</x-app-layout>
