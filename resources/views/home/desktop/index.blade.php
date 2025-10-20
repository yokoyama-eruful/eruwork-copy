<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  <div class="sidebar hidden lg:block">
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    <livewire:board::widget />
  </div>
  <x-main.index class="hidden lg:block">
    <livewire:calendar::general.widget />
  </x-main.index>

  <div class="sp">
    <livewire:board::widget />
    <livewire:timecard::general.stamp />
    <livewire:calendar::general.widget />
  </div>
</x-app-layout>
