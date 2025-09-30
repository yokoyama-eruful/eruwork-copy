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
    <div class="ps-[10px] font-semibold">{{ $morningPremium ?? '-' }}%</div>
    <hr class="mx-5 h-5 border-r" />
    <div>
      <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M18 12.522C17.1125 12.8919 16.1603 13.0817 15.1988 13.0804C11.1784 13.0804 7.91958 9.82157 7.91958 5.80119C7.91958 4.80823 8.11817 3.86231 8.47803 3C7.15169 3.5533 6.01875 4.48672 5.22188 5.68268C4.42502 6.87864 3.99988 8.28366 4 9.72078C4 13.7411 7.25885 17 11.2792 17C12.7163 17.0001 14.1214 16.575 15.3173 15.7781C16.5133 14.9813 17.4467 13.8483 18 12.522Z"
          stroke="#AAB0B6" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </div>
    <div class="ps-1 text-[#AAB0B6]">深夜</div>
    <div class="ps-[10px] font-semibold">{{ $nightPremium ?? '-' }}%</div>
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

      <h5 class="text-[15px] font-bold">早朝料金</h5>

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

      <h5 class="text-[15px] font-bold">深夜料金</h5>

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
</div>
