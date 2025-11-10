<x-dashboard.index>
  <x-dashboard.top>
    <div class="hidden items-center space-x-[30px] lg:flex">
      <a class="flex items-center space-x-[2px] hover:opacity-40" href="{{ route('shiftManager.index') }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <div class="text-sm font-bold text-[#3289FA]">一覧画面に戻る</div>
      </a>
      <div class="h-[35px] border-l lg:hidden"></div>
    </div>

    <div class="flex items-center justify-between lg:hidden">
      <h5 class="block text-xl font-bold lg:hidden">シフト表管理</h5>
    </div>
  </x-dashboard.top>
  <x-dashboard.container>
    <div class="flex items-center justify-between">
      <div class="flex w-full items-center justify-between">
        <h5 class="hidden text-xl font-bold lg:block">シフト管理</h5>
        <div class="hidden px-5 lg:block">
          <button
            class="flex h-[45px] w-[250px] items-center justify-between rounded-lg bg-[#F7F7F7] px-3 hover:opacity-40"
            type="button" x-on:click="$dispatch('open-modal','submission-list-modal')">
            <div class="text-xs">シフト提出人数</div>
            <div class="flex items-center space-x-3">
              <div class="flex items-center">
                <p class="text-[18px] font-bold">
                  {{ $manager->alreadySubmissionUsers->count() }}
                </p>
                <p class="text-sm">/{{ $users->count() }}名</p>
              </div>
              <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M20.25 12C20.25 9.81196 19.3812 7.71319 17.834 6.16602C16.2868 4.61884 14.188 3.75 12 3.75C9.81196 3.75 7.71319 4.61884 6.16602 6.16602C4.61884 7.71319 3.75 9.81196 3.75 12C3.75 13.0834 3.96333 14.1563 4.37793 15.1572C4.79253 16.1581 5.39995 17.0679 6.16602 17.834C6.93209 18.6001 7.84186 19.2075 8.84277 19.6221C9.84371 20.0367 10.9166 20.25 12 20.25C13.0834 20.25 14.1563 20.0367 15.1572 19.6221C16.1581 19.2075 17.0679 18.6001 17.834 17.834C18.6001 17.0679 19.2075 16.1581 19.6221 15.1572C20.0367 14.1563 20.25 13.0834 20.25 12ZM11.7852 10.4092C12.0702 10.4396 12.3408 10.5512 12.5645 10.7305C12.788 10.9097 12.9551 11.1494 13.0469 11.4209C13.1385 11.6924 13.1511 11.9846 13.082 12.2627V12.2637L12.374 15.0996L12.373 15.1006L12.4082 15.082C12.7768 14.8934 13.2292 15.0396 13.418 15.4082C13.6066 15.7768 13.4604 16.2292 13.0918 16.418L13.0449 16.4414C12.7884 16.5697 12.5 16.6221 12.2148 16.5918C11.9296 16.5614 11.6583 16.45 11.4346 16.2705C11.2108 16.0909 11.0437 15.8501 10.9521 15.5781C10.8608 15.3065 10.8485 15.0144 10.918 14.7363L11.626 11.9014L11.6201 11.9043L11.5791 11.9238C11.2069 12.1054 10.7579 11.9511 10.5762 11.5791C10.3946 11.2069 10.5489 10.7579 10.9209 10.5762L10.9619 10.5557C11.2168 10.4298 11.5024 10.379 11.7852 10.4092ZM12.0078 7.5C12.422 7.5 12.7578 7.83579 12.7578 8.25V8.25781C12.7578 8.67203 12.422 9.00781 12.0078 9.00781H12C11.5858 9.00781 11.25 8.67203 11.25 8.25781V8.25C11.25 7.83579 11.5858 7.5 12 7.5H12.0078ZM21.75 12C21.75 13.2804 21.4978 14.5485 21.0078 15.7314C20.5178 16.9143 19.7998 17.9892 18.8945 18.8945C17.9892 19.7998 16.9143 20.5178 15.7314 21.0078C14.5485 21.4978 13.2804 21.75 12 21.75C10.7196 21.75 9.45148 21.4978 8.26855 21.0078C7.08573 20.5178 6.01078 19.7998 5.10547 18.8945C4.20016 17.9892 3.48217 16.9143 2.99219 15.7314C2.5022 14.5485 2.25 13.2804 2.25 12C2.25 9.41414 3.27699 6.93395 5.10547 5.10547C6.93395 3.27699 9.41414 2.25 12 2.25C14.5859 2.25 17.0661 3.27699 18.8945 5.10547C20.723 6.93395 21.75 9.41414 21.75 12Z"
                  fill="#3289FA" />
              </svg>
            </div>
          </button>
        </div>
      </div>
      <x-modal name="submission-list-modal" title="シフト提出">
        <div class="flex h-auto max-h-96 flex-col space-y-[10px] overflow-y-auto bg-[#F7F7F7]">
          <div class="flex items-center justify-between space-x-5">
            <div class="flex h-10 w-full items-center justify-between bg-white px-3">
              <div class="font-bold text-[#39A338]">提出済み</div>
              <div class="flex items-end">
                <p class="m-0 font-bold leading-none">{{ $manager->alreadySubmissionUsers->count() }}</p>
                <p class="m-0 text-xs leading-none">人</p>
              </div>
            </div>
            <div class="flex h-10 w-full items-center justify-between bg-white px-3">
              <div class="font-bold text-[#FF4A62]">未提出</div>
              <div class="flex items-end">
                <p class="m-0 font-bold leading-none">{{ $manager->stillSubmissionUsers->count() }}</p>
                <p class="m-0 text-xs leading-none">人</p>
              </div>
            </div>
          </div>
          <div class="mt-5 flex items-center space-x-5">
            <div @class([
                'px-[10px] py-1 text-xs font-bold cursor-pointer',
                'text-[#3289FA] bg-[#3289FA1A] bg-opacity-10 rounded' =>
                    $status === '提出済',
                ' text-[#222222] text-opacity-30 hover:opacity-40' => $status === '未提出',
            ]) wire:click="changeList('提出済')">提出済み</div>
            <div @class([
                'px-[10px] py-1 text-xs font-bold cursor-pointer',
                'text-[#3289FA] bg-[#3289FA1A] bg-opacity-10 rounded' =>
                    $status === '未提出',
                ' text-[#222222] text-opacity-30 hover:opacity-40' => $status === '提出済',
            ]) wire:click="changeList('未提出')">未提出</div>
          </div>

          @if ($status === '提出済')
            @foreach ($manager->alreadySubmissionUsers as $user)
              <div class='grid grid-cols-[15%,55%,30%] items-center rounded bg-white px-5 py-3'>
                @if ($user->icon)
                  <img class="h-[25px] w-[25px] rounded-full border bg-white"
                    src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
                @else
                  <div class="flex h-[25px] w-[25px] items-center justify-center rounded-full border bg-white">
                    <i class="fa-solid fa-image"></i>
                  </div>
                @endif
                <div class="truncate text-[15px] font-bold">{{ $user->name }}</div>
                <button
                  class="flex w-full items-center justify-center rounded py-1 text-center text-xs font-bold text-[#FF4A62] outline outline-1 outline-[#FF4A62] hover:opacity-40"
                  type="button" wire:click="returnSubmission({{ $user->id }},{{ $manager->id }})">
                  提出取消</button>
              </div>
            @endforeach
          @elseif($status === '未提出')
            @foreach ($manager->stillSubmissionUsers as $user)
              <div class='grid grid-cols-[15%,55%,30%] items-center rounded bg-white px-5 py-3'>
                @if ($user->icon)
                  <img class="h-[25px] w-[25px] rounded-full border bg-white"
                    src="{{ route('profile.icon', ['id' => $user->id]) }}" alt="アイコン">
                @else
                  <div class="flex h-[25px] w-[25px] items-center justify-center rounded-full border bg-white">
                    <i class="fa-solid fa-image"></i>
                  </div>
                @endif
                <div class="truncate text-[15px] font-bold">{{ $user->name }}</div>
                <button
                  class="flex w-full items-center justify-center rounded py-1 text-center text-xs font-bold text-[#3289FA] outline outline-1 outline-[#3289FA] hover:opacity-40"
                  type="button" wire:click="remindSubmission({{ $user->id }},{{ $manager->id }})">
                  提出依頼</button>
              </div>
            @endforeach
          @endif
        </div>

        <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
          <button class="flex h-11 w-[150px] items-center justify-center rounded bg-[#3289FA] font-bold text-white"
            x-on:click="$dispatch('close-modal', 'submission-list-modal')">
            閉じる
          </button>
        </div>
      </x-modal>
    </div>
    <div class="mb-[15px] flex items-center justify-between px-5 lg:hidden">
      <div @class([
          'text-xs font-bold text-white w-[50px] h-[20px] flex items-center justify-center rounded-full',
          'bg-[#48CBFF]' => $manager->receptionStatus === '受付中',
          'bg-[#F76E80]' => $manager->receptionStatus === '終了',
          'bg-green-400' => $manager->receptionStatus === '準備中',
      ])>{{ $manager->receptionStatus }}</div>
      <div class="flex items-center space-x-2">
        <div class="text-xs text-[#AAB0B6]">受付終了日:</div>
        <div class="text-xs text-[#AAB0B6]">{{ $manager->submission_end_date->isoFormat('Y.M.D（ddd）') }}</div>
      </div>
    </div>
    <div class="flex items-center space-x-2 px-5 lg:mt-[20px] lg:border-b lg:px-0 lg:pb-[10px]">
      <div class="hidden text-xs text-[#AAB0B6] lg:block">期間:</div>
      <div class="text-[20px] font-semibold lg:text-[20px]">
        {{ $manager->start_date->isoFormat('Y.M.D（ddd）') }}　～　{{ $manager->end_date->isoFormat('Y.M.D（ddd）') }}
      </div>
    </div>

    <div class="mb-[30px] mt-[20px] w-full px-5 lg:hidden">
      <button class="flex h-[45px] w-full items-center justify-between rounded-lg bg-[#F7F7F7] px-3 hover:opacity-40"
        type="button" x-on:click="$dispatch('open-modal','submission-list-modal')">
        <div class="text-xs">シフト提出人数</div>
        <div class="flex items-center space-x-3">
          <div class="flex items-center">
            <p class="text-[18px] font-bold">
              {{ $manager->alreadySubmissionUsers->count() }}
            <p>
            <p class="text-sm">/{{ $users->count() }}名</p>
          </div>
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M20.25 12C20.25 9.81196 19.3812 7.71319 17.834 6.16602C16.2868 4.61884 14.188 3.75 12 3.75C9.81196 3.75 7.71319 4.61884 6.16602 6.16602C4.61884 7.71319 3.75 9.81196 3.75 12C3.75 13.0834 3.96333 14.1563 4.37793 15.1572C4.79253 16.1581 5.39995 17.0679 6.16602 17.834C6.93209 18.6001 7.84186 19.2075 8.84277 19.6221C9.84371 20.0367 10.9166 20.25 12 20.25C13.0834 20.25 14.1563 20.0367 15.1572 19.6221C16.1581 19.2075 17.0679 18.6001 17.834 17.834C18.6001 17.0679 19.2075 16.1581 19.6221 15.1572C20.0367 14.1563 20.25 13.0834 20.25 12ZM11.7852 10.4092C12.0702 10.4396 12.3408 10.5512 12.5645 10.7305C12.788 10.9097 12.9551 11.1494 13.0469 11.4209C13.1385 11.6924 13.1511 11.9846 13.082 12.2627V12.2637L12.374 15.0996L12.373 15.1006L12.4082 15.082C12.7768 14.8934 13.2292 15.0396 13.418 15.4082C13.6066 15.7768 13.4604 16.2292 13.0918 16.418L13.0449 16.4414C12.7884 16.5697 12.5 16.6221 12.2148 16.5918C11.9296 16.5614 11.6583 16.45 11.4346 16.2705C11.2108 16.0909 11.0437 15.8501 10.9521 15.5781C10.8608 15.3065 10.8485 15.0144 10.918 14.7363L11.626 11.9014L11.6201 11.9043L11.5791 11.9238C11.2069 12.1054 10.7579 11.9511 10.5762 11.5791C10.3946 11.2069 10.5489 10.7579 10.9209 10.5762L10.9619 10.5557C11.2168 10.4298 11.5024 10.379 11.7852 10.4092ZM12.0078 7.5C12.422 7.5 12.7578 7.83579 12.7578 8.25V8.25781C12.7578 8.67203 12.422 9.00781 12.0078 9.00781H12C11.5858 9.00781 11.25 8.67203 11.25 8.25781V8.25C11.25 7.83579 11.5858 7.5 12 7.5H12.0078ZM21.75 12C21.75 13.2804 21.4978 14.5485 21.0078 15.7314C20.5178 16.9143 19.7998 17.9892 18.8945 18.8945C17.9892 19.7998 16.9143 20.5178 15.7314 21.0078C14.5485 21.4978 13.2804 21.75 12 21.75C10.7196 21.75 9.45148 21.4978 8.26855 21.0078C7.08573 20.5178 6.01078 19.7998 5.10547 18.8945C4.20016 17.9892 3.48217 16.9143 2.99219 15.7314C2.5022 14.5485 2.25 13.2804 2.25 12C2.25 9.41414 3.27699 6.93395 5.10547 5.10547C6.93395 3.27699 9.41414 2.25 12 2.25C14.5859 2.25 17.0661 3.27699 18.8945 5.10547C20.723 6.93395 21.75 9.41414 21.75 12Z"
              fill="#3289FA" />
          </svg>
        </div>
      </button>
    </div>

    <div class="mt-[25px] hidden grid-cols-7 lg:grid">
      <div class="flex items-center justify-center text-[15px]">月</div>
      <div class="flex items-center justify-center text-[15px]">火</div>
      <div class="flex items-center justify-center text-[15px]">水</div>
      <div class="flex items-center justify-center text-[15px]">木</div>
      <div class="flex items-center justify-center text-[15px]">金</div>
      <div class="flex items-center justify-center text-[15px] text-[#48CBFF]">土</div>
      <div class="flex items-center justify-center text-[15px] text-[#FF0000]">日</div>
      {{-- <div class="text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div> --}}
    </div>
    <div class="grid-cols-7 divide-x divide-y border lg:mt-[15px] lg:grid lg:rounded-lg">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'lg:min-h-[170px] min-h-[80px] lg:block flex items-center lg:items-normal',
            'bg-gray-100 hidden lg:block' => $content['type'] == '期間外',
        ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">

          <div class="hidden items-center justify-between px-[15px] lg:flex">
            <div @class(['text-[15px] py-[15px]'])>{{ $content['date']->isoFormat('D日') }}</div>
            @if ($content['type'] != '期間外')
              <div>
                @include('shift::admin.livewire.layouts.shift-create')
              </div>
            @endif
          </div>

          <div class="grid w-full grid-cols-[10%,80%,10%] items-center lg:grid-cols-1">

            <div @class(['lg:hidden flex justify-center items-center flex-col'])>
              <div>{{ $content['date']->isoFormat('D') }}</div>
              <div class="text-xs">{{ $content['date']->isoFormat('(ddd)') }}</div>
            </div>

            <div class="my-[15px] flex flex-col space-y-[10px] lg:my-0 lg:mb-5">
              @foreach ($content['shifts'] as $shift)
                <div
                  class="mr-[11px] flex cursor-pointer items-center space-x-[6px] rounded-lg border border-[#39A338] bg-[#F6FFF6] px-[10px] py-[7px]"
                  x-on:click="$dispatch('open-modal','edit-modal-{{ $shift->id }}')"
                  wire:click="setSchedule({{ $shift->id }})">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#39A338] text-xs text-white">
                    確
                  </div>
                  <div class="flex flex-col space-y-[3px] text-xs text-[#39A338]">
                    <div class="font-bold">
                      {{ $shift->start_time->isoFormat('H:mm') }}～{{ $shift->end_time->isoFormat('H:mm') }}
                    </div>
                    <div>{{ $shift->user->name }}</div>
                  </div>
                </div>
                @include('shift::admin.livewire.layouts.shift-edit', ['schedule' => $shift])
              @endforeach

              @foreach ($content['drafts'] as $draft)
                <div
                  class="mr-[11px] flex cursor-pointer items-center space-x-[6px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] px-[10px] py-[7px]"
                  wire:click="selectDraftShift({{ $draft->id }})">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#DE993A] text-xs text-white">
                    希
                  </div>
                  <div class="flex flex-col space-y-[3px] text-xs text-[#DE993A]">
                    <div class="font-bold">
                      {{ $draft->start_time->isoFormat('H:mm') }}～{{ $draft->end_time->isoFormat('H:mm') }}
                    </div>
                    <div>{{ $draft->user->name }}</div>
                  </div>
                </div>

                <x-modal name="confirm-shift-modal-{{ $draft->id }}" title="希望シフト">
                  <div>
                    @csrf

                    @if ($errors->any())
                      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
                        <ul class="list-disc pl-5">
                          @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                          @endforeach
                        </ul>
                      </div>
                    @endif

                    <div class="text-lg font-bold">
                      {{ $content['date']->format('Y.m.d') }}
                    </div>

                    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                      <x-input-label for="user" value="ユーザー名" />
                      <div class="w-full border-b border-gray-300 py-2 ps-3">
                        {{ $draft->user->name }}
                      </div>
                    </div>

                    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                      <x-input-label value="開始時間" />

                      <x-text-input class="mt-1 block w-full" type="time" wire:model="draftStartTime" required
                        x-data
                        @input="$event.target.style.color = $event.target.value < '{{ $draftStartTime }}' ? 'red' : 'black'" />
                    </div>

                    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                      <x-input-label value="終了時間" />

                      <x-text-input class="mt-1 block w-full" type="time" wire:model="draftEndTime" required
                        x-data
                        @input="$event.target.style.color = $event.target.value > '{{ $draftEndTime }}' ? 'red' : 'black'" />
                    </div>

                    <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
                      <x-secondary-button x-on:click="$dispatch('close')">
                        {{ __('Cancel') }}
                      </x-secondary-button>

                      <x-primary-button class="ms-3" wire:click="upShift({{ $draft->id }})">
                        確定する
                      </x-primary-button>
                    </div>
                  </div>
                </x-modal>
              @endforeach
            </div>

            @if ($content['type'] != '期間外')
              <div class="lg:hidden">
                @include('shift::admin.livewire.layouts.shift-create')
              </div>
            @endif

          </div>
        </div>
      @endforeach
    </div>

    {{-- <div class="mt-[10px] block lg:hidden">
      <div class="border-b px-5 py-[10px] text-xl font-bold">{{ $selectedDate->isoFormat('M月') }}</div>
      @foreach ($this->calendar as $key => $content)
        @if ($content['type'] != '補助日')
          <div @class([
              'flex min-h-[60px] items-center justify-between border-b px-5 py-[10px]',
              'bg-[#F9FAFF]' => $content['date']->format('Ymd') === now()->format('Ymd'),
          ]) wire:key="calendar-{{ $content['date']->format('Y-m-d') }}">
            <div @class([
                'text-xs',
                'font-bold text-[#3289FA]' =>
                    $content['date']->format('Ymd') === now()->format('Ymd'),
                'text-[#48CBFF]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '土',
                'text-[#FF0000]' =>
                    $content['date']->format('Ymd') !== now()->format('Ymd') &&
                    $content['date']->isoFormat('ddd') === '日',
            ])>{{ $content['date']->isoFormat('D日（ddd曜）') }}</div>

          </div>
        @endif
      @endforeach
    </div> --}}

    {{-- <div class="block lg:hidden">
      @foreach ($this->calendar as $key => $content)
        <div @class([
            'grid grid-cols-[15%,75%,10%] min-h-[60px]  border-b py-[10px]',
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
            @foreach ($content['shifts'] as $shift)
              <div
                class="flex cursor-pointer items-center justify-between space-x-[6px] rounded-lg border border-[#39A338] bg-[#F6FFF6] px-[10px] py-[7px] text-xs text-[#39A338]"
                x-on:click="$dispatch('open-modal','edit-modal-{{ $shift->id }}')"
                wire:click="setSchedule({{ $shift->id }})">
                <div class="flex items-center space-x-2">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#39A338] text-xs text-white">
                    確
                  </div>
                  <div class="font-semibold">
                    {{ $shift->start_time->isoFormat('H:mm') }}～{{ $shift->end_time->isoFormat('H:mm') }}
                  </div>
                </div>
                <div class="">{{ $shift->user->name }}</div>
              </div>
              @include('shift::admin.livewire.layouts.shift-edit', ['schedule' => $shift])
            @endforeach

            @foreach ($content['drafts'] as $draft)
              <div
                class="flex cursor-pointer items-center justify-between space-x-[6px] rounded-lg border border-[#DE993A] bg-[#FFF7EC] px-[10px] py-[7px] text-xs text-[#DE993A]"
                wire:click="selectDraftShift({{ $draft->id }})">
                <div class="flex items-center space-x-2">
                  <div
                    class="flex h-[22px] w-[22px] items-center justify-center rounded bg-[#DE993A] text-xs text-white">
                    希
                  </div>
                  <div class="font-semibold">
                    {{ $draft->start_time->isoFormat('H:mm') }}～{{ $draft->end_time->isoFormat('H:mm') }}
                  </div>
                </div>
                <div>{{ $draft->user->name }}</div>
              </div>

              <x-modal name="confirm-shift-modal-{{ $draft->id }}" title="希望シフト">
                <div>
                  @csrf

                  @if ($errors->any())
                    <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
                      <ul class="list-disc pl-5">
                        @foreach ($errors->all() as $error)
                          <li>{{ $error }}</li>
                        @endforeach
                      </ul>
                    </div>
                  @endif

                  <div class="text-lg font-bold">
                    {{ $content['date']->format('Y.m.d') }}
                  </div>

                  <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                    <x-input-label for="user" value="ユーザー名" />
                    <div class="w-full border-b border-gray-300 py-2 ps-3">
                      {{ $draft->user->name }}
                    </div>
                  </div>

                  <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                    <x-input-label for="start_time" value="開始時間" />

                    <x-text-input class="mt-1 block w-full" type="time" wire:model="draftStartTime" required
                      x-data
                      @input="$event.target.style.color = $event.target.value < '{{ $draftStartTime }}' ? 'red' : 'black'" />
                  </div>

                  <div class="mt-4 grid grid-cols-[20%,80%] items-center">
                    <x-input-label for="end_time" value="終了時間" />

                    <x-text-input class="mt-1 block w-full" type="time" wire:model="draftEndTime" required x-data
                      @input="$event.target.style.color = $event.target.value > '{{ $draftEndTime }}' ? 'red' : 'black'" />
                  </div>

                  <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
                    <x-secondary-button x-on:click="$dispatch('close')">
                      {{ __('Cancel') }}
                    </x-secondary-button>

                    <x-primary-button class="ms-3" wire:click="upShift({{ $draft->id }})">
                      確定する
                    </x-primary-button>
                  </div>
                </div>
              </x-modal>
            @endforeach

          </div>
          <div class="flex items-center justify-center">
            @include('shift::admin.livewire.layouts.shift-create')
          </div>
        </div>
      @endforeach
    </div> --}}

    {{-- <livewire:shift::admin.manager-edit :$manager @updated="$refresh" /> --}}
  </x-dashboard.container>
</x-dashboard.index>
