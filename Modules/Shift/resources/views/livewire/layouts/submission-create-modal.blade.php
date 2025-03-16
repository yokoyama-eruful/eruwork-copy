<x-modal name="create-dialog-{{ $content['date']->format('Y-m-d') }}" title="シフト希望登録">
  <form class="p-4" wire:submit="save">
    @csrf

    <div class="mt-4">
      <x-input-label for="date" value="日付" />

      <x-text-input class="mt-1 block w-full" id="date" name="date" type="date"
        min="{{ $this->manager->start_date->format('Y-m-d') }}" max="{{ $this->manager->end_date->format('Y-m-d') }}"
        wire:model="form.date" required />

      @error('form.date')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

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
