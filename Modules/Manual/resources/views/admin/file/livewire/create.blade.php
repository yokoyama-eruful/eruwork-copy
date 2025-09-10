<x-dashboard.index>
  <x-dashboard.top>
    <a class="flex items-center hover:opacity-40"
      href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
          fill="#3289FA" />
      </svg>
      <div class="font-bold text-[#3289FA]">一覧画面に戻る</div>
    </a>
  </x-dashboard.top>
  <form class="flex h-auto min-h-[calc(100vh-100px)] space-x-5" wire:submit="create">
    <div
      class="top-container mt-[20px] h-auto min-h-full w-full rounded-[10px] sm:mt-[13px] sm:min-w-[960px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold sm:block">新規作成</h5>
      <div class="mt-[30px] flex flex-col">
        <x-input-label for="title" value="マニュアルタイトル" />
        <x-text-input id="title" name="title" type="text" placeholder="タイトルを入力してください"
          wire:model="form.title" />
        @error('form.title')
          <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
        @enderror
      </div>

      <div x-data="{
          isDragging: false,
          handleDrop(e) {
              let files = e.dataTransfer.files;
              if (files.length > 0) {
                  // Livewireのファイルアップロード機能(@this.upload)を直接呼び出す
                  @this.upload('form.file', files[0]);
              }
              this.isDragging = false;
          }
      }" x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="handleDrop($event)">

        @if ($form->file)
          {{-- ファイル表示部分（変更なし） --}}
          @if (str_contains($form->file->getMimeType(), 'image'))
            <div class="relative mt-[27px] h-[450px] w-full rounded-lg border border-dashed bg-[#F7F9FA]">
              <img class="h-full w-full rounded-lg" src="{{ $form->file->temporaryUrl() }}" />
              <div
                class="absolute -right-4 -top-4 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-red-500 text-white"
                wire:click="deleteFile">
                ✖</div>
            </div>
          @elseif(str_contains($form->file->getMimeType(), 'video'))
            <div class="relative mt-[27px] h-[450px] w-full rounded-lg border border-dashed bg-[#F7F9FA]">
              <video class="h-full w-full rounded-lg" controls>
                <source src="{{ $form->file->temporaryUrl() }}" type="{{ $form->file->getMimeType() }}">
                Your browser does not support the video tag.
              </video>
              <div
                class="absolute -right-4 -top-4 flex h-8 w-8 cursor-pointer items-center justify-center rounded-full bg-red-500 text-white"
                wire:click="deleteFile">
                ✖</div>
            </div>
          @endif
        @else
          <div
            class="mt-[27px] flex h-[450px] w-full flex-col items-center justify-center rounded-lg border border-dashed bg-[#F7F9FA]"
            :class="{ 'border-blue-500 bg-blue-50': isDragging }">
            <svg width="66" height="66" viewBox="0 0 66 66" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.4">
                <path
                  d="M15.0273 46.4063L15.0193 46.2405C14.9361 45.4241 14.245 44.7857 13.4068 44.7857H9.28181C8.38769 44.7857 7.66127 45.5121 7.66127 46.4063V50.5313L7.66933 50.6912C7.70613 51.0623 7.8695 51.4116 8.13546 51.6776C8.40142 51.9436 8.75078 52.1069 9.12183 52.1437L9.28181 52.1518H13.4068C14.3009 52.1518 15.0273 51.4254 15.0273 50.5313V46.4063ZM15.0193 35.928C14.9361 35.1116 14.245 34.4732 13.4068 34.4732H9.28181C8.38769 34.4732 7.66127 35.1996 7.66127 36.0938V40.2188L7.66933 40.3845C7.75248 41.2009 8.44363 41.8393 9.28181 41.8393H13.4068L13.5725 41.8312C14.3345 41.7536 14.9417 41.1465 15.0193 40.3845L15.0273 40.2188V36.0938L15.0193 35.928ZM50.9818 50.6912C51.0186 51.0623 51.182 51.4116 51.448 51.6776C51.7519 51.9815 52.1645 52.1518 52.5943 52.1518H56.7193L56.885 52.1437C57.7015 52.0606 58.3398 51.3694 58.3398 50.5313V46.4063L58.3318 46.2405C58.2486 45.4241 57.5575 44.7857 56.7193 44.7857H52.5943C51.7002 44.7857 50.9738 45.5121 50.9738 46.4063V50.5313L50.9818 50.6912ZM15.0273 25.7813L15.0193 25.6155C14.9361 24.7991 14.245 24.1607 13.4068 24.1607H9.28181C8.38769 24.1607 7.66127 24.8871 7.66127 25.7813V29.9063L7.66933 30.072C7.75248 30.8884 8.44363 31.5268 9.28181 31.5268H13.4068L13.5725 31.5187C14.389 31.4356 15.0273 30.7444 15.0273 29.9063V25.7813ZM17.9738 50.5313L17.9818 50.697C18.065 51.5135 18.7561 52.1518 19.5943 52.1518H46.4068C47.3009 52.1518 48.0273 51.4254 48.0273 50.5313V36.0938C48.0273 35.1996 47.3009 34.4732 46.4068 34.4732H19.5943C18.7561 34.4732 18.065 35.1116 17.9818 35.928L17.9738 36.0938V50.5313ZM50.9738 40.2188L50.9818 40.3845C51.065 41.2009 51.7561 41.8393 52.5943 41.8393H56.7193L56.885 41.8312C57.647 41.7536 58.2542 41.1465 58.3318 40.3845L58.3398 40.2188V36.0938L58.3318 35.928C58.2486 35.1116 57.5575 34.4732 56.7193 34.4732H52.5943C51.7561 34.4732 51.065 35.1116 50.9818 35.928L50.9738 36.0938V40.2188ZM15.0193 15.303C14.9417 14.541 14.3345 13.9339 13.5725 13.8563L13.4068 13.8482H9.28181C8.38769 13.8482 7.66127 14.5746 7.66127 15.4688V19.5938L7.66933 19.7595C7.75248 20.5759 8.44363 21.2143 9.28181 21.2143H13.4068L13.5725 21.2062C14.3345 21.1286 14.9417 20.5215 15.0193 19.7595L15.0273 19.5938V15.4688L15.0193 15.303ZM50.9818 30.072C51.065 30.8884 51.7561 31.5268 52.5943 31.5268H56.7193L56.885 31.5187C57.647 31.4411 58.2542 30.834 58.3318 30.072L58.3398 29.9063V25.7813L58.3318 25.6155C58.2486 24.7991 57.5575 24.1607 56.7193 24.1607H52.5943C51.7002 24.1607 50.9738 24.8871 50.9738 25.7813V29.9063L50.9818 30.072ZM17.9738 29.9063L17.9818 30.0662C18.0186 30.4373 18.182 30.7866 18.448 31.0526C18.7519 31.3565 19.1645 31.5268 19.5943 31.5268H46.4068L46.5725 31.5187C47.389 31.4356 48.0273 30.7444 48.0273 29.9063V15.4688L48.0193 15.303C47.9417 14.541 47.3345 13.9339 46.5725 13.8563L46.4068 13.8482H19.5943L19.4286 13.8563C18.6666 13.9339 18.0594 14.541 17.9818 15.303L17.9738 15.4688V29.9063ZM50.9738 19.5938L50.9818 19.7537C51.0186 20.1248 51.182 20.4741 51.448 20.7401C51.7519 21.044 52.1645 21.2143 52.5943 21.2143H56.7193L56.885 21.2062C57.647 21.1286 58.2542 20.5215 58.3318 19.7595L58.3398 19.5938V15.4688C58.3398 14.6306 57.7015 13.9394 56.885 13.8563L56.7193 13.8482H52.5943L52.4286 13.8563C51.6121 13.9394 50.9738 14.6306 50.9738 15.4688V19.5938ZM61.2863 50.5313L61.2805 50.766C61.1622 53.1006 59.2887 54.9741 56.9541 55.0925L56.7193 55.0982H9.28181C8.07058 55.0982 6.90872 54.6173 6.05225 53.7608C5.19577 52.9043 4.71484 51.7425 4.71484 50.5313V15.4688C4.71484 13.0261 6.63465 11.0298 9.04701 10.9075L9.28181 10.9018H56.7193L56.9541 10.9075C59.3665 11.0298 61.2863 13.0261 61.2863 15.4688V50.5313Z"
                  fill="#AAB0B6" />
              </g>
            </svg>
            <p class="text-sm opacity-30">
              ※推奨サイズ<br>
              1080p（フルHD）
            </p>

            <svg class="mt-[28px]" width="50" height="50" viewBox="0 0 50 50" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <circle cx="25" cy="25" r="25" fill="#EBEDF4" />
              <path
                d="M15.7148 29.6429V31.9643C15.7148 32.58 15.9594 33.1704 16.3948 33.6058C16.8301 34.0411 17.4206 34.2857 18.0363 34.2857H31.9648C32.5805 34.2857 33.171 34.0411 33.6063 33.6058C34.0417 33.1704 34.2863 32.58 34.2863 31.9643V29.6429M20.3577 20.3571L25.0006 15.7143M25.0006 15.7143L29.6434 20.3571M25.0006 15.7143V29.6429"
                stroke="#AAB0B6" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <p class="mt-[10px] text-xs font-bold text-[#AAB0B6]">ファイルをエリア内にドラッグ＆ドロップしてください</p>
            <button class="mt-5 font-bold text-[#3289FA] hover:opacity-40" type="button"
              x-on:click="$refs.fileInput.click()">
              ファイルを選択する
            </button>
          </div>
        @endif

        {{-- inputは非表示にし、x-refで参照できるようにする --}}
        <input class="hidden" id="fileUploadInput" type="file" wire:model="form.file" x-ref="fileInput">

        @error('form.file')
          <span class="error">{{ $message }}</span>
        @enderror
      </div>

      @foreach ($form->details as $index => $detail)
        <div class="mt-[27px] flex flex-col">
          <x-input-label for="details[]" value="テキストボックス" />
          <div class="mt-[9px] min-h-[250px] rounded-lg border border-[#DDDDDD]">
            <div class="flex h-[60px] items-center border-b bg-[#F7F7F7] px-[10px]">
              <input class="w-full rounded-lg border-[#DDDDDD] text-sm placeholder-[#222222] placeholder-opacity-30"
                wire:model="form.details.{{ $index }}.title" placeholder="タイトルを記入してください" />
            </div>
            <div class="flex items-center p-[10px]">
              <textarea
                class="h-auto min-h-[190px] w-full rounded-lg border-[#DDDDDD] text-sm placeholder-[#222222] placeholder-opacity-30"
                wire:model="form.details.{{ $index }}.content" placeholder="タイトルに該当する文章を記載ください"></textarea>
            </div>
          </div>
        </div>
      @endforeach

      <div class="mt-[13px] flex items-center justify-center">
        <button class="flex items-center space-x-1 hover:opacity-40" type="button" wire:click="addDetail">
          <svg width="15" height="15" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path
              d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
              fill="#3289FA" />
          </svg>
          <p class="text-sm font-bold text-[#3289FA]">テキストボックスを追加する</p>
        </button>
      </div>

      <hr class="-mx-5 mt-[100px] border-t border-[#DDDDDD]">

      <div class="mb-[80px] mt-5 flex items-center justify-center space-x-5">
        <a class="h-[50px] w-[230px] rounded hover:opacity-40" type="button"
          href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
          <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#5E5E5E] text-[#5E5E5E]">
            キャンセル
          </p>
        </a>
        <button class="h-[50px] w-[230px] rounded hover:opacity-40" type="submit">
          <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#3289FA] text-[#3289FA]">
            下書きとして保存
          </p>
        </button>
        <button class="h-[50px] w-[230px] rounded bg-[#3289FA] font-bold text-white hover:opacity-40"
          type="submit">投稿する</button>
      </div>

    </div>
    <div
      class="top-container mt-[20px] h-auto min-h-full w-full rounded-[10px] sm:mt-[13px] sm:min-w-[320px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold sm:block">業務手順</h5>
    </div>
  </form>

</x-dashboard.index>
