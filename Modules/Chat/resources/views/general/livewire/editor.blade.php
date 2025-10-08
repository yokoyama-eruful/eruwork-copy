<div class="flex h-full flex-col sm:justify-center">
  <!-- ===== 入力フォーム ===== -->
  <!-- スマホ版（画面下固定） -->
  <div class="fixed bottom-0 left-0 flex w-full items-center gap-2 bg-white p-3 pb-8 shadow-md sm:hidden">
    <!-- ファイル追加ボタン -->
    <button
      class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
      type="button" onclick="document.getElementById('fileInput').click()">
      <i class="fa-solid fa-plus text-gray-600"></i>
    </button>
    <input id="fileInput" type="file" wire:model="files" multiple accept="image/*" hidden>

    <!-- 入力欄 -->
    <div class="relative flex flex-1 items-center">
      <textarea
        class="flex h-[50px] w-full resize-none items-center rounded-lg border border-[#dddddd] bg-gray-50 p-3 text-sm text-gray-800 placeholder-gray-400"
        x-data x-ref="editor" wire:model="message" placeholder="文字を入力ください"></textarea>
    </div>

    <!-- 送信ボタン -->
    <button
      class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-[#3289FA] shadow-md hover:bg-[#2870c0]"
      type="button" wire:click="store">
      <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path
          d="M4 10L1.269 1.125C7.802 3.025 13.962 6.026 19.485 10C13.963 13.974 7.803 16.975 1.27 18.875L4 10ZM4 10H11.5"
          stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
      </svg>
    </button>
  </div>

  <!-- PC版（チャット幅に沿って下から20px上に配置） -->
  <div
    class="mx-auto hidden w-full max-w-[740px] flex-col items-center rounded-lg border border-[#dddddd] bg-white p-3 shadow-sm sm:flex">
    <!-- ファイル追加ボタン -->

    <div class="flex w-full items-center">
      <button
        class="mr-3 flex flex-shrink-0 items-center justify-center rounded-full border border-gray-300 hover:bg-gray-100"
        type="button" onclick="document.getElementById('fileInputPc').click()">
        <svg class="size-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
        </svg>
      </button>
      <input id="fileInputPc" type="file" wire:model="files" multiple accept="image/*" hidden>

      <!-- 入力欄 -->
      <div class="relative flex flex-1 items-center">
        <textarea
          class="flex h-[44px] w-full resize-none items-center rounded-l-lg border border-[#dddddd] bg-gray-50 p-3 text-sm text-gray-800 placeholder-gray-400 [scrollbar-width:none] focus:outline-none focus:ring-2 focus:ring-[#3289FA] [&::-webkit-scrollbar]:hidden"
          x-data x-ref="editor" wire:model="message" placeholder="テキストを入力してください"></textarea>
      </div>

      <!-- 送信ボタン -->
      <button
        class="flex h-11 w-11 flex-shrink-0 items-center justify-center rounded-r-lg bg-[#3289FA] shadow-md hover:bg-[#2870c0]"
        type="button" wire:click="store">
        <svg width="21" height="20" viewBox="0 0 21 20" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path
            d="M4 10L1.269 1.125C7.802 3.025 13.962 6.026 19.485 10C13.963 13.974 7.803 16.975 1.27 18.875L4 10ZM4 10H11.5"
            stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
        </svg>
      </button>
    </div>

    <!-- 添付ファイル（横スクロール対応） -->
    @if ($files)
      <div class="mt-2 flex flex-row items-center gap-2 overflow-x-auto p-3 md:mx-auto md:max-w-2xl">
        @foreach ($files as $key => $file)
          <div
            class="relative flex h-16 w-16 flex-shrink-0 items-center justify-center overflow-hidden rounded-lg border border-gray-200"
            wire:key="file-{{ $key }}">
            <img class="h-full w-full object-cover" src="{{ $file->temporaryUrl() }}">
            <button
              class="absolute -right-1 -top-1 flex h-5 w-5 items-center justify-center rounded-full border bg-white text-gray-500 hover:bg-gray-300"
              wire:click="deleteUploadFile({{ $key }})">
              <i class="fa-solid fa-xmark text-xs"></i>
            </button>
          </div>
        @endforeach
      </div>
    @endif
  </div>

</div>
