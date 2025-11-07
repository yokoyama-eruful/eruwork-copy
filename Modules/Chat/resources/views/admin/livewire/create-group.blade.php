<x-modal name="create-group-modal" maxWidth="440" mobileMaxWidth="350">
  <form wire:submit="store" enctype="multipart/form-data">
    @csrf
    <x-slot:title>
      グループ作成
    </x-slot:title>

    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div>
      <x-input-label for="icon" value="アイコン" />

      <button
        class="flex h-[44px] w-full items-center justify-center space-x-1 rounded bg-white text-sm font-bold text-[#3289FA] outline outline-1 outline-[#DDDDDD]"
        type="button" onclick="document.getElementById('icon').click()">
        <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M14.3077 7.75C14.3077 6.01079 13.6171 4.34254 12.3873 3.11273C11.1575 1.88292 9.48921 1.19231 7.75 1.19231C6.01079 1.19231 4.34254 1.88292 3.11273 3.11273C1.88292 4.34254 1.19231 6.01079 1.19231 7.75C1.19231 8.61117 1.36188 9.46397 1.69143 10.2596C2.02099 11.0552 2.5038 11.7783 3.11273 12.3873C3.72166 12.9962 4.44481 13.479 5.24041 13.8086C6.03603 14.1381 6.88883 14.3077 7.75 14.3077C8.61117 14.3077 9.46397 14.1381 10.2596 13.8086C11.0552 13.479 11.7783 12.9962 12.3873 12.3873C12.9962 11.7783 13.479 11.0552 13.8086 10.2596C14.1381 9.46397 14.3077 8.61117 14.3077 7.75ZM7.15385 10.1346V8.34615H5.36538C5.03614 8.34615 4.76923 8.07925 4.76923 7.75C4.76923 7.42075 5.03614 7.15385 5.36538 7.15385H7.15385V5.36538C7.15385 5.03614 7.42075 4.76923 7.75 4.76923C8.07925 4.76923 8.34615 5.03614 8.34615 5.36538V7.15385H10.1346C10.4639 7.15385 10.7308 7.42075 10.7308 7.75C10.7308 8.07925 10.4639 8.34615 10.1346 8.34615H8.34615V10.1346C8.34615 10.4639 8.07925 10.7308 7.75 10.7308C7.42075 10.7308 7.15385 10.4639 7.15385 10.1346ZM15.5 7.75C15.5 8.76774 15.2995 9.77575 14.9101 10.716C14.5206 11.6562 13.9499 12.5107 13.2303 13.2303C12.5107 13.9499 11.6562 14.5206 10.716 14.9101C9.77575 15.2995 8.76774 15.5 7.75 15.5C6.73226 15.5 5.72425 15.2995 4.78398 14.9101C3.84378 14.5206 2.98934 13.9499 2.26973 13.2303C1.55013 12.5107 0.979416 11.6562 0.589944 10.716C0.20047 9.77575 -1.39991e-08 8.76774 0 7.75C3.06283e-08 5.69457 0.816325 3.72314 2.26973 2.26973C3.72314 0.816325 5.69457 0 7.75 0C9.80543 0 11.7769 0.816325 13.2303 2.26973C14.6837 3.72314 15.5 5.69457 15.5 7.75Z"
            fill="#3289FA" />
        </svg>
        <p>ファイルを選択</p>
      </button>

      <x-text-input class="hidden" id="icon" name="icon" type="file" accept="image/*"
        wire:model="form.icon" />
    </div>

    @if ($form->icon)
      <div class="mt-3 flex items-center justify-between">
        <div class="flex space-x-2">
          <img class="h-[20px] w-[20px] rounded object-cover" src="{{ $form->icon->temporaryUrl() }}" alt="プレビュー">
          <p class="truncate text-sm">{{ $form->icon->getClientOriginalName() }}</p>
        </div>
      </div>
    @endif

    <div class="mt-5">
      <x-input-label for="name" value="グループ名" />

      <x-text-input class="block w-full" id="name" name="name" type="text" placeholder="グループ名"
        wire:model="form.name" required />
    </div>

    <div class="mt-5">
      <div class="flex flex-col gap-2 text-black">
        <span class="text-xs font-semibold">メンバーの選択</span>
        <div class="grid grid-cols-3 gap-3 lg:grid-cols-4">
          @foreach ($this->users as $user)
            <label class="block cursor-pointer rounded border p-2 transition" x-data="{ checked: false }"
              :class="checked ? 'bg-[#3289FA] text-white' : 'bg-white'">
              <input class="hidden" type="checkbox" x-model="checked" wire:model="form.member.{{ $user->id }}">
              {{ $user->name }}
            </label>
          @endforeach
        </div>
      </div>
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
