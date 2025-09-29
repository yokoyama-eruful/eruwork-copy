<x-modal name="create-modal-{{ $date->format('Y-m-d') }}" title="予定登録">
  <form class="px-[15px] py-5" method="post" wire:submit="add">
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

    <div class="mb-[20px] mt-[20px] flex items-center">
      <x-input-label class="w-1/5" for="date" value="日付" />

      <x-text-input class="js-datepicker w-4/5" id="date" name="date" type="text" wire:model="date"
        required />
    </div>

    <div class="mb-[20px] flex items-center">
      <x-input-label class="w-1/5" value="時間" />

      <x-text-input class="w-[30%]" id="start_time" name="start_time" type="time" wire:model="form.startTime"
        required />

      <div class="px-[10px]">〜</div>

      <x-text-input class="w-[30%]" id="end_time" name="end_time" type="time" wire:model="form.endTime" required />
    </div>

    <div class="flex items-center">
      <x-input-label class="w-1/5" for="title" value="タイトル" />

      <x-text-input class="w-4/5" id="title" name="title" type="text" wire:model="form.title"
        placeholder="タイトル" required />
    </div>

    <div class="mb-[40px] flex pt-[20px]">
      <x-input-label class="w-1/5 pt-2" for="description" value="説明" />

      <x-text-area class="min-h-[130px] w-4/5" id="description" name="description" type="text"
        wire:model="form.description" placeholder="説明"></x-text-area>
    </div>
    <div class="-mx-4 -mb-4 mt-4 flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登 録
      </x-primary-button>
    </div>
  </form>
</x-modal>
