<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap justify-between py-2">
      <div class="text-lg font-bold">本日のシフト</div>
      <a class="text-ao-main hover:text-sky-700" href="{{ route('shift.index') }}">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        シフトトップに戻る
      </a>
    </div>
    @livewire('shift::submission-calendar', ['managerId' => $manager->id])
  </x-widget>
</x-app-layout>
