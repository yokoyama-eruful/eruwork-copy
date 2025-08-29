<x-app-layout>

  <x-main.index>

    <x-main.top>

      <div class="flex flex-wrap justify-between pb-2">
        <div class="text-lg font-bold">シフト表</div>
        <a class="text-ao-main hover:text-sky-700" href="{{ route('shift.schedule') }}">
          <i class="fa-solid fa-arrow-up-right-from-square"></i>
          シフトトップに戻る
        </a>
      </div>

      {{-- <div class="flex items-center md:ml-0">
      <button class="flex items-center space-x-1 rounded-l text-[15px] xl:px-4"
        wire:click="clickDate('{{ $selectedDate->subMonth()->format('Y-m-d') }}')">
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-l.png') }}" alt="前月">
        <p class="hidden sm:block">前月</p>
      </button>
      <div class="flex flex-row space-x-[5px]">
        <select class="rounded border border-[#DDDDDD]" wire:model.live="year" wire:change="updateCalendar">
          @foreach (range(2000, 2050) as $year)
            <option value="{{ $year }}">{{ $year }}年</option>
          @endforeach
        </select>
        <select class="rounded border border-[#DDDDDD]" wire:model.live="month" wire:change="updateCalendar">
          @foreach (range(1, 12) as $month)
            <option value="{{ $month }}">{{ $month }}月</option>
          @endforeach
        </select>
      </div>
      <button class="flex items-center space-x-1 rounded-r text-[15px] xl:px-4"
        wire:click="clickDate('{{ $selectedDate->addMonth()->format('Y-m-d') }}')">
        <p class="hidden sm:block">翌月</p>
        <img class="h-[18px] w-[18px]" src="{{ global_asset('img/icon/arrow-r.png') }}" alt="翌月">
      </button>
      <div class="">
        <button class="mx-2 h-[35px] rounded border bg-[#77829C] px-2 text-[14px] text-white"
          wire:click="clickDate('{{ now()->format('Y-m-d') }}')">今月</button>
      </div>
    </div> --}}
    </x-main.top>
    <x-main.container>
      <div class="block xl:hidden">
        <livewire:shift::general.week-schedule />
      </div>

      <div class="hidden xl:block" x-data="{ schedule: 'week' }">
        <div x-show="schedule === 'week'">
          <livewire:shift::general.week-schedule />
        </div>
        <div x-show="schedule === 'day'">
          <livewire:shift::general.day-schedule />
        </div>
      </div>
    </x-main.container>
  </x-main.index>

</x-app-layout>
