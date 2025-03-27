<div class="w-full">
  <div class="rounded border border-gray-300 shadow" x-data="setupEditor(@entangle('message'))" x-init="() => init($refs.editor)">
    <div class="menu flex flex-row items-center border-b border-gray-300 px-2">
      <div class="flex items-center">
        <button class="h-7 w-7 rounded" type="button" @click="toggleBold()" :class="{ 'bg-gray-200': isActive('bold') }">
          <i class="fa-solid fa-bold text-gray-600"></i>
        </button>
        <button class="h-7 w-7 rounded" type="button" @click="toggleItalic()">
          <i class="fa-solid fa-italic text-gray-600"></i>
        </button>
        <button class="h-7 w-7 rounded" type="button" @click="toggleStrike()">
          <i class="fa-solid fa-strikethrough text-gray-600"></i>
        </button>
        <button class="h-7 w-7 rounded" type="button" @click="toggleUnderline()">
          <i class="fa-solid fa-underline text-gray-600"></i>
        </button>
      </div>
      <div class="mx-2 h-6 border-l border-gray-300"></div>
      <div class="flex items-center">
        <button class="h-7 w-7 rounded" type="button" @click="toggleLink()">
          <i class="fa-solid fa-link text-gray-600"></i>
        </button>
      </div>
      <div class="mx-2 h-6 border-l border-gray-300"></div>
      <div class="flex items-center">
        <button class="h-7 w-7 rounded" type="button" @click="toggleOrderedList()">
          <i class="fa-solid fa-list-ol text-gray-600"></i>
        </button>
        <button class="h-7 w-7 rounded" type="button" @click="toggleBulletList()">
          <i class="fa-solid fa-list text-gray-600"></i>
        </button>
      </div>
    </div>

    <div class="h-auto max-h-40 min-h-10 overflow-y-auto p-2" x-ref="editor" wire:ignore></div>

    @if ($files)
      <div class="flex w-full flex-row space-x-2 overflow-x-auto">
        @foreach ($files as $key => $file)
          <div class="relative m-1 h-16 w-16 rounded-md border" wire:click="deleteUploadFile({{ $key }})">
            <img class="h-full w-full object-cover" src="{{ $file->temporaryUrl() }}">
            <button
              class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full border bg-white text-gray-500 hover:bg-gray-300 hover:text-gray-700">
              <i class="fa-solid fa-xmark"></i>
            </button>
          </div>
        @endforeach
      </div>
    @endif

    <div class="flex h-7 w-full flex-wrap items-center justify-between border-t px-2">
      <button class="h-7 w-7 rounded-full hover:bg-gray-200" type="button"
        onclick="document.getElementById('fileInput').click()">
        <i class="fa-solid fa-plus text-gray-600"></i>
      </button>
      <input id="fileInput" type="file" wire:model="files" multiple accept="image/*" hidden>
      <button class="h-7 w-7 rounded" type="button" wire:click="store">
        <i @class(['fa-solid fa-paper-plane text-gray-600'])></i>
      </button>
    </div>
  </div>
</div>
