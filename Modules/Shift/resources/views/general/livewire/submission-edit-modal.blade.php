<div>
  <x-modal name="edit-modal-{{ $schedule->id }}" title="シフト希望編集">
    @if ($schedule->shiftStatus || !$manager->OverSubmissionPeriod)
      <div class="p-4">
        <div class="mt-4 text-start text-lg font-bold">
          {{ $schedule->date->format('Y年m月d日') }}
        </div>

        <div class="mt-4">
          <x-input-label class="text-start" value="希望開始時間" />

          <div class="border-b p-2 text-left">
            {{ $schedule->start_time->format('H:i') }}
          </div>
        </div>

        <div class="mt-4">
          <x-input-label class="text-start" value="希望終了時間" />

          <div class="border-b p-2 text-left">
            {{ $schedule->end_time->format('H:i') }}
          </div>
        </div>

        <div class="mt-4">
          <x-input-label class="text-start" value="確定開始時間" />

          <div class="border-b p-2 text-left">
            {{ $schedule->shiftSchedule->start_time->format('H:i') }}
          </div>
        </div>

        <div class="mt-4">
          <x-input-label class="text-start" value="確定終了時間" />

          <div class="border-b p-2 text-left">
            {{ $schedule->shiftSchedule->end_time->format('H:i') }}
          </div>
        </div>

        <x-slot:footer>
          <x-secondary-button x-on:click="$dispatch('close')">
            {{ __('Cancel') }}
          </x-secondary-button>
        </x-slot:footer>
      </div>
    @endif

    @if (!$schedule->shiftStatus && $manager->OverSubmissionPeriod)
      <div class="p-4">
        @if ($errors->any())
          <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
            <ul class="list-disc pl-5">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif
        <div class="flex items-center justify-between">
          <div class="text-start text-xl font-bold">
            {{ $schedule->date->format('Y年m月d日') }}
          </div>
          <button class="flex items-center space-x-1 text-[#F76E80] hover:opacity-40"
            x-on:click="$dispatch('open-modal','delete-alert-{{ $schedule->id }}')">
            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path
                d="M12.2833 7.49995L11.995 14.9999M8.005 14.9999L7.71667 7.49995M16.0233 4.82495C16.3083 4.86828 16.5917 4.91411 16.875 4.96328M16.0233 4.82495L15.1333 16.3941C15.097 16.8651 14.8842 17.3051 14.5375 17.626C14.1908 17.9469 13.7358 18.1251 13.2633 18.1249H6.73667C6.26425 18.1251 5.80919 17.9469 5.46248 17.626C5.11578 17.3051 4.90299 16.8651 4.86667 16.3941L3.97667 4.82495M16.0233 4.82495C15.0616 4.67954 14.0948 4.56919 13.125 4.49411M3.97667 4.82495C3.69167 4.86745 3.40833 4.91328 3.125 4.96245M3.97667 4.82495C4.93844 4.67955 5.9052 4.56919 6.875 4.49411M13.125 4.49411V3.73078C13.125 2.74745 12.3667 1.92745 11.3833 1.89661C10.4613 1.86714 9.53865 1.86714 8.61667 1.89661C7.63333 1.92745 6.875 2.74828 6.875 3.73078V4.49411M13.125 4.49411C11.0448 4.33334 8.95523 4.33334 6.875 4.49411"
                stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
            <p>削除</p>
          </button>
        </div>
        <form id="shift-edit-{{ $schedule->id }}" wire:submit="update">
          @csrf

          <div class="mt-4 grid w-full grid-cols-[20%,80%] items-center">
            <x-input-label value="時間" />

            <div class="flex w-full items-center space-x-1">
              <x-text-input class="flex-1" id="start_time" name="start_time" type="time" wire:model="form.startTime"
                required />

              <div class="px-[10px]">〜</div>

              <x-text-input class="flex-1" id="end_time" name="end_time" type="time" wire:model="form.endTime"
                required />
            </div>
          </div>

          <x-slot:footer>
            <x-secondary-button x-on:click="$dispatch('close')">
              {{ __('Cancel') }}
            </x-secondary-button>

            <x-primary-button class="ms-3" form="shift-edit-{{ $schedule->id }}">
              更新
            </x-primary-button>
          </x-slot:footer>
        </form>
      </div>
    @endif
  </x-modal>

  <x-modal-alert name="delete-alert-{{ $schedule->id }}" title="削除" maxWidth="350">
    <form wire:submit="delete">
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <p class="text-xs">以下のシフトを削除いたします</p>
        <div class="pt-[13px] text-[15px] font-bold">
          {{ $schedule->date->format('Y年m月d日') }}<br>{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time->format('H:i') }}
        </div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click="$dispatch('close-modal', 'delete-alert-{{ $schedule->id }}')">キャンセル</div>
        <button class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit">削除する</button>
      </div>
    </form>
  </x-modal-alert>
</div>
