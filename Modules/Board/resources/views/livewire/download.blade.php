<div class="my-2 flex flex-col">
  @foreach ($this->files as $file)
    <div class="flex flex-row items-center space-x-1">
      <a class="flex w-auto flex-row hover:text-sky-400" href="{{ route('board.download', ['id' => $file->id]) }}">
        <div class="w-5"><i class="fa-solid fa-download"></i></div>
        <div class="w-auto max-w-96 truncate">
          {{ $this->stringTruncate($file->file_name) }}
        </div>
      </a>
      @if ($post->canEdit() && $canBeDeleted)
        <div>
          <button class="rounded-full p-1 transition-colors duration-300 hover:text-red-600" type="button"
            onclick="if(confirm('本当に削除しますか')) { @this.call('deleteFile', {{ $file->id }}) }">
            <i class="fa-regular fa-circle-xmark font-bold"></i>
          </button>
        </div>
      @endif
    </div>
  @endforeach
</div>
