<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap justify-between pb-2">
      <div class="text-lg font-bold">シフト表</div>
      <a class="text-ao-main hover:text-sky-700" href="{{ route('shift.index') }}">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        シフトトップに戻る
      </a>
    </div>

    <div class="block xl:hidden">
      <livewire:shift::week-schedule />
    </div>

    <div class="hidden xl:block" x-data="{ schedule: 'week' }">
      <div x-show="schedule === 'week'">
        <livewire:shift::week-schedule />
      </div>
      <div x-show="schedule === 'day'">
        <livewire:shift::day-schedule />
      </div>
    </div>
  </x-widget>
</x-app-layout>
