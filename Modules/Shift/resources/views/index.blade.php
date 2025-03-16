<x-app-layout>
  <x-widget>
    <div class="flex flex-wrap justify-between py-2">
      <div class="text-lg font-bold">本日のシフト</div>
      <a class="text-ao-main hover:text-sky-700" href="#">
        詳しく見る
        <i class="fa-solid fa-arrow-up-right-from-square"></i></a>
    </div>
  </x-widget>

  <x-widget>
    <div class="flex py-2">
      <div class="text-lg font-bold">シフト提出</div>
    </div>
    <div class="w-full">
      @foreach ($managers as $manager)
        <a class="flex flex-wrap items-center justify-between rounded-md border px-4 py-2 hover:bg-sky-50"
          href="{{ route('submission.show', ['submission' => $manager->id]) }}">
          <div class="flex flex-col">
            <div class="flex flex-row">
              シフト表期間:
              {{ $manager->start_date->isoFormat('Y年M月D日(ddd)') }}
              ~
              {{ $manager->end_date->isoFormat('Y年M月D日(ddd)') }}
            </div>
            <div class="flex flex-row">
              提出可能期間:
              {{ $manager->submission_start_date->isoFormat('Y年M月D日(ddd)') }}
              ~
              {{ $manager->submission_end_date->isoFormat('Y年M月D日(ddd)') }}
            </div>
          </div>
          <div class="rounded-md bg-ao-main p-2 font-semibold text-white">受付中</div>
        </a>
      @endforeach
    </div>
  </x-widget>
</x-app-layout>
