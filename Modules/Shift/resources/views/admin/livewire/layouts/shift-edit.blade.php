<div>
  <x-modal name="edit-modal-{{ $schedule->id }}" title="確定シフト編集">
    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="flex justify-between">
      <div class="font-bold">
        {{ $content['date']->isoFormat('YYYY.MM.DD (ddd)') }}
      </div>
      @if ($schedule->shift_draft_schedule_id)
        <form class="flex justify-end" wire:submit="downShift('{{ $content['date'] }}')">
          <button class="text-sm font-bold text-[#3289FA] hover:opacity-40" type="submit">
            希望シフトに戻す
          </button>
        </form>
      @else
        <form class="flex justify-end" wire:submit="downShift('{{ $content['date'] }}')">
          <button class="text-sm font-bold text-red-600 hover:opacity-40" type="submit">
            <i class="fa-solid fa-trash me-1"></i>
            削除する
          </button>
        </form>
      @endif
    </div>

    <form wire:submit="update">
      @csrf

      @if ($schedule->shift_draft_schedule_id)
        <div class="mt-5">
          <x-input-label value="提出されたシフト" />
          <div
            class="mt-2 grid grid-cols-[15%,65%,20%] items-center rounded-lg border border-[#DE993A] bg-[#FFF7EC] px-[10px] py-3 text-[#DE993A]">
            <div
              class="flex h-[35px] w-[35px] items-center justify-center rounded bg-[#DE993A] font-semibold text-white">希
            </div>
            <div class="font-semibold">
              {{ $schedule->draftSchedule->start_time->format('H:i') }} 〜
              {{ $schedule->draftSchedule->end_time->format('H:i') }}
            </div>
            <div class="text-end text-[15px] font-bold">{{ $user->name }}</div>
          </div>
        </div>

        <div class="mt-5 border-t"></div>
      @endif

      <div class="mt-5 font-bold">確定シフト</div>

      <div class="mt-5">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
          wire:model="form.startTime" required />
      </div>

      <div class="mt-5">
        <x-input-label for="end_time" value="終了時間" />

        <x-text-input class="mt-1 block w-full" id="end_time" name="end_time" type="time" wire:model="form.endTime"
          required />
      </div>

      <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
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
