<div>
  <div class="mx-5 mb-2 text-[11px] font-bold sm:hidden">割増料金率</div>
  <div class="mx-5 flex items-center rounded-lg bg-[#F7F7F7] px-5 py-3 text-[13px] font-bold sm:rounded-none sm:px-5">
    <div class="hidden text-[#AAB0B6] sm:block">割増料金率：</div>
    <div class="sm:ps-[10px]">
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M10 2.5V4.375M15.3033 4.69667L13.9775 6.0225M17.5 10H15.625M15.3033 15.3033L13.9775 13.9775M10 15.625V17.5M6.0225 13.9775L4.69667 15.3033M4.375 10H2.5M6.0225 6.0225L4.69667 4.69667M13.125 10C13.125 10.8288 12.7958 11.6237 12.2097 12.2097C11.6237 12.7958 10.8288 13.125 10 13.125C9.1712 13.125 8.37634 12.7958 7.79029 12.2097C7.20424 11.6237 6.875 10.8288 6.875 10C6.875 9.1712 7.20424 8.37634 7.79029 7.79029C8.37634 7.20424 9.1712 6.875 10 6.875C10.8288 6.875 11.6237 7.20424 12.2097 7.79029C12.7958 8.37634 13.125 9.1712 13.125 10Z"
          stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>
    <div class="ps-1 text-[#AAB0B6]">早朝</div>
    <div class="ps-[10px] font-semibold">
      {{ $morningPremium === null ? '-' : (fmod($morningPremium, 1) == 0 ? (int) $morningPremium : $morningPremium) }}%
    </div>
    <hr class="mx-5 h-5 border-r" />
    <div>
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M18 12.522C17.1125 12.8919 16.1603 13.0817 15.1988 13.0804C11.1784 13.0804 7.91958 9.82157 7.91958 5.80119C7.91958 4.80823 8.11817 3.86231 8.47803 3C7.15169 3.5533 6.01875 4.48672 5.22188 5.68268C4.42502 6.87864 3.99988 8.28366 4 9.72078C4 13.7411 7.25885 17 11.2792 17C12.7163 17.0001 14.1214 16.575 15.3173 15.7781C16.5133 14.9813 17.4467 13.8483 18 12.522Z"
          stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>
    <div class="ps-1 text-[#AAB0B6]">深夜</div>
    <div class="ps-[10px] font-semibold">
      {{ $nightPremium === null ? '-' : (fmod($nightPremium, 1) == 0 ? (int) $nightPremium : $nightPremium) }}%</div>
    <button class="pl-[30px] text-sm text-[#3289FA] hover:opacity-40" type="button"
      x-on:click="$dispatch('open-modal','edit-modal')">設定する</button>
  </div>
  <x-modal name="edit-modal" title="割増料金設定">
    <form class="px-5 py-[18px]" wire:submit="save">

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
        <h5 class="text-[15px] font-bold">早朝料金</h5>
        <button class="flex items-center space-x-1 hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','morning-delete-modal')">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M11.055 6.75002L10.7955 13.5M7.2045 13.5L6.945 6.75002M14.421 4.34252C14.6775 4.38152 14.9325 4.42277 15.1875 4.46702M14.421 4.34252L13.62 14.7548C13.5873 15.1787 13.3958 15.5746 13.0838 15.8635C12.7717 16.1523 12.3622 16.3126 11.937 16.3125H6.063C5.63782 16.3126 5.22827 16.1523 4.91623 15.8635C4.6042 15.5746 4.41269 15.1787 4.38 14.7548L3.579 4.34252M14.421 4.34252C13.5554 4.21166 12.6853 4.11235 11.8125 4.04477M3.579 4.34252C3.3225 4.38077 3.0675 4.42202 2.8125 4.46627M3.579 4.34252C4.4446 4.21166 5.31468 4.11235 6.1875 4.04477M11.8125 4.04477V3.35777C11.8125 2.47277 11.13 1.73477 10.245 1.70702C9.41521 1.6805 8.58479 1.6805 7.755 1.70702C6.87 1.73477 6.1875 2.47352 6.1875 3.35777V4.04477M11.8125 4.04477C9.94029 3.90008 8.05971 3.90008 6.1875 4.04477"
              stroke="#F76E80" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div class="text-sm font-bold text-[#FF4A62]">削除する</div>
        </button>
      </div>

      <div class="mt-5 space-y-[6px]">
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="morningPremium">料金割増率</label>
          <input name="morningPremium" type="number" @class([
              'relative rounded border-[#DDDDDD] bg-[#FFFFFF] pr-9 text-sm focus:bg-white',
              'border-red-600' => $errors->has('morningPremium'),
          ]) wire:model="morningPremium"
            step="5">
          <div class="absolute right-9">%</div>
          </input>
        </div>
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="morningStartTime">開始時間</label>
          <input name="morningStartTime" type="time" @class([
              'rounded border-[#DDDDDD] bg-[#FFFFFF] text-sm focus:bg-white',
              'border-red-600' => $errors->has('morningStartTime'),
          ]) wire:model="morningStartTime">
        </div>
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="morningEndTime">終了時間</label>
          <input name="morningEndTime" type="time" @class([
              'rounded border-[#DDDDDD] bg-[#FFFFFF] text-sm focus:bg-white',
              'border-red-600' => $errors->has('morningEndTime'),
          ]) wire:model="morningEndTime">
        </div>
      </div>

      <hr class="my-5 border-b">

      <div class="flex items-center justify-between">
        <h5 class="text-[15px] font-bold">深夜料金</h5>
        <button class="flex items-center space-x-1 hover:opacity-40" type="button"
          x-on:click="$dispatch('open-modal','night-delete-modal')">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M11.055 6.75002L10.7955 13.5M7.2045 13.5L6.945 6.75002M14.421 4.34252C14.6775 4.38152 14.9325 4.42277 15.1875 4.46702M14.421 4.34252L13.62 14.7548C13.5873 15.1787 13.3958 15.5746 13.0838 15.8635C12.7717 16.1523 12.3622 16.3126 11.937 16.3125H6.063C5.63782 16.3126 5.22827 16.1523 4.91623 15.8635C4.6042 15.5746 4.41269 15.1787 4.38 14.7548L3.579 4.34252M14.421 4.34252C13.5554 4.21166 12.6853 4.11235 11.8125 4.04477M3.579 4.34252C3.3225 4.38077 3.0675 4.42202 2.8125 4.46627M3.579 4.34252C4.4446 4.21166 5.31468 4.11235 6.1875 4.04477M11.8125 4.04477V3.35777C11.8125 2.47277 11.13 1.73477 10.245 1.70702C9.41521 1.6805 8.58479 1.6805 7.755 1.70702C6.87 1.73477 6.1875 2.47352 6.1875 3.35777V4.04477M11.8125 4.04477C9.94029 3.90008 8.05971 3.90008 6.1875 4.04477"
              stroke="#F76E80" stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
          </svg>
          <div class="text-sm font-bold text-[#FF4A62]">削除する</div>
        </button>
      </div>

      <div class="mt-5 space-y-[6px]">
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="nightPremium">料金割増率</label>
          <input name="nightPremium" type="number" @class([
              'relative rounded border-[#DDDDDD] bg-[#FFFFFF] pr-9 text-sm focus:bg-white',
              'border-red-600' => $errors->has('nightPremium'),
          ]) wire:model="nightPremium"
            step="5">
          <div class="absolute right-9">%</div>
          </input>
        </div>
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="nightStartTime">開始時間</label>
          <input name="nightStartTime" type="time" @class([
              'rounded border-[#DDDDDD] bg-[#FFFFFF] text-sm focus:bg-white',
              'border-red-600' => $errors->has('nightStartTime'),
          ]) wire:model="nightStartTime">
        </div>
        <div class="grid grid-cols-[30%,70%] items-center">
          <label class="text-[11px] font-bold" for="nightEndTime">終了時間</label>
          <input name="nightEndTime" type="time" @class([
              'rounded border-[#DDDDDD] bg-[#FFFFFF] text-sm focus:bg-white',
              'border-red-600' => $errors->has('nightEndTime'),
          ]) wire:model="nightEndTime">
        </div>
      </div>

      <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          登録
        </x-primary-button>
      </div>
    </form>
  </x-modal>

  <x-modal-alert name="morning-delete-modal" title="早朝料金設定の削除" maxWidth="sm">
    <form method="POST" wire:submit="deleteMorning">
      @csrf
      @method('delete')
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <div class="pt-[13px] text-[15px] font-bold">早朝料金設定を削除します</div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click="$dispatch('close-modal', 'morning-delete-modal')">キャンセル</div>
        <button class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit">削除する</button>
      </div>
    </form>
  </x-modal-alert>

  <x-modal-alert name="night-delete-modal" title="深夜料金設定の削除" maxWidth="sm">
    <form method="POST" wire:submit="deleteNight">
      @csrf
      @method('delete')
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <div class="pt-[13px] text-[15px] font-bold">深夜料金設定を削除します</div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click="$dispatch('close-modal', 'night-delete-modal')">キャンセル</div>
        <button class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit">削除する</button>
      </div>
    </form>
  </x-modal-alert>

</div>
