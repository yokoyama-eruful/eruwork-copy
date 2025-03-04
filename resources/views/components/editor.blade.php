<div class="rounded border border-gray-300 shadow" x-data="setupEditor(@entangle($attributes['wire:model']).live)" x-init="() => init($refs.editor)" wire:ignore
  {{ $attributes->whereDoesntStartWith('wire:model') }}>
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

  <div class="h-auto min-h-32 overflow-y-auto p-2" x-ref="editor"></div>
</div>
