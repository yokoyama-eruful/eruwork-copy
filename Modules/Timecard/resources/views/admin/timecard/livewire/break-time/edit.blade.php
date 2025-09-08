<x-modal name="edit-break-time-modal-{{ $breakTime->id }}">
  <form class="px-4 pb-4" id="form-break-time-{{ $breakTime->id }}" wire:submit="updateBreakTime">
    <div class="">
      <x-input-label for="title" value="開始時間" />

      <x-text-input class="mt-1 block w-full" name="in-time" type="time" wire:model="form.in_time" required />

      <x-input-error class="mt-2" :messages="$errors->get('form.in_time')" />
    </div>

    <div class="mt-4">
      <x-input-label for="title" value="終了時間" />

      <x-text-input class="mt-1 block w-full" name="out-time" type="time" wire:model="form.out_time" required />

      <x-input-error class="mt-2" :messages="$errors->get('form.out_time')" />
    </div>
    <x-input-error class="mt-2" :messages="$errors->get('form.out_time')" />
    <x-slot:footer>
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3" form="form-break-time-{{ $breakTime->id }}">
        更新
      </x-primary-button>
    </x-slot:footer>
  </form>
</x-modal>
