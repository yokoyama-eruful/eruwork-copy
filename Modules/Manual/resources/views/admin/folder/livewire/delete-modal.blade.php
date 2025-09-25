<div>
  <button class="flex items-center" type="button" onclick="event.stopPropagation();"
    x-on:click="$dispatch('open-modal', 'manual-folder-delete-modal-{{ $folder->id }}')">
    <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path
        d="M12.2833 7.49995L11.995 14.9999M8.005 14.9999L7.71667 7.49995M16.0233 4.82495C16.3083 4.86828 16.5917 4.91411 16.875 4.96328M16.0233 4.82495L15.1333 16.3941C15.097 16.8651 14.8842 17.3051 14.5375 17.626C14.1908 17.9469 13.7358 18.1251 13.2633 18.1249H6.73667C6.26425 18.1251 5.80919 17.9469 5.46248 17.626C5.11578 17.3051 4.90299 16.8651 4.86667 16.3941L3.97667 4.82495M16.0233 4.82495C15.0616 4.67954 14.0948 4.56919 13.125 4.49411M3.97667 4.82495C3.69167 4.86745 3.40833 4.91328 3.125 4.96245M3.97667 4.82495C4.93844 4.67955 5.9052 4.56919 6.875 4.49411M13.125 4.49411V3.73078C13.125 2.74745 12.3667 1.92745 11.3833 1.89661C10.4613 1.86714 9.53865 1.86714 8.61667 1.89661C7.63333 1.92745 6.875 2.74828 6.875 3.73078V4.49411M13.125 4.49411C11.0448 4.33334 8.95523 4.33334 6.875 4.49411"
        stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
    </svg>
    <p class="mt-[1px] pl-[4px] pr-[5px] text-sm font-bold text-[#F76E80]">削除</p>
    <svg width="11" height="11" viewBox="0 0 11 11" fill="none" xmlns="http://www.w3.org/2000/svg">
      <path d="M3.78125 2.0625L7.21875 5.5L3.78125 8.9375" stroke="#F76E80" stroke-width="1.1" stroke-linecap="round"
        stroke-linejoin="round" />
    </svg>
  </button>
  <x-modal-alert name="manual-folder-delete-modal-{{ $folder->id }}" title="削除" maxWidth="sm">
    <form method="POST" wire:submit="delete">
      @csrf
      @method('delete')
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <p class="text-xs">以下のマニュアルフォルダーを削除いたします</p>
        <div class="pt-[13px] text-[15px] font-bold">{{ $folder->id }}</div>
      </div>
      <div class="my-5 flex items-center justify-center space-x-[10px]">
        <div class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded border-2"
          @click.stop="$dispatch('close-modal', 'manual-folder-delete-modal-{{ $folder->id }}')">キャンセル</div>
        <button class="flex h-11 w-[150px] cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit" @click.stop>削除する</button>
      </div>
    </form>
  </x-modal-alert>
</div>
