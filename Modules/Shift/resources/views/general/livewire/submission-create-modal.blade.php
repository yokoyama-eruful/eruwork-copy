<x-modal name="create-modal-{{ $day->format('Y-m-d') }}" title="シフト希望登録">
  <form class="px-4 py-8" wire:submit="save">
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

    <div class="text-xl font-bold">
      {{ $day->format('Y.m.d') }}
    </div>

    <div class="mt-4 grid w-full grid-cols-[20%,80%] items-center">
      <x-input-label value="時間" />

      <div class="flex w-full items-center space-x-1">
        <x-text-input class="flex-1" id="start_time" name="start_time" type="time" wire:model="form.startTime" />

        <div class="px-[10px]">〜</div>

        <x-text-input class="flex-1" id="end_time" name="end_time" type="time" wire:model="form.endTime" />
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
