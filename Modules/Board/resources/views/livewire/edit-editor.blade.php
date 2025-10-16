<x-main.index>
  <x-main.top>
    <div class="flex items-center justify-between lg:hidden">
      <h5 class="text-xl font-bold">投稿編集</h5>
    </div>
  </x-main.top>
  <x-main.container>
    <div class="hidden items-center justify-between lg:flex">
      <h5 class="text-xl font-bold">投稿編集</h5>
    </div>

    <form class="p-5 lg:mt-[30px] lg:p-0" id="postForm" wire:submit.prevent="submitPost" enctype="multipart/form-data">
      {{-- タイトル --}}
      <div class="flex flex-col">
        <x-input-label for="title" value="タイトル" />
        <x-text-input id="title" name="title" type="text" placeholder="タイトル" wire:model="title" />
        @error('title')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- 本文 --}}
      <div class="mt-[30px]">
        <x-input-label for="contents" value="本文" />
        <div class="mt-[7px]">
          <x-editor wire:model="contents" />
        </div>
        @error('contents')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- ファイル添付 --}}
      <div class="mt-6">
        <x-input-label for="files" value="ファイル添付" />

        <div
          class="mt-[7px] flex w-full flex-col items-center justify-center rounded-lg border border-dashed bg-[#F7F9FA] p-4"
          x-data="{ files: [] }" @dragover.prevent
          @drop.prevent="
            let dropped = Array.from($event.dataTransfer.files);
            files.push(...dropped);
            let dt = new DataTransfer();
            files.forEach(f => dt.items.add(f));
            $refs.fileInput.files = dt.files;
            $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
          ">
          <div class="flex h-[80px] w-full cursor-pointer flex-col items-center justify-center lg:h-[130px]"
            @click="$refs.fileInput.click()">
            <div class="mb-3 flex h-[35px] w-[35px] items-center justify-center rounded-full bg-[#EBEDF4] lg:mb-0">
              <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path
                  d="M1 10.75V12.375C1 12.806 1.1712 13.2193 1.47595 13.524C1.7807 13.8288 2.19402 14 2.625 14H12.375C12.806 14 13.2193 13.8288 13.524 13.524C13.8288 13.2193 14 12.806 14 12.375V10.75M4.25 4.25L7.5 1M7.5 1L10.75 4.25M7.5 1V10.75"
                  stroke="#AAB0B6" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
              </svg>
            </div>
            <p class="mb-[7px] mt-4 hidden text-xs font-bold text-[#AAB0B6] lg:block">
              ファイルをドラッグ＆ドロップ、またはクリックで選択
            </p>
            <div class="text-xs font-bold text-[#3289FA]" type="button">ファイルを選択する</div>
            <input type="file" x-ref="fileInput" wire:model="files" multiple hidden
              @change="
                files = Array.from($event.target.files);
              ">
          </div>

          <ul class="mt-4 w-full space-y-2">
            <div>
              @foreach ($existingFiles as $file)
                <li class="flex items-center justify-between rounded border bg-white px-3 py-2">
                  <span class="truncate text-xs text-gray-700">{{ $file->file_name }}</span>
                  <button class="text-xs text-red-500" type="button" wire:click="dropFile({{ $file }})">
                    ✕
                  </button>
                </li>
              @endforeach
            </div>
          </ul>

          {{-- 選択されたファイル一覧 --}}
          <ul @class(['w-full space-y-2', 'mt-4' => empty($existingFiles)]) x-show="files.length > 0">
            <template x-for="(file, index) in files" :key="index">
              <li class="flex items-center justify-between rounded border bg-white px-3 py-2">
                <span class="truncate text-xs text-gray-700" x-text="file.name"></span>
                <button class="text-xs text-red-500" type="button"
                  @click="
                    files.splice(index, 1);
                    let dt = new DataTransfer();
                    files.forEach(f => dt.items.add(f));
                    $refs.fileInput.files = dt.files;
                    $refs.fileInput.dispatchEvent(new Event('change', { bubbles: true }));
                  ">✕</button>
              </li>
            </template>
          </ul>
        </div>

        @error('files')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      {{-- ボタン --}}
      <div class="mt-10 hidden justify-center space-x-5 lg:flex">
        <a class="inline-flex h-[50px] w-[230px] items-center justify-center rounded-md border-2 border-[#3289FA] bg-white font-bold uppercase tracking-widest text-[#3289FA] hover:bg-blue-100"
          href="{{ route('board.index') }}">
          キャンセル
        </a>

        <button
          class="inline-flex h-[50px] w-[230px] items-center justify-center rounded-md bg-[#F7F7F7] font-bold uppercase tracking-widest text-[#3289FA] hover:bg-blue-100"
          id="updateButton" type="button">
          更新する
        </button>

        @if ($status == '下書き')
          <button
            class="inline-flex h-[50px] w-[230px] items-center justify-center rounded-md bg-[#3289FA] font-bold uppercase tracking-widest text-white hover:bg-blue-100"
            id="postButton" type="button">
            投稿する
          </button>
        @endif
      </div>

      <div class="my-5 block w-full lg:hidden">
        @if ($status == '下書き')
          <button
            class="inline-flex h-[50px] w-full items-center justify-center rounded-md bg-[#3289FA] font-bold uppercase tracking-widest text-white hover:bg-blue-100"
            id="postButton" type="button">
            投稿する
          </button>
        @endif

        <div class="mt-5 flex items-center justify-between space-x-5">
          <a class="inline-flex h-[50px] w-[230px] items-center justify-center rounded-md border-2 border-[#3289FA] bg-white font-bold uppercase tracking-widest text-[#3289FA] hover:bg-blue-100"
            href="{{ route('board.index') }}">
            キャンセル
          </a>

          <button
            class="inline-flex h-[50px] w-[230px] items-center justify-center rounded-md bg-[#F7F7F7] font-bold uppercase tracking-widest text-[#3289FA] hover:bg-blue-100"
            id="updateButton" type="button">
            更新する
          </button>
        </div>
      </div>

      <script>
        document.getElementById('updateButton').addEventListener('click', function() {
          Livewire.dispatch('submit-edit-post', {
            branchStatus: '下書き'
          });
        });

        document.getElementById('postButton').addEventListener('click', function() {
          Livewire.dispatch('submit-edit-post', {
            branchStatus: '掲載'
          });
        });
      </script>
    </form>
  </x-main.container>
</x-main.index>
