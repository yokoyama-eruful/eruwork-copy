<div>
  <x-modal name="edit-modal-{{ $schedule->id }}" title="確定シフト編集">
    <div class="pb-20px flex justify-between px-2 pt-[30px]">
      <div class="ps-2 font-bold">
        {{ $content['date']->isoFormat('YYYY.MM.DD (ddd)') }}
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

    <form class="p-4" wire:submit="update">
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

      <div class="grid grid-cols-[20%,80%] items-center">
        @if ($schedule->shift_draft_schedule_id)
          <x-input-label value="ユーザー名" />
          <div class="w-full rounded-md ps-3 focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->user->name }}
          </div>
        @else
          <x-input-label for="user" value="ユーザー名" />
          <select class="w-full rounded-md focus:border-indigo-500 focus:ring-indigo-500" wire:model="form.userId">
            <option value="">選択してください</option>
            @foreach ($users as $user)
              <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
          </select>
        @endif
      </div>

      @if ($schedule->shift_draft_schedule_id)
        <div class="mt-4 grid grid-cols-[20%,80%] items-center">
          <x-input-label value="希望開始時間" />
          <div class="w-full rounded-md ps-3 focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->draftSchedule->start_time->format('H:i') }}
          </div>
        </div>
        <div class="mt-4 grid grid-cols-[20%,80%] items-center">
          <x-input-label value="希望終了時間" />
          <div class="w-full rounded-md ps-3 focus:border-indigo-500 focus:ring-indigo-500">
            {{ $schedule->draftSchedule->end_time->format('H:i') }}
          </div>
        </div>
      @endif

      <div class="mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
          wire:model="form.startTime" required />
      </div>

      <div class="mb-[30px] mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="end_time" value="終了時間" />

        <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" wire:model="form.endTime"
          required />
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
