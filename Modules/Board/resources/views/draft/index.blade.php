<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2">
        <div class="h-auto self-stretch border-l-4 border-ao-main"></div>
        <div class="text-lg font-bold">掲示板下書き一覧</div>
      </div>
    </div>
    @livewire('board::draft-show')
  </x-widget>
</x-app-layout>
