<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap justify-between pb-2">
      <div class="text-lg font-bold">シフト提出</div>
      <a class="text-ao-main hover:text-sky-700" href="{{ route('shift.index') }}">
        <i class="fa-solid fa-arrow-up-right-from-square"></i>
        シフトトップに戻る
      </a>
    </div>
    <div class="flex flex-wrap justify-between">
      <div class="flex flex-row">
        提出受付:
        <div class="font-medium">{{ $manager->submission_end_date->isoFormat('Y年M月D日(ddd)') }}</div>
        まで
      </div>
    </div>
    @livewire('shift::submission-calendar', ['manager' => $manager])
  </x-widget>
</x-app-layout>
