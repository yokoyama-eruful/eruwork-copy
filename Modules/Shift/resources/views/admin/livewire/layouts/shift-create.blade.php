<div>
  <button class="hover:opacity-40" type="button"
    x-on:click="$dispatch('open-modal', 'create-modal-{{ $content['date']->format('Y-m-d') }}')">
    <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M9 6.5V11.5M11.5 9H6.5M16.5 9C16.5 9.98491 16.306 10.9602 15.9291 11.8701C15.5522 12.7801 14.9997 13.6069 14.3033 14.3033C13.6069 14.9997 12.7801 15.5522 11.8701 15.9291C10.9602 16.306 9.98491 16.5 9 16.5C8.01509 16.5 7.03982 16.306 6.12987 15.9291C5.21993 15.5522 4.39314 14.9997 3.6967 14.3033C3.00026 13.6069 2.44781 12.7801 2.0709 11.8701C1.69399 10.9602 1.5 9.98491 1.5 9C1.5 7.01088 2.29018 5.10322 3.6967 3.6967C5.10322 2.29018 7.01088 1.5 9 1.5C10.9891 1.5 12.8968 2.29018 14.3033 3.6967C15.7098 5.10322 16.5 7.01088 16.5 9Z"
        stroke="#3289FA" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
  </button>
  <x-modal name="create-modal-{{ $content['date']->format('Y-m-d') }}" title="確定シフト登録">
    <form wire:submit="save('{{ $content['date'] }}')">
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
        {{ $content['date']->format('Y.m.d') }}
      </div>

      <div class="mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="user" value="ユーザー名" />
        <select class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
          wire:model="form.userId">
          <option value="">選択してください</option>
          @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
          @endforeach
        </select>
      </div>

      <div class="mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="start_time" value="開始時間" />

        <x-text-input class="mt-1 block w-full" type="time" wire:model="form.startTime" required />
      </div>

      <div class="mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="end_time" value="終了時間" />

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
  </x-modal>
</div>
