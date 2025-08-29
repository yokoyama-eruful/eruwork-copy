<div>
  {{-- <div class="flex flex-row items-center border-b hover:bg-slate-100 hover:text-blue-500"
    wire:click="setSchedule({{ $schedule->id }})">
    @if (is_null($schedule->draftSchedule))
      <div>
        ・{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time?->format('H:i') }}
      </div>
    @else
      <div @class([
          'text-black',
          'text-red-500' =>
              $schedule->draftSchedule->start_time > $schedule->start_time ||
              $schedule->draftSchedule->end_time < $schedule->end_time,
      ])>
        ・{{ $schedule->start_time->format('H:i') . ' ～ ' . $schedule->end_time?->format('H:i') }}
      </div>
    @endif
    <button class="pl-1">
      <i class="fa-regular fa-pen-to-square"></i>
    </button>
  </div> --}}

  <x-modal name="edit-modal-{{ $schedule->id }}" title="確定シフト編集">
    <div class="flex justify-between px-4 pt-4">
      <div class="text-xl font-bold">
        {{ $content['date']->isoFormat('YYYY年MM月DD日 (ddd)') }}
      </div>
      @if ($schedule->shift_draft_schedule_id)
        <form class="flex justify-end" wire:submit="downShift('{{ $content['date'] }}')">
          <button class="rounded px-2 py-1 text-amber-600 hover:bg-amber-600 hover:text-white" type="submit">
            <i class="fa-solid fa-circle-arrow-down me-1"></i>
            希望シフトに戻す
          </button>
        </form>
      @else
        <form class="flex justify-end" wire:submit="downShift">
          <button class="rounded px-2 py-1 text-red-600 hover:bg-red-600 hover:text-white" type="submit">
            <i class="fa-solid fa-trash me-1"></i>
            削除する
          </button>
        </form>
      @endif
    </div>

    <form class="px-4 pb-4" wire:submit="update">
      <div class="mt-4">

        @if ($schedule->shift_draft_schedule_id)
          <x-input-label value="ユーザー名" />
          <div class="w-full rounded-md border-b-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->user->name }}
          </div>
        @else
          <x-input-label for="user" value="ユーザー名" />
          <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
            wire:model="form.userId">
            <option value="">選択してください</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
          @error('form.user')
            <div class="text-sm font-normal text-red-500">{{ $message }}</div>
          @enderror
        @endif
      </div>

      @if ($schedule->shift_draft_schedule_id)
        <div class="mt-4">
          <x-input-label value="希望開始時間" />
          <div class="w-full rounded-md border-b-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->draftSchedule->start_time->format('H:i') }}
          </div>
        </div>
        <div class="mt-4">
          <x-input-label value="希望終了時間" />
          <div class="w-full rounded-md border-b-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->draftSchedule->end_time->format('H:i') }}
          </div>
        </div>
      @endif

      <div class="mt-4">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
          wire:model="form.startTime" required />

        @error('form.start_time')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-2">
        <x-input-label for="end_time" value="終了時間" />

        <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" wire:model="form.endTime"
          required />

        @error('form.endTime')
          <div class="font-normal text-red-500">{{ $message }}</div>
        @enderror
      </div>

      <div class="mt-6 flex justify-end">
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
