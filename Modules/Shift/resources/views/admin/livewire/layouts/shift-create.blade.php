<x-modal name="create-modal" title="確定シフト登録">
  <div class="p-10 text-center" wire:loading wire:target="setDate">
    <i class="fa-solid fa-spinner fa-spin"></i> 読み込み中...
  </div>

  @if ($selectedDate)
    <form wire:submit="save('{{ $selectedDate }}')">
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

      <div class="text-lg font-bold">
        {{ $selectedDate->format('Y/m/d') }}
      </div>

      <div class="mt-5">
        <x-input-label for="user" value="ユーザー名" />
        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          wire:model="form.userId">
          <option value="">選択してください</option>
          @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mt-5">
        <x-input-label value="開始時間" />

        <x-text-input class="mt-1 block w-full" type="time" wire:model="form.startTime" required />
      </div>

      <div class="mt-5">
        <x-input-label value="終了時間" />

        <x-text-input class="mt-1 block w-full" type="time" wire:model="form.endTime" required />
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
  @endif
</x-modal>
