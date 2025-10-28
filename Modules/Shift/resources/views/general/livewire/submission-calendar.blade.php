<x-main.index>

  <x-main.top>
    <div class="hidden w-full items-center justify-between space-x-[30px] lg:flex lg:justify-normal">
      <a class="flex items-center hover:opacity-40" href="{{ route('shift.submission.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78988 9.39751C5.68455 9.29204 5.62538 9.14907 5.62538 9.00001C5.62538 8.85094 5.68455 8.70798 5.78988 8.60251L11.4149 2.97751C11.5215 2.87815 11.6626 2.82405 11.8083 2.82663C11.954 2.8292 12.093 2.88823 12.1961 2.99129C12.2992 3.09435 12.3582 3.23339 12.3608 3.37911C12.3633 3.52484 12.3092 3.66588 12.2099 3.77251L6.98238 9.00001L12.2099 14.2275C12.2651 14.279 12.3095 14.3411 12.3402 14.4101C12.371 14.4791 12.3875 14.5536 12.3888 14.6291C12.3902 14.7046 12.3763 14.7797 12.348 14.8497C12.3197 14.9197 12.2776 14.9834 12.2242 15.0368C12.1707 15.0902 12.1071 15.1323 12.0371 15.1606C11.967 15.1889 11.892 15.2028 11.8165 15.2015C11.741 15.2001 11.6665 15.1836 11.5975 15.1528C11.5285 15.1221 11.4664 15.0778 11.4149 15.0225L5.78988 9.39751Z"
            fill="#3289FA" />
        </svg>
        <p class="hidden ps-[2px] text-sm font-bold text-[#3289FA] lg:block">シフト画面に戻る</p>
      </a>
      @if ($manager->OverSubmissionPeriod && $this->submissionStatus($manager) === '未提出')
        <livewire:shift::general.submission-multi-create :$manager />
      @endif
    </div>

    <h5 class="text-2xl font-bold lg:hidden">シフト希望表入力</h5>
  </x-main.top>
  <x-main.container>
    <div class="hidden items-center justify-between lg:flex">
      <h5 class="text-xl font-bold">シフト表提出</h5>
      <div class="flex items-center space-x-[10px]">
        <div class="text-sm">シフト提出期限：</div>
        <div class="rounded bg-[#F7F7F7] px-5 py-3 font-bold text-[#FF4A62]">
          {{ $manager->submission_end_date->isoFormat('YYYY.MM.DD（ddd）まで') }}</div>
        @if ($this->submissionStatus($manager) === '未提出')
          <button class="rounded bg-[#FF4A62] px-8 py-[10px] font-bold text-white hover:opacity-40" type="button"
            x-on:click="$dispatch('open-modal','submission-confirm-alert')">提出する</button>
          <x-modal-alert name="submission-confirm-alert">
            <div>
              <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
                <div class="pt-[13px] text-[15px] font-bold">提出しますか？</div>
              </div>
              <div class="my-5 flex items-center justify-center space-x-[10px]">
                <div
                  class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2 hover:opacity-40"
                  @click="$dispatch('close-modal', 'submission-confirm-alert')">キャンセル</div>
                <button
                  class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white hover:opacity-40"
                  type="button" wire:click="submission({{ $manager->id }})">提出する</button>
              </div>
            </div>
          </x-modal-alert>
        @else
          <button class="rounded px-8 py-[10px] font-bold text-[#FF4A62] opacity-40 outline outline-2 outline-[#FF4A62]"
            type="button" x-on:click="$dispatch('open-modal','already-submission-alert')">提出済</button>
          <x-modal-alert name="already-submission-alert">
            <div>
              <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
                <div class="pt-[13px] text-[15px] font-bold">すでに提出済みです。<br>提出の取り下げは管理者に問い合わせてください。</div>
              </div>
              <div class="my-5 flex items-center justify-center space-x-[10px]">
                <div
                  class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2 hover:opacity-40"
                  @click="$dispatch('close-modal', 'already-submission-alert')">閉じる</div>
              </div>
            </div>
          </x-modal-alert>
        @endif
      </div>
    </div>

    <div class="flex w-full items-center justify-center bg-[#F7F7F7] py-1 lg:hidden">
      <div class="text-xs text-[#6F6C6C]">提出期限：</div>
      <div class="font-bold text-[#FF4A62]">{{ $manager->submission_end_date->isoFormat('YYYY.MM.DD（ddd曜）まで') }}</div>
    </div>

    <div class="mt-[19px] flex items-center space-x-[5px] px-5 lg:space-x-2 lg:px-0">
      <div class="block text-[10px] text-[#AAB0B6] lg:hidden">募集期限：</div>
      <div @class([
          'text-[12px] text-white w-[60px] py-1 mr-[10px] text-center rounded-full lg:block hidden',
          'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
          'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
          'bg-[#39A338]' => $manager->ReceptionStatus === '準備中',
      ])>{{ $manager->ReceptionStatus }}</div>
      <div class="text-normal font-semibold lg:text-xl">
        {{ $manager->start_date->isoFormat('MM/DD（ddd）') }}　～　{{ $manager->end_date->isoFormat('MM/DD（ddd）') }}</div>
    </div>
    <hr class="mt-3 hidden border-t lg:block" />

    <div class="mt-[30px] hidden grid-cols-7 lg:grid">
      <div class="flex items-center justify-between">
        {{-- <div class="text-xl font-bold">{{ $content['date']->isoFormat('M月') }}</div> --}}
        <div class="text-xl font-bold"></div>
        <div class="text-[15px]">月</div>
        <div></div>
      </div>
      <div class="flex items-center justify-center text-[15px]">火</div>
      <div class="flex items-center justify-center text-[15px]">水</div>
      <div class="flex items-center justify-center text-[15px]">木</div>
      <div class="flex items-center justify-center text-[15px]">金</div>
      <div class="flex items-center justify-center text-[15px] text-[#48CBFF]">土</div>
      <div class="flex items-center justify-center text-[15px] text-[#FF0000]">日</div>
      {{-- <div class="text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div> --}}
    </div>
    <div class="mt-[15px] grid-cols-7 divide-x divide-y divide-[#DDDDDD] rounded-lg border lg:grid">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'lg:min-h-[170px] min-h-[90px] min-w-[140px] lg:block grid grid-cols-[20%,60%,20%] items-center',
            'bg-[#E6E6E6] hidden lg:block' => $content['type'] === '期間外',
        ]) wire:key="calendar-box-desktop-{{ $content['date']->format('Y-m-d') }}">

          <div class="flex items-center justify-between pl-[15px] pr-[10px]">
            @if ($content['date']->isoFormat('D') === '1' || $loop->first)
              <div class="flex flex-col items-start">
                <div @class(['text-[15px] lg:py-[15px]'])>{{ $content['date']->isoFormat('M.D日') }}</div>
                <div class="text-xs lg:hidden">{{ $content['date']->isoFormat('ddd') }}曜</div>
              </div>
            @else
              <div class="flex flex-col items-start">
                <div @class(['text-[15px] lg:py-[15px]'])>{{ $content['date']->isoFormat('D日') }}</div>
                <div class="text-xs lg:hidden">{{ $content['date']->isoFormat('ddd') }}曜</div>
              </div>
            @endif
            @if ($content['type'] !== '期間外')
              {{-- スケジュール作成ボタン --}}
              <div class="hidden lg:block">
                @if ($manager->OverSubmissionPeriod && $this->submissionStatus($manager) === '未提出')
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
              <livewire:shift::general.submission-create-modal @added="$refresh" :key="'create-desktop-' . $content['date']->format('Ymd')" :day="$content['date']"
                :manager="$manager" />
            @endif
          </div>
          <div class="my-3 flex flex-col space-y-1 lg:my-0 lg:mb-1 lg:pr-1 lg:text-sm">
            @foreach ($content['draftShifts'] as $key => $schedule)
              @if (!$schedule->shiftStatus)
                @if ($this->submissionStatus($manager) === '未提出')
                  <button
                    class="rounded-lg bg-[#FFF7EC] px-[10px] py-2 text-start text-[#DE993A] outline outline-1 outline-[#DE993A]"
                    wire:key="desktop-{{ $schedule->id }}"
                    x-on:click.stop="$dispatch('open-modal', 'edit-modal-{{ $schedule->id }}')">
                    <div class="text-sm font-bold">出勤希望</div>
                    <div class="text-sm">{{ $schedule->ViewSubmissionTime }}</div>
                  </button>
                @else
                  <button
                    class="rounded-lg bg-[#FFF7EC] px-[10px] py-2 text-start text-[#DE993A] outline outline-1 outline-[#DE993A]"
                    wire:key="desktop-{{ $schedule->id }}"
                    x-on:click.stop="$dispatch('open-modal', 'already-schedule-modal-{{ $schedule->id }}')">
                    <div class="text-sm font-bold">出勤希望</div>
                    <div class="text-sm">{{ $schedule->ViewSubmissionTime }}</div>
                  </button>
                @endif
              @endif

              @if ($schedule->shiftStatus)
                <button
                  class="rounded-lg bg-[#F6FFF6] px-[10px] py-2 text-start text-[#39A338] outline outline-1 outline-[#39A338]"
                  wire:key="desktop-{{ $schedule->id }}"
                  x-on:click.stop="$dispatch('open-modal', 'edit-modal-{{ $schedule->id }}')">
                  <div class="text-sm font-bold">確定シフト</div>
                  <div class="text-sm">{{ $schedule->ViewSubmissionTime }}</div>
                </button>
              @endif

              <livewire:shift::general.submission-edit-modal @edited="$refresh" :key="'edit-desktop-' . $schedule->id" :$schedule
                :$manager />

              <x-modal-alert name="already-schedule-modal-{{ $schedule->id }}">
                <div>
                  <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
                    <div class="pt-[13px] text-[15px] font-bold">すでに提出済みの為変更できません。<br>提出の取り下げは管理者に問い合わせてください。</div>
                  </div>
                  <div class="my-5 flex items-center justify-center space-x-[10px]">
                    <div
                      class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2 hover:opacity-40"
                      @click="$dispatch('close-modal', 'already-schedule-modal-{{ $schedule->id }}')">閉じる</div>
                  </div>
                </div>
              </x-modal-alert>
            @endforeach
          </div>

          <div class="flex items-center justify-center lg:hidden">
            @if ($content['type'] !== '期間外' && $manager->OverSubmissionPeriod && $this->submissionStatus($manager) === '未提出')
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
        </div>
      @endforeach
    </div>

    <div
      class="sticky bottom-0 z-10 flex h-[100px] items-center justify-center border-t bg-white px-10 py-5 lg:hidden">
      @if ($this->submissionStatus($manager) === '未提出')
        <button class="h-full w-full rounded bg-[#FF4A62] font-bold text-white hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','submission-confirm-alert')">提出する</button>
        <x-modal-alert name="submission-confirm-alert">
          <div>
            <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
              <div class="pt-[13px] text-[15px] font-bold">提出しますか？</div>
            </div>
            <div class="my-5 flex items-center justify-center space-x-[10px]">
              <div
                class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2 hover:opacity-40"
                @click="$dispatch('close-modal', 'submission-confirm-alert')">キャンセル</div>
              <button
                class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white hover:opacity-40"
                type="button" wire:click="submission({{ $manager->id }})">提出する</button>
            </div>
          </div>
        </x-modal-alert>
      @else
        <button class="h-full w-full rounded font-bold text-[#FF4A62] opacity-40 outline outline-2 outline-[#FF4A62]"
          type="button" x-on:click="$dispatch('open-modal','already-submission-alert')">提出済</button>
        <x-modal-alert name="already-submission-alert">
          <div>
            <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
              <div class="pt-[13px] text-[15px] font-bold">すでに提出済みです。<br>提出の取り下げは管理者に問い合わせてください。</div>
            </div>
            <div class="my-5 flex items-center justify-center space-x-[10px]">
              <div
                class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2 hover:opacity-40"
                @click="$dispatch('close-modal', 'already-submission-alert')">閉じる</div>
            </div>
          </div>
        </x-modal-alert>
      @endif
    </div>

  </x-main.container>
</x-main.index>
