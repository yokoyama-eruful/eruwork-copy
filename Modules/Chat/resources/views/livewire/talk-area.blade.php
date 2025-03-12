<div class="h-1 flex-auto overflow-y-auto" x-data x-init="$el.scrollTop = $el.scrollHeight"
  @scroll=" if ($el.scrollTop === 0) {
         $dispatch('addViewMessage');
         $el.scrollTop += 10;
       }">
  @foreach ($messages->reverse() as $message)
    <div class="group relative flex h-auto flex-row hover:bg-gray-100">
      @if ($message->user->id === Auth::id())
        <button class="absolute right-2 top-2 opacity-0 hover:text-red-600 group-hover:opacity-100" type="button">
          <i class="fa-solid fa-trash"
            x-on:click.prevent="$dispatch('open-modal', 'delete-message-alert-{{ $message->id }}')"></i>
        </button>
        <x-modal-alert class="bg-red-600" name="delete-message-alert-{{ $message->id }}">
          <div class="text-center text-lg font-bold">削除しますか</div>
          <div class="my-2 max-h-32 min-h-32 overflow-y-auto rounded-md border p-2 shadow">
            <div class="flex h-full flex-1 flex-col py-2 pl-1 pr-2">
              <div class="flex flex-row space-x-1">
                <div class="font-bold">{{ $message->user->name }}</div>
                <div class="flex items-end text-sm text-gray-500">{{ $message->created_at->format('Y-m-d H:i') }}</div>
              </div>
              <div class="w-full">
                {!! $message->message !!}
                <div class="flex flex-row space-x-2">
                  @foreach ($message->images as $image)
                    <img class="max-h-20 rounded" src="{{ $image->file_path }}">
                  @endforeach
                </div>
              </div>
            </div>
          </div>
          <div class="flex justify-end space-x-2">
            <x-secondary-button x-on:click="show = false">キャンセル</x-secondary-button>
            <button
              class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
              type="button" wire:click="delete({{ $message->id }})" x-on:click="show = false">削除</button>
          </div>
        </x-modal-alert>
      @endif
      <div class="h-full w-10 py-2 pl-2 pr-1">
        @if ($message->user->icon)
          <img class="h-8 w-8 rounded-full border bg-white" src="{{ $message->user->icon }}" alt="アイコン">
        @else
          <div class="flex h-8 w-8 items-center justify-center rounded-full border bg-white">
            <i class="fa-solid fa-image"></i>
          </div>
        @endif
      </div>
      <div class="flex h-full flex-1 flex-col py-2 pl-1 pr-2">
        <div class="flex flex-row space-x-1">
          <div class="font-bold">{{ $message->user->name }}</div>
          <div class="flex items-end text-sm text-gray-500">{{ $message->created_at->format('Y-m-d H:i') }}</div>
        </div>
        <div class="w-full">
          {!! $message->message !!}
          <div class="flex flex-row space-x-2">
            @foreach ($message->images as $image)
              <div x-data="{ viewImage{{ $image->id }}: false }">
                <img class="max-h-20 rounded hover:cursor-zoom-in" src="{{ $image->file_path }}"
                  x-on:click="viewImage{{ $image->id }} = true">

                <div class="fixed inset-0 flex items-center justify-center"
                  x-show="viewImage{{ $image->id }} == true" x-cloak x-transition>
                  <button
                    class="absolute right-5 top-5 z-10 h-10 w-10 rounded-md bg-gray-400 hover:bg-gray-500 hover:text-red-600"
                    x-on:click="viewImage{{ $image->id }} = false"><i class="fa-solid fa-xmark"></i></button>
                  <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
                  <div class="relative z-10 max-h-[100vh] max-w-[100vh] bg-white">
                    <img class="max-h-[90vh] max-w-[90vw] object-contain" src="{{ $image->file_path }}">
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
