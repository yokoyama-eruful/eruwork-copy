<div class="my-5 px-5 pb-5" x-data="editor('')" x-on:keydown.ctrl.enter="sendButton()" wire:ignore>
  <div class="rounded-lg border-2 border-gray-400 bg-slate-50 p-1">
    <template x-if="isLoaded()">
      <div class="menu flex flex-row items-center text-gray-600">
        <div class="flex items-center">
          <button class="h-7 w-7 rounded" type="button" @click="toggleBold()"
            :class="{ 'is-active': isActive('bold', updatedAt) }">
            <i class="fa-solid fa-bold"></i>
          </button>
          <button class="h-7 w-7 rounded" type="button" @click="toggleItalic()"
            :class="{ 'is-active': isActive('italic', updatedAt) }">
            <i class="fa-solid fa-italic"></i>
          </button>
          <button class="h-7 w-7 rounded" type="button" @click="toggleStrike()"
            :class="{ 'is-active': isActive('strike', updatedAt) }">
            <i class="fa-solid fa-strikethrough"></i>
          </button>
          <button class="h-7 w-7 rounded" type="button" @click="toggleUnderline()"
            :class="{ 'is-active': isActive('underline', updatedAt) }">
            <i class="fa-solid fa-underline"></i>
          </button>
        </div>
        <div class="mx-2 h-6 border-l border-gray-300"></div> <!-- 縦線 -->
        <div class="flex items-center">
          <button class="h-7 w-7 rounded" type="button" @click="toggleLink()"
            :class="{ 'is-active': isActive('link') }">
            <i class="fa-solid fa-link"></i>
          </button>
        </div>
        <div class="mx-2 h-6 border-l border-gray-300"></div> <!-- 縦線 -->
        <div class="flex items-center">
          <button class="h-7 w-7 rounded" type="button" @click="toggleOrderedList()"
            :class="{ 'is-active': isActive('orderedList', updatedAt) }">
            <i class="fa-solid fa-list-ol"></i>
          </button>
          <button class="h-7 w-7 rounded" type="button" @click="toggleBulletList()"
            :class="{ 'is-active': isActive('bulletList', updatedAt) }">
            <i class="fa-solid fa-list"></i>
          </button>
        </div>
        <div class="mx-2 h-6 border-l border-gray-300"></div> <!-- 縦線 -->
        <div class="flex items-center">
          <button class="h-7 w-7 rounded" type="button" @click="toggleCodeBlock()"
            :class="{ 'is-active': isActive('codeBlock', updatedAt) }">
            <i class="fa-solid fa-code"></i>
          </button>
        </div>
      </div>

    </template>

    <div class="m-2 max-h-96 overflow-y-auto" x-ref="element"></div>

    <div class="flex items-center justify-between">
      @livewire('Chat.FileUpload', ['selectedGroup' => $chatGroup], key($chatGroup->id))
      <button class="h-7 w-7"
        :class="{
            'text-ao-main': !isContentEmpty,
            'text-gray-300': isContentEmpty,
        }"
        @click="sendButton()" :disabled="isContentEmpty"><i class="fa-solid fa-paper-plane"></i></button>
    </div>
  </div>
</div>
