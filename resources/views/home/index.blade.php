<x-app-layout>
  {{-- top.cssの読み込み --}}
  @vite(['resources/css/top.css'])
  <div class="sidebar">
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />
    <hr class="border-line" />
    {{-- 掲示板の読み込み（Modules/Board/resources/views/livewire/widget.blade.php） --}}
    <livewire:board::widget />
  </div>

  {{-- カレンダーの読み込み --}}
  <x-main.index class="hidden sm:block">
    <livewire:calendar::general.widget />
  </x-main.index>

  {{-- 以下モバイル --}}
  {{-- <div class="overlay"></div> --}}
  <div class="sp">
    <livewire:board::widget />
    {{-- タイムカードの読み込み（Modules/Timecard/resources/views/general/livewire/stamp.blade.php） --}}
    <livewire:timecard::general.stamp />

    <livewire:calendar::general.widget />
  </div>
</x-app-layout>
