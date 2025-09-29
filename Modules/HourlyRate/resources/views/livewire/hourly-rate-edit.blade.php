<div>
  <button x-on:click="$dispatch('open-modal','edit-modal-{{ $hourlyRate->id }}')">
    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path fill-rule="evenodd" clip-rule="evenodd"
        d="M4.5 12C4.5 11.6022 4.65804 11.2206 4.93934 10.9393C5.22064 10.658 5.60218 10.5 6 10.5C6.39782 10.5 6.77936 10.658 7.06066 10.9393C7.34196 11.2206 7.5 11.6022 7.5 12C7.5 12.3978 7.34196 12.7794 7.06066 13.0607C6.77936 13.342 6.39782 13.5 6 13.5C5.60218 13.5 5.22064 13.342 4.93934 13.0607C4.65804 12.7794 4.5 12.3978 4.5 12ZM10.5 12C10.5 11.6022 10.658 11.2206 10.9393 10.9393C11.2206 10.658 11.6022 10.5 12 10.5C12.3978 10.5 12.7794 10.658 13.0607 10.9393C13.342 11.2206 13.5 11.6022 13.5 12C13.5 12.3978 13.342 12.7794 13.0607 13.0607C12.7794 13.342 12.3978 13.5 12 13.5C11.6022 13.5 11.2206 13.342 10.9393 13.0607C10.658 12.7794 10.5 12.3978 10.5 12ZM16.5 12C16.5 11.6022 16.658 11.2206 16.9393 10.9393C17.2206 10.658 17.6022 10.5 18 10.5C18.3978 10.5 18.7794 10.658 19.0607 10.9393C19.342 11.2206 19.5 11.6022 19.5 12C19.5 12.3978 19.342 12.7794 19.0607 13.0607C18.7794 13.342 18.3978 13.5 18 13.5C17.6022 13.5 17.2206 13.342 16.9393 13.0607C16.658 12.7794 16.5 12.3978 16.5 12Z"
        fill="#AAB0B6" />
    </svg>
  </button>
  <x-modal name="edit-modal-{{ $hourlyRate->id }}" title="時給情報の編集">

    <form class="flex justify-end pr-[20px] pt-[30px]" wire:submit="delete">
      <button class="rounded px-2 py-1 text-red-600 hover:bg-red-600 hover:text-white" type="submit"
        onclick='return confirm("本当に削除しますか")'>
        <i class="fa-solid fa-trash me-1"></i>
        記録を削除
      </button>
    </form>

    <form class="p-4" wire:submit="update" x-data="Datepickr()" x-init="initDatepickr">
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

      <div class="grid grid-cols-[20%,80%] items-center">
        <x-input-label for="rate" value="時給" />

        <x-text-input class="mt-1 block w-full" id="rate" name="rate" type="number" min="0"
          wire:model="rate" required />
      </div>

      <div class="mt-4 grid grid-cols-[20%,80%] items-center">
        <x-input-label for="date" value="開始日" />

        <x-text-input class="js-datepicker mt-1 block w-full" id="date" name="date" type="text"
          wire:model="date" required />
      </div>

      <div class="-mx-4 -mb-4 mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
        <x-secondary-button x-on:click="$dispatch('close')">
          {{ __('Cancel') }}
        </x-secondary-button>

        <x-primary-button class="ms-3">
          更 新
        </x-primary-button>
      </div>
    </form>
  </x-modal>
</div>
