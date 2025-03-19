<x-modal name="create-dialog-{{ $date->format('Y-m-d') }}" title="予定登録">
  <form class="p-4" method="post" wire:submit="add">
    @csrf

    <div class="text-xl font-bold"> {{ $date->format('Y年m月d日') }}</div>

    <div class="mt-4">
      <x-input-label for="title" value="タイトル" />

      <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" wire:model="form.title"
        placeholder="タイトル" required />

      @error('form.title')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-2">
      <x-input-label for="description" value="説明" />

      <x-text-area class="mt-1 block w-full" id="description" name="description" type="text"
        wire:model="form.description" placeholder="説明"></x-text-area>

      @error('form.description')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="mt-4">
      <x-input-label for="start_time" value="開始時間" />

      <x-text-input class="mt-1 block w-full" id="start_time" name="start_time" type="time"
        wire:model="form.startTime" required />

      @error('form.startTime')
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
