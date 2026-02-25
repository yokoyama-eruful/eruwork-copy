<div>
  <x-modal-alert name="manual-folder-delete-modal-{{ $folder->id }}" title="削除" maxWidth="sm">
    <form method="POST" wire:submit="delete">
      @csrf
      @method('delete')
      <div class="flex flex-col items-center bg-[#F7F7F7] px-5 pb-8 pt-4 text-left">
        <p class="text-xs">以下のマニュアルフォルダーを削除いたします</p>
        <div class="pt-[13px] text-[0.9375rem] font-bold">{{ $folder->title }}</div>
      </div>
      <div class="my-5 flex flex-col gap-[10px] sm:flex-row sm:items-center sm:justify-center sm:space-x-[10px] sm:gap-0">
        <div class="flex h-11 w-[150px] whitespace-nowrap cursor-pointer items-center justify-center rounded border-2"
          @click.stop="$dispatch('close-modal', 'manual-folder-delete-modal-{{ $folder->id }}')">キャンセル</div>
        <button class="flex h-11 w-[150px] whitespace-nowrap cursor-pointer items-center justify-center rounded bg-[#FF4A62] text-white"
          type="submit" @click.stop>削除する</button>
      </div>
    </form>
  </x-modal-alert>
</div>
