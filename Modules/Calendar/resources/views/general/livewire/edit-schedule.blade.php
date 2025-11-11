<div>
  <x-modal name="schedule-edit-modal-{{ $schedule->id }}" title="予定編集">
    <div class="mb-4 flex items-center justify-between">
      <div class="text-xl font-bold"> {{ $form->date }}</div>
      <form wire:submit="delete">
        @csrf
        @method('delete')
        <button class="flex items-center space-x-1 hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal', 'schedule-delete-modal-{{ $schedule->id }}')">
          <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M7.43641 0.904945C7.99943 0.895945 8.56261 0.900238 9.12547 0.918227L9.33328 0.935414C10.3543 1.07162 11.0997 1.95921 11.0997 2.98541V3.04479C11.507 3.08331 11.9136 3.13006 12.3192 3.18385L12.9083 3.26745L13.602 3.37995C13.9285 3.43659 14.1476 3.74728 14.0911 4.0737C14.0345 4.40009 13.7237 4.61924 13.3973 4.56276C13.387 4.56097 13.3764 4.55907 13.3661 4.55729L12.7044 13.162C12.6637 13.6895 12.4255 14.1823 12.0372 14.5417C11.649 14.901 11.1396 15.1003 10.6106 15.1003H5.38875V15.0995C4.8598 15.0995 4.35038 14.901 3.96219 14.5417C3.62242 14.2272 3.3974 13.8107 3.31922 13.3581L3.295 13.162L2.6325 4.55651C2.62242 4.55825 2.61211 4.56023 2.60203 4.56198C2.27564 4.61847 1.96492 4.39932 1.90828 4.07291C1.85182 3.74654 2.07095 3.4358 2.39734 3.37916C2.62795 3.33915 2.8588 3.3021 3.09109 3.26745L3.68016 3.18385C4.08578 3.13006 4.49232 3.08331 4.89969 3.04479V2.98541C4.89969 1.89161 5.7476 0.95371 6.87391 0.918227L7.43641 0.904945ZM10.4536 4.19401C8.82018 4.06777 7.17919 4.06777 5.54578 4.19401C4.96972 4.23861 4.39501 4.29903 3.82234 4.37526L4.49109 13.0698C4.50853 13.2958 4.61065 13.5072 4.77703 13.6612C4.94342 13.8152 5.16202 13.9003 5.38875 13.9003H10.6106C10.8374 13.9003 11.0559 13.8152 11.2223 13.6612C11.3887 13.5072 11.4908 13.2958 11.5083 13.0698L12.1762 4.37526C11.6038 4.29907 11.0294 4.23859 10.4536 4.19401ZM6.14969 5.40104C6.48081 5.38831 6.75961 5.64648 6.77234 5.9776L7.00359 11.9776C7.01629 12.3086 6.758 12.5874 6.42703 12.6003C6.09592 12.613 5.81713 12.3548 5.80437 12.0237L5.57312 6.0237C5.5604 5.69266 5.8187 5.41392 6.14969 5.40104ZM9.84969 5.40104C10.1807 5.41392 10.439 5.69266 10.4262 6.0237L10.195 12.0237C10.1822 12.3548 9.90345 12.613 9.57234 12.6003C9.24137 12.5874 8.98309 12.3086 8.99578 11.9776L9.22703 5.9776C9.23976 5.64648 9.51856 5.38831 9.84969 5.40104ZM7.45594 2.10495L6.91219 2.11745C6.47505 2.13115 6.11591 2.49099 6.10047 2.95416C7.36531 2.88135 8.63328 2.88138 9.89812 2.95416C9.88367 2.52005 9.56913 2.17757 9.17 2.12448L9.08719 2.11745C8.54359 2.10007 7.99969 2.09626 7.45594 2.10495Z"
              fill="#FF4A62" />
          </svg>
          <p class="text-sm text-[#FF4A62]">削除する</p>
        </button>
      </form>
    </div>
    @if ($this->overlappingSchedules() || $this->overlappingShifts())
      <div><i class="fa-solid fa-circle-exclamation p-1 text-rose-600"></i>予定が重複しています</div>
    @endif
    <form wire:submit="update">

      @if ($errors->any())
        <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
          <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <div class="">
        <x-input-label for="title" value="タイトル" />

        <x-text-input class="mt-1 block w-full" type="text" wire:model="form.title" placeholder="タイトル" required />
      </div>

      <div class="mt-4">
        <x-input-label for="description" value="説明" />

        <x-text-area class="mt-1 block w-full" type="text" wire:model="form.description"
          placeholder="説明"></x-text-area>
      </div>

      <div class="mt-4">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" type="time" wire:model="form.startTime" required />
      </div>

      <div class="mt-4">
        <x-input-label for="end_time" value="終了時間" />

        <x-text-input class="mt-1 block w-full" type="time" wire:model="form.endTime" required />
      </div>
      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          更新
        </x-primary-button>
      </div>
    </form>
  </x-modal>
  <x-modal-alert name="schedule-delete-modal-{{ $schedule->id }}" title="スケジュールの削除" maxWidth="sm">
    <form method="POST" wire:submit="delete">
      @csrf
      @method('delete')
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <div class="pt-[13px] text-[15px] font-bold">スケジュール設定を削除します</div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click="$dispatch('close-modal', 'schedule-delete-modal-{{ $schedule->id }}')">キャンセル</div>
        <button class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit">削除する</button>
      </div>
    </form>
  </x-modal-alert>
</div>
