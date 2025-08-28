<x-modal name="create-modal-{{ $date->format('Y-m-d') }}" title="予定登録" maxWidth="lg">
  <form class="px-[15px] py-5" id="create-form-{{ $date->format('Y-m-d') }}" method="post" wire:submit="add">
    @csrf

    <div class="flex items-center">
      <x-input-label class="w-1/5" for="date" value="日付" />

      <x-text-input class="js-datepicker w-4/5" id="date" name="date" type="text" wire:model="date"
        required />

      @error('form.date')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex items-center">
      <x-input-label class="w-1/5" value="時間" />

      <x-text-input class="w-[30%]" id="start_time" name="start_time" type="time" wire:model="form.startTime"
        required />

      <div class="px-[10px]">〜</div>

      <x-text-input class="w-[30%]" id="end_time" name="end_time" type="time" wire:model="form.endTime" required />

      @error('form.startTime')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
      @error('form.endTime')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex items-center">
      <x-input-label class="w-1/5" for="title" value="タイトル" />

      <x-text-input class="w-4/5" id="title" name="title" type="text" wire:model="form.title"
        placeholder="タイトル" required />

      @error('form.title')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>

    <div class="flex pt-[11px]">
      <x-input-label class="w-1/5 pt-2" for="description" value="説明" />

      <x-text-area class="min-h-[110px] w-4/5" id="description" name="description" type="text"
        wire:model="form.description" placeholder="説明"></x-text-area>

      @error('form.description')
        <div class="font-normal text-red-500">{{ $message }}</div>
      @enderror
    </div>
  </form>
  <x-slot:footer>
    <x-secondary-button x-on:click="$dispatch('close')">
      {{ __('Cancel') }}
    </x-secondary-button>

    <x-primary-button class="ms-3" form="create-form-{{ $date->format('Y-m-d') }}">
      登録
    </x-primary-button>
  </x-slot:footer>
</x-modal>
