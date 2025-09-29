<x-modal name="edit-work-time-modal-{{ $workTime->id }}" :title="'勤務時間修正'">
  <form class="p-4" wire:submit="updateWorkTime">

    @if ($errors->any())
      <div class="mb-4 rounded bg-red-100 p-3 text-red-700">
        <ul class="list-inside list-disc">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="grid grid-cols-[20%,80%] items-center">
      <x-input-label for="in-date" value="開始日付" />
      <x-text-input class="mt-1 block w-full" name="in-date" type="date" wire:model="form.in_date" required />
    </div>

    <div class="mt-2 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="in-time" value="開始時間" />
      <x-text-input class="mt-1 block w-full" name="in-time" type="time" wire:model="form.in_time" required />
    </div>

    <div class="mt-4 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="out-date" value="終了日付" />
      <x-text-input class="mt-1 block w-full" name="out-date" type="date" wire:model="form.out_date" required />
    </div>

    <div class="mt-2 grid grid-cols-[20%,80%] items-center">
      <x-input-label for="out-time" value="終了時間" />
      <x-text-input class="mt-1 block w-full" name="out-time" type="time" wire:model="form.out_time" required />
    </div>

    <x-input-error class="mt-2" :messages="$errors->get('form.out_time')" />
    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        更新
      </x-primary-button>
    </div>
  </form>
</x-modal>
