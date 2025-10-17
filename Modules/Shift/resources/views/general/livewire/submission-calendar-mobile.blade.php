<x-main.index>

  <x-main.top>
    <div class="flex w-full items-center justify-between space-x-[30px] lg:justify-normal">
      <h5 class="block text-xl font-bold lg:hidden">シフト希望表提出</h5>
      @if ($manager->OverSubmissionPeriod)
        <livewire:shift::general.submission-multi-create :$manager />
      @endif
    </div>
  </x-main.top>
  <x-main.container>
    <div class="mx-5 flex items-center space-x-1 rounded bg-[#F7F7F7] px-5 py-[14px] lg:hidden">
      <div class="text-[10px] text-[#AAB0B6]">シフト提出期限：</div>
      <div class="font-bold text-[#FF4A62]">{{ $manager->submission_end_date->isoFormat('YYYY年MM/DD（ddd）') }}まで</div>
    </div>

    <div class="mt-[19px] flex items-center space-x-[5px] px-5 lg:space-x-2 lg:px-0">
      <div class="block text-[10px] text-[#AAB0B6] lg:hidden">募集期限：</div>
      <div class="text-normal font-semibold lg:text-xl">
        {{ $manager->start_date->isoFormat('MM/DD（ddd）') }}　～　{{ $manager->end_date->isoFormat('MM/DD（ddd）') }}</div>
    </div>

    {{-- モバイル版 --}}
    <div class="my-[14px] block lg:hidden">
      <div class="mx-5 rounded-lg border">
        @foreach ($this->calendar as $key => $content)
          @if ($content['type'] !== '期間外')
            <div @class([
                'grid grid-cols-[15%,70%,15%] min-h-[60px]  border-b py-[10px]',
                'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
            ]) wire:key="calendar-box-mobile-{{ $content['date']->format('Y-m-d') }}">
              <div @class([
                  'text-xs flex flex-col items-center justify-center',
                  'font-bold text-[#3289FA]' =>
                      $content['date']->format('Ymd') === now()->format('Ymd'),
                  'text-[#48CBFF]' =>
                      $content['date']->format('Ymd') !== now()->format('Ymd') &&
                      $content['date']->isoFormat('ddd') === '土',
                  'text-[#FF0000]' =>
                      $content['date']->format('Ymd') !== now()->format('Ymd') &&
                      $content['date']->isoFormat('ddd') === '日',
              ])>
                <div>{{ $content['date']->isoFormat('D日') }}</div>

                <div>{{ $content['date']->isoFormat('（ddd）') }}</div>
              </div>

              <div class="flex flex-col space-y-1">
                @foreach ($content['draftShifts'] as $key => $schedule)
                  @if (!$schedule->shiftStatus)
                    <button
                      class="flex items-center space-x-[10px] rounded-lg bg-[#FFF7EC] px-[10px] py-2 text-start text-[#DE993A] outline outline-1 outline-[#DE993A]"
                      wire:key="mobile-{{ $schedule->id }}"
                      x-on:click.stop="$dispatch('open-modal', 'edit-modal-{{ $schedule->id }}')">
                      <div class="text-sm font-bold">出勤希望</div>
                      <div class="text-sm">{{ $schedule->ViewSubmissionTime }}</div>
                    </button>
                  @endif

                  @if ($schedule->shiftStatus)
                    <button
                      class="flex items-center space-x-[10px] rounded-lg bg-[#F6FFF6] px-[10px] py-2 text-start text-[#39A338] outline outline-1 outline-[#39A338]"
                      wire:key="mobile-{{ $schedule->id }}"
                      x-on:click.stop="$dispatch('open-modal', 'edit-modal-{{ $schedule->id }}')">
                      <div class="text-sm font-bold">確定シフト</div>
                      <div class="text-sm">{{ $schedule->ViewSubmissionTime }}</div>
                    </button>
                  @endif
                  <livewire:shift::general.submission-edit-modal @edited="$refresh" :key="'edit-mobile-' . $schedule->id" :$schedule
                    :$manager />
                @endforeach
              </div>

              <div class="flex items-center justify-center">
                @if ($manager->OverSubmissionPeriod)
                  <button class="hover:opacity-40" type="button"
                    x-on:click="$dispatch('open-modal', 'create-modal-{{ $content['date']->format('Y-m-d') }}')">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M9 6.5V11.5M11.5 9H6.5M16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
                        stroke="#3289FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                  </button>
                @endif
              </div>
              <livewire:shift::general.submission-create-modal @added="$refresh" :key="'create-mobile-' . $content['date']->format('Ymd')" :day="$content['date']"
                :manager="$manager" />
            </div>
          @endif
        @endforeach
      </div>
    </div>

  </x-main.container>
</x-main.index>
