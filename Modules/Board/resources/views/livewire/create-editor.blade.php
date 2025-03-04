<form id="postForm" wire:submit.prevent="submitPost" enctype="multipart/form-data">
  <div>
    <x-input-label for="title" value="タイトル" />

    <x-text-input class="mt-1 block w-full" id="title" name="title" type="text" placeholder="タイトル"
      wire:model="title" />

    @error('title')
      <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
  </div>

  <div class="mt-6">
    <x-input-label for="contents" value="本文" />
    <x-editor wire:model="contents" />
    @error('contents')
      <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
  </div>

  <div class="mt-6">
    <x-input-label for="files" value="ファイル添付" />

    <x-text-input class="mt-1 block w-full" id="files" name="files" type="file" wire:model="files" />
    @error('file')
      <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
    @enderror
  </div>

  <div class="row mt-10 flex justify-center space-x-5">
    <button
      class="inline-flex items-center rounded-md border border-transparent bg-ao-main px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-gray-700 focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
      id="postButton" type="button">
      投稿
    </button>
    <button
      class="inline-flex items-center rounded-md border px-4 py-2 text-xs font-semibold uppercase tracking-widest transition duration-150 ease-in-out hover:bg-gray-700 hover:bg-sky-700 hover:text-white focus:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 active:bg-gray-900"
      id="draftButton" type="button">
      下書きとして保存
    </button>

    <a class="inline-flex items-center rounded-md border border-transparent bg-red-600 px-4 py-2 text-xs font-semibold uppercase tracking-widest text-white transition duration-150 ease-in-out hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 active:bg-red-700"
      href="{{ route('board.index') }}">
      削除
    </a>
  </div>

  <script>
    document.getElementById('postButton').addEventListener('click', function() {
      console.log('a')
      Livewire.dispatch('submit-post', {
        branchStatus: true
      });
    });

    document.getElementById('draftButton').addEventListener('click', function() {
      console.log('b')
      Livewire.dispatch('submit-post', {
        branchStatus: false
      });
    });
  </script>

</form>
