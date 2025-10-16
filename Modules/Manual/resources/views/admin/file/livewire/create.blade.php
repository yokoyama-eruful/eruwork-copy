<x-dashboard.index>
  @vite(['Modules/Manual/resources/assets/js/procedure.js', 'Modules/Manual/resources/assets/css/procedure.css'])
  <x-dashboard.top>
    <a class="hidden items-center hover:opacity-40 lg:flex"
      href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
      <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
        <path fill-rule="evenodd" clip-rule="evenodd"
          d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
          fill="#3289FA" />
      </svg>
      <div class="font-bold text-[#3289FA]">一覧画面に戻る</div>
    </a>
    <h5 class="text-xl font-bold lg:hidden">新規作成</h5>
  </x-dashboard.top>
  <form class="flex h-auto min-h-[calc(100dvh-100px)] space-x-5">
    <div
      class="top-container mt-[30px] h-auto min-h-full w-full rounded-[10px] lg:mt-[13px] lg:min-w-[960px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold lg:block">新規作成</h5>
      <div class="mx-5 flex flex-col lg:mx-0 lg:mt-[30px]">
        <x-input-label class="mb-[9px] hidden lg:block" for="title" value="マニュアルタイトル" />
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
                  @this.upload('form.uploadFile', files[0]);
              }
              this.isDragging = false;
          }
      }" x-on:dragover.prevent="isDragging = true" x-on:dragleave.prevent="isDragging = false"
        x-on:drop.prevent="handleDrop($event)">

        @if ($form->uploadFile)
          @if (str_contains($form->uploadFile->getMimeType(), 'image'))
            <div class="relative mt-[27px] h-[450px] w-full rounded-lg border border-dashed bg-[#F7F9FA]">
              <img class="h-full w-full rounded-lg" src="{{ $form->uploadFile->temporaryUrl() }}" />
              <button
                class="absolute right-2 top-2 flex h-[30px] w-[30px] items-center justify-center rounded bg-[#272727] bg-opacity-40 hover:bg-opacity-70"
                type="button" wire:click="deleteUploadFile">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.8457 18.8448L18.8457 6.84478M6.8457 6.84478L18.8457 18.8448" stroke="white"
                    stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          @elseif(str_contains($form->uploadFile->getMimeType(), 'video'))
            <div class="relative mt-[27px] h-[450px] w-full rounded-lg border border-dashed bg-[#F7F9FA]">
              <video class="h-full w-full rounded-lg" controls>
                <source src="{{ $form->uploadFile->temporaryUrl() }}" type="{{ $form->uploadFile->getMimeType() }}">
                Your browser does not support the video tag.
              </video>
              <button
                class="absolute right-2 top-2 flex h-[30px] w-[30px] items-center justify-center rounded bg-[#272727] bg-opacity-40 hover:bg-opacity-70"
                type="button" wire:click="deleteUploadFile">
                <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path d="M6.8457 18.8448L18.8457 6.84478M6.8457 6.84478L18.8457 18.8448" stroke="white"
                    stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </button>
            </div>
          @endif
        @else
          <div
            class="mx-5 mt-[27px] flex h-[220px] flex-col items-center justify-center rounded-lg border border-dashed bg-[#F7F9FA] lg:mx-0 lg:h-[450px] lg:w-full"
            :class="{ 'border-blue-500 bg-blue-50': isDragging }">
            <svg width="214" height="66" viewBox="0 0 214 66" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g opacity="0.4">
                <path
                  d="M58.3574 43.9153L50.7842 36.3421C50.3448 35.9027 49.8227 35.5543 49.2487 35.3165C48.6747 35.0788 48.0596 34.9563 47.4383 34.9563C46.817 34.9563 46.2019 35.0788 45.6279 35.3165C45.0539 35.5543 44.5318 35.9027 44.0924 36.3421L41.247 39.1875L44.3427 42.2831C44.9112 42.8517 44.9112 43.7733 44.3427 44.3418C43.7741 44.9104 42.8525 44.9104 42.2839 44.3418L28.0967 30.1546C27.6573 29.7152 27.1352 29.3668 26.5612 29.129C25.9872 28.8913 25.3721 28.7688 24.7508 28.7688C24.1295 28.7688 23.5144 28.8913 22.9404 29.129C22.3664 29.3668 21.8443 29.7152 21.4049 30.1546L7.64419 43.9153V49.5C7.64419 50.2079 7.92465 50.8875 8.42521 51.3881C8.92576 51.8886 9.60541 52.1691 10.3133 52.1691H55.6883C56.3962 52.1691 57.0758 51.8886 57.5764 51.3881C58.077 50.8875 58.3574 50.2079 58.3574 49.5V43.9153ZM39.4347 20.2117C39.9223 20.2603 40.3845 20.453 40.7636 20.7634L40.9475 20.9283L41.1124 21.1122C41.4747 21.5547 41.6754 22.1106 41.6754 22.6875C41.6754 23.3471 41.4139 23.9803 40.9475 24.4467C40.4811 24.9131 39.8479 25.1746 39.1883 25.1746C38.5287 25.1746 37.8955 24.9131 37.4291 24.4467C37.0211 24.0387 36.7692 23.5031 36.7125 22.9339L36.7012 22.6875L36.7125 22.4411C36.7692 21.8719 37.0211 21.3363 37.4291 20.9283C37.8955 20.4619 38.5287 20.2004 39.1883 20.2004L39.4347 20.2117ZM58.3574 16.5C58.3574 15.7921 58.077 15.1125 57.5764 14.6119C57.1383 14.1738 56.5629 13.9048 55.9518 13.8441L55.6883 13.8309H10.3133C9.60541 13.8309 8.92576 14.1113 8.42521 14.6119C7.92465 15.1125 7.64419 15.7921 7.64419 16.5V39.7979L19.3462 28.0959C20.056 27.3861 20.8985 26.8232 21.8258 26.439C22.7531 26.0549 23.7471 25.8571 24.7508 25.8571C25.7546 25.8571 26.7485 26.0549 27.6758 26.439C28.6031 26.8232 29.4457 27.3861 30.1554 28.0959L39.1883 37.1288L42.0337 34.2834C42.7435 33.5736 43.586 33.0107 44.5133 32.6265C45.4406 32.2424 46.4346 32.0446 47.4383 32.0446C48.4421 32.0446 49.436 32.2424 50.3633 32.6265C51.2906 33.0107 52.1332 33.5736 52.8429 34.2834L58.3574 39.7979V16.5ZM61.2692 49.5C61.2692 50.9801 60.6817 52.4002 59.6351 53.4468C58.5885 54.4934 57.1684 55.0809 55.6883 55.0809H10.3133C8.83316 55.0809 7.41312 54.4934 6.3665 53.4468C5.31988 52.4002 4.73242 50.9801 4.73242 49.5V16.5C4.73242 15.0199 5.31988 13.5998 6.3665 12.5532C7.41312 11.5066 8.83316 10.9191 10.3133 10.9191H55.6883L56.2399 10.9457C57.5176 11.0725 58.7193 11.6374 59.6351 12.5532C60.6817 13.5998 61.2692 15.0199 61.2692 16.5V49.5Z"
                  fill="#AAB0B6" />
              </g>
              <g opacity="0.4">
                <path
                  d="M163.027 46.4063L163.019 46.2405C162.936 45.4241 162.245 44.7857 161.407 44.7857H157.282C156.388 44.7857 155.661 45.5121 155.661 46.4063V50.5313L155.669 50.6912C155.706 51.0623 155.87 51.4116 156.135 51.6776C156.401 51.9436 156.751 52.1069 157.122 52.1437L157.282 52.1518H161.407C162.301 52.1518 163.027 51.4254 163.027 50.5313V46.4063ZM163.019 35.928C162.936 35.1116 162.245 34.4732 161.407 34.4732H157.282C156.388 34.4732 155.661 35.1996 155.661 36.0938V40.2188L155.669 40.3845C155.752 41.2009 156.444 41.8393 157.282 41.8393H161.407L161.573 41.8312C162.335 41.7536 162.942 41.1465 163.019 40.3845L163.027 40.2188V36.0938L163.019 35.928ZM198.982 50.6912C199.019 51.0623 199.182 51.4116 199.448 51.6776C199.752 51.9815 200.165 52.1518 200.594 52.1518H204.719L204.885 52.1437C205.702 52.0606 206.34 51.3694 206.34 50.5313V46.4063L206.332 46.2405C206.249 45.4241 205.557 44.7857 204.719 44.7857H200.594C199.7 44.7857 198.974 45.5121 198.974 46.4063V50.5313L198.982 50.6912ZM163.027 25.7813L163.019 25.6155C162.936 24.7991 162.245 24.1607 161.407 24.1607H157.282C156.388 24.1607 155.661 24.8871 155.661 25.7813V29.9063L155.669 30.072C155.752 30.8884 156.444 31.5268 157.282 31.5268H161.407L161.573 31.5187C162.389 31.4356 163.027 30.7444 163.027 29.9063V25.7813ZM165.974 50.5313L165.982 50.697C166.065 51.5135 166.756 52.1518 167.594 52.1518H194.407C195.301 52.1518 196.027 51.4254 196.027 50.5313V36.0938C196.027 35.1996 195.301 34.4732 194.407 34.4732H167.594C166.756 34.4732 166.065 35.1116 165.982 35.928L165.974 36.0938V50.5313ZM198.974 40.2188L198.982 40.3845C199.065 41.2009 199.756 41.8393 200.594 41.8393H204.719L204.885 41.8312C205.647 41.7536 206.254 41.1465 206.332 40.3845L206.34 40.2188V36.0938L206.332 35.928C206.249 35.1116 205.557 34.4732 204.719 34.4732H200.594C199.756 34.4732 199.065 35.1116 198.982 35.928L198.974 36.0938V40.2188ZM163.019 15.303C162.942 14.541 162.335 13.9339 161.573 13.8563L161.407 13.8482H157.282C156.388 13.8482 155.661 14.5746 155.661 15.4688V19.5938L155.669 19.7595C155.752 20.5759 156.444 21.2143 157.282 21.2143H161.407L161.573 21.2062C162.335 21.1286 162.942 20.5215 163.019 19.7595L163.027 19.5938V15.4688L163.019 15.303ZM198.982 30.072C199.065 30.8884 199.756 31.5268 200.594 31.5268H204.719L204.885 31.5187C205.647 31.4411 206.254 30.834 206.332 30.072L206.34 29.9063V25.7813L206.332 25.6155C206.249 24.7991 205.557 24.1607 204.719 24.1607H200.594C199.7 24.1607 198.974 24.8871 198.974 25.7813V29.9063L198.982 30.072ZM165.974 29.9063L165.982 30.0662C166.019 30.4373 166.182 30.7866 166.448 31.0526C166.752 31.3565 167.165 31.5268 167.594 31.5268H194.407L194.573 31.5187C195.389 31.4356 196.027 30.7444 196.027 29.9063V15.4688L196.019 15.303C195.942 14.541 195.335 13.9339 194.573 13.8563L194.407 13.8482H167.594L167.429 13.8563C166.667 13.9339 166.059 14.541 165.982 15.303L165.974 15.4688V29.9063ZM198.974 19.5938L198.982 19.7537C199.019 20.1248 199.182 20.4741 199.448 20.7401C199.752 21.044 200.165 21.2143 200.594 21.2143H204.719L204.885 21.2062C205.647 21.1286 206.254 20.5215 206.332 19.7595L206.34 19.5938V15.4688C206.34 14.6306 205.702 13.9394 204.885 13.8563L204.719 13.8482H200.594L200.429 13.8563C199.612 13.9394 198.974 14.6306 198.974 15.4688V19.5938ZM209.286 50.5313L209.281 50.766C209.162 53.1006 207.289 54.9741 204.954 55.0925L204.719 55.0982H157.282C156.071 55.0982 154.909 54.6173 154.052 53.7608C153.196 52.9043 152.715 51.7425 152.715 50.5313V15.4688C152.715 13.0261 154.635 11.0298 157.047 10.9075L157.282 10.9018H204.719L204.954 10.9075C207.366 11.0298 209.286 13.0261 209.286 15.4688V50.5313Z"
                  fill="#AAB0B6" />
              </g>
              <path opacity="0.3"
                d="M102.906 41.25C101.823 41.25 100.872 40.9922 100.055 40.4766C99.2422 39.9609 98.6068 39.2396 98.1484 38.3125C97.6953 37.3854 97.4688 36.3021 97.4688 35.0625C97.4688 33.8125 97.6953 32.7214 98.1484 31.7891C98.6068 30.8568 99.2422 30.1328 100.055 29.6172C100.872 29.1016 101.823 28.8438 102.906 28.8438C103.99 28.8438 104.938 29.1016 105.75 29.6172C106.568 30.1328 107.203 30.8568 107.656 31.7891C108.115 32.7214 108.344 33.8125 108.344 35.0625C108.344 36.3021 108.115 37.3854 107.656 38.3125C107.203 39.2396 106.568 39.9609 105.75 40.4766C104.938 40.9922 103.99 41.25 102.906 41.25ZM102.906 39.5938C103.729 39.5938 104.406 39.3828 104.938 38.9609C105.469 38.5391 105.862 37.9844 106.117 37.2969C106.372 36.6094 106.5 35.8646 106.5 35.0625C106.5 34.2604 106.372 33.513 106.117 32.8203C105.862 32.1276 105.469 31.5677 104.938 31.1406C104.406 30.7135 103.729 30.5 102.906 30.5C102.083 30.5 101.406 30.7135 100.875 31.1406C100.344 31.5677 99.9505 32.1276 99.6953 32.8203C99.4401 33.513 99.3125 34.2604 99.3125 35.0625C99.3125 35.8646 99.4401 36.6094 99.6953 37.2969C99.9505 37.9844 100.344 38.5391 100.875 38.9609C101.406 39.3828 102.083 39.5938 102.906 39.5938ZM111.158 41V29H112.939V30.8125H113.064C113.283 30.2188 113.679 29.737 114.252 29.3672C114.825 28.9974 115.471 28.8125 116.189 28.8125C116.325 28.8125 116.494 28.8151 116.697 28.8203C116.9 28.8255 117.054 28.8333 117.158 28.8438V30.7187C117.096 30.7031 116.952 30.6797 116.729 30.6484C116.51 30.612 116.278 30.5937 116.033 30.5937C115.45 30.5937 114.929 30.7161 114.471 30.9609C114.018 31.2005 113.658 31.5339 113.393 31.9609C113.132 32.3828 113.002 32.8646 113.002 33.4062V41H111.158Z"
                fill="#222222" />
            </svg>

            <svg class="mt-[28px] hidden lg:block" width="50" height="50" viewBox="0 0 50 50" fill="none"
              xmlns="http://www.w3.org/2000/svg">
              <circle cx="25" cy="25" r="25" fill="#EBEDF4" />
              <path
                d="M15.7148 29.6429V31.9643C15.7148 32.58 15.9594 33.1704 16.3948 33.6058C16.8301 34.0411 17.4206 34.2857 18.0363 34.2857H31.9648C32.5805 34.2857 33.171 34.0411 33.6063 33.6058C34.0417 33.1704 34.2863 32.58 34.2863 31.9643V29.6429M20.3577 20.3571L25.0006 15.7143M25.0006 15.7143L29.6434 20.3571M25.0006 15.7143V29.6429"
                stroke="#AAB0B6" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>

            <p class="mt-[10px] hidden text-xs font-bold text-[#AAB0B6] lg:block">ファイルをエリア内にドラッグ＆ドロップしてください</p>
            <button class="mt-5 font-bold text-[#3289FA] hover:opacity-40" type="button"
              x-on:click="$refs.fileInput.click()">
              ファイルを選択する
            </button>

            <p class="mt-5 text-center text-sm opacity-30">
              ※推奨サイズ<br>
              画像：横780px × 高さ440px <br class="block lg:hidden"> 動画：1080p（フルHD）
            </p>
          </div>
        @endif

        <input class="hidden" id="fileUploadInput" type="file" wire:model="form.uploadFile" x-ref="fileInput">

        @error('form.uploadFile')
          <span class="error">{{ $message }}</span>
        @enderror
      </div>

      <div class="mt-[27px]">
        <x-input-label class="hidden lg:block" for="details[]" value="テキストボックス" />
        <div class="mt-[9px] flex flex-col border-[#DDDDDD] lg:rounded-lg lg:border">
          @foreach ($form->details as $index => $detail)
            <div class="min-h-[250px]">
              <div class="flex h-[60px] items-center border-b bg-[#F7F7F7] px-[10px]">
                <input class="w-full rounded-lg border-[#DDDDDD] text-sm placeholder-[#222222] placeholder-opacity-30"
                  wire:model="form.details.{{ $index }}.title" placeholder="タイトルを記入してください" />
              </div>
              <div class="flex items-center px-[10px] pt-[10px]">
                <textarea
                  class="h-auto min-h-[190px] w-full rounded-lg border-[#DDDDDD] text-sm placeholder-[#222222] placeholder-opacity-30"
                  wire:model="form.details.{{ $index }}.content" placeholder="タイトルに該当する文章を記載ください"></textarea>
              </div>
            </div>
            <div class="mb-[21px] mt-[13px] flex items-center justify-center space-x-[30px]">
              <button class="flex items-center space-x-1 hover:opacity-40" type="button"
                wire:click="addDetail({{ $index }})">
                <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                  xmlns="http://www.w3.org/2000/svg">
                  <path
                    d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
                    fill="#3289FA" />
                </svg>
                <p class="text-sm font-bold text-[#3289FA]">テキストボックスを追加する</p>
              </button>
              @if ($index != 0 || count($form->details) >= 2)
                <button class="flex items-center space-x-1 hover:opacity-40" type="button"
                  wire:click="deleteDetail({{ $index }})">
                  <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M11.6692 7.12499L11.3953 14.25M7.60475 14.25L7.33083 7.12499M15.2222 4.58374C15.4929 4.6249 15.7621 4.66844 16.0313 4.71515M15.2222 4.58374L14.3767 15.5744C14.3422 16.0219 14.14 16.4399 13.8106 16.7447C13.4813 17.0496 13.049 17.2189 12.6002 17.2187H6.39983C5.95103 17.2189 5.51873 17.0496 5.18936 16.7447C4.85999 16.4399 4.65784 16.0219 4.62333 15.5744L3.77783 4.58374M15.2222 4.58374C14.3085 4.4456 13.3901 4.34077 12.4688 4.26944M3.77783 4.58374C3.50708 4.62411 3.23792 4.66765 2.96875 4.71436M3.77783 4.58374C4.69152 4.4456 5.60994 4.34077 6.53125 4.26944M12.4688 4.26944V3.54428C12.4688 2.61011 11.7483 1.83111 10.8142 1.80182C9.93828 1.77382 9.06172 1.77382 8.18583 1.80182C7.25167 1.83111 6.53125 2.6109 6.53125 3.54428V4.26944M12.4688 4.26944C10.4925 4.11671 8.50747 4.11671 6.53125 4.26944"
                      stroke="#F76E80" stroke-width="1.3" stroke-linecap="round" stroke-linejoin="round" />
                  </svg>
                  <p class="text-sm font-bold text-[#F76E80]">削除する</p>
                </button>
              @endif
            </div>
          @endforeach
        </div>
      </div>

      <hr class="-mx-5 mt-[60px] border-t border-[#DDDDDD] lg:mt-[100px]">

      <div class="mt-[30px] lg:hidden">
        <div class="procedure-container">
          <h5 class="text-xl font-bold">業務手順</h5>
          <div class="procedure-rows mt-5">
            @foreach ($form->steps as $index => $step)
              <div class="procedure-row">
                <div class="marker">
                  <div class="circle">{{ $index + 1 }}</div>
                </div>
                <div x-data>
                  <div class="procedure-box">
                    <div class="procedure-box-title">
                      <h4>手順{{ $index + 1 }}</h4>
                      <div class="flex items-center space-x-5">
                        <button class="image-add-btn" type="button" @click="$refs.fileInput.click()">
                          <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                              d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
                              fill="#3289FA" />
                          </svg>
                          画像を追加する
                        </button>
                        @if ($index != 0 || count($form->steps) >= 2)
                          <button class="hover:opacity-40" type="button"
                            wire:click="deleteStep({{ $index }})">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M6 18L18 6M6 6L18 18" stroke="#5E5E5E" stroke-width="1.2"
                                stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </button>
                        @endif
                      </div>
                    </div>
                    <div class="form-area">
                      <textarea class="textarea-title-box" wire:model="form.steps.{{ $index }}.title" placeholder="例：野菜を盛り付ける"></textarea>

                      <textarea class="textarea-explanation-box" wire:model="form.steps.{{ $index }}.content"
                        placeholder="タイトルに該当する文章を記載してください"></textarea>

                      <input type="file" x-ref="fileInput" wire:model="form.steps.{{ $index }}.file"
                        hidden />

                      @if ($form->steps[$index]['file'])
                        <div class="relative max-h-[200px] w-full">
                          <img class="h-[200px] w-full" src="{{ $form->steps[$index]['file']->temporaryUrl() }}" />
                          <button
                            class="absolute right-2 top-2 flex h-[30px] w-[30px] items-center justify-center rounded bg-[#272727] bg-opacity-40 hover:bg-opacity-70"
                            type="button" wire:click="deleteStepFile({{ $index }})">
                            <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M6.8457 18.8448L18.8457 6.84478M6.8457 6.84478L18.8457 18.8448" stroke="white"
                                stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                          </button>
                        </div>
                      @endif
                    </div>
                  </div>
                  <button
                    class="mt-[11px] flex w-full items-center justify-center space-x-[4.25px] text-sm font-bold text-[#3289FA]"
                    type="button" wire:click="addStep({{ $index }})">
                    <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                      xmlns="http://www.w3.org/2000/svg">
                      <path
                        d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
                        fill="#3289FA" />
                    </svg>
                    <p>手順を追加する</p>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>

      <hr class="-mx-5 mt-[60px] border-t border-[#DDDDDD] lg:hidden">

      <div class="mb-[80px] mt-5 hidden items-center justify-center space-x-5 lg:flex">
        <a class="h-[50px] w-[230px] rounded hover:opacity-40" type="button"
          href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
          <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#5E5E5E] text-[#5E5E5E]">
            キャンセル
          </p>
        </a>
        <button class="h-[50px] w-[230px] rounded hover:opacity-40" type="button" wire:click="create('下書き')"
          wire:loading.attr="disabled" wire:target="create">
          <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#3289FA] text-[#3289FA]">
            下書きとして保存
          </p>
        </button>
        <button class="h-[50px] w-[230px] rounded bg-[#3289FA] font-bold text-white hover:opacity-40" type="button"
          wire:click="create('掲載')" wire:loading.attr="disabled" wire:target="create">投稿する</button>
      </div>

      <div class="mx-5 mb-[80px] mt-[30px] lg:hidden">
        <button class="h-[50px] w-full rounded bg-[#3289FA] font-bold text-white hover:opacity-40" type="button"
          wire:click="create('掲載')" wire:loading.attr="disabled" wire:target="create">投稿する</button>
        <div class="mt-[30px] flex items-center space-x-5">
          <a class="h-[50px] w-[230px] rounded hover:opacity-40" type="button"
            href="{{ route('manualFileManager.index', ['folder_id' => $folder->id]) }}">
            <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#5E5E5E] text-[#5E5E5E]">
              キャンセル
            </p>
          </a>
          <button class="h-[50px] w-[230px] rounded hover:opacity-40" type="button" wire:click="create('下書き')"
            wire:loading.attr="disabled" wire:target="create">
            <p class="flex h-full w-full items-center justify-center rounded border-2 border-[#3289FA] text-[#3289FA]">
              下書きとして保存
            </p>
          </button>
        </div>
      </div>
    </div>

    {{-- <div
      class="fixed right-0 top-0 z-50 flex h-full w-full items-center justify-center space-x-5 bg-white bg-opacity-80"
      wire:loading wire:target="create('下書き')">
      <img class="h-10 animate-bounce" src="{{ global_asset('img/icon/fukuro_pc.png') }}" />
      <div class="text-3xl font-bold">
        保存中
      </div>
    </div> --}}

    <div
      class="top-container mt-[20px] hidden h-auto min-h-full w-full rounded-[10px] lg:mt-[13px] lg:block lg:min-w-[320px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
      <h5 class="hidden text-xl font-bold lg:block">業務手順</h5>
      <div class="procedure-container">
        <div class="procedure-rows">
          @foreach ($form->steps as $index => $step)
            <div class="procedure-row">
              <div class="marker">
                <div class="circle">{{ $index + 1 }}</div>
              </div>
              <div x-data>
                <div class="procedure-box">
                  <div class="procedure-box-title">
                    <h4>手順{{ $index + 1 }}</h4>
                    <div class="flex items-center space-x-5">
                      <button class="image-add-btn" type="button" @click="$refs.fileInput.click()">
                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                          xmlns="http://www.w3.org/2000/svg">
                          <path
                            d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
                            fill="#3289FA" />
                        </svg>
                        画像を追加する
                      </button>
                      @if ($index != 0 || count($form->steps) >= 2)
                        <button class="hover:opacity-40" type="button"
                          wire:click="deleteStep({{ $index }})">
                          <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6 18L18 6M6 6L18 18" stroke="#5E5E5E" stroke-width="1.2" stroke-linecap="round"
                              stroke-linejoin="round" />
                          </svg>
                        </button>
                      @endif
                    </div>
                  </div>
                  <div class="form-area">
                    <textarea class="textarea-title-box" wire:model="form.steps.{{ $index }}.title" placeholder="例：野菜を盛り付ける"></textarea>

                    <textarea class="textarea-explanation-box" wire:model="form.steps.{{ $index }}.content"
                      placeholder="タイトルに該当する文章を記載してください"></textarea>

                    <input type="file" x-ref="fileInput" wire:model="form.steps.{{ $index }}.file"
                      hidden />

                    @if ($form->steps[$index]['file'])
                      <div class="relative max-h-[200px] w-full">
                        <img class="h-[200px] w-full" src="{{ $form->steps[$index]['file']->temporaryUrl() }}" />
                        <button
                          class="absolute right-2 top-2 flex h-[30px] w-[30px] items-center justify-center rounded bg-[#272727] bg-opacity-40 hover:bg-opacity-70"
                          type="button" wire:click="deleteStepFile({{ $index }})">
                          <svg width="25" height="25" viewBox="0 0 25 25" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M6.8457 18.8448L18.8457 6.84478M6.8457 6.84478L18.8457 18.8448" stroke="white"
                              stroke-width="1.2" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </button>
                      </div>
                    @endif
                  </div>
                </div>
                <button
                  class="mt-[11px] flex w-full items-center justify-center space-x-[4.25px] text-sm font-bold text-[#3289FA]"
                  type="button" wire:click="addStep({{ $index }})">
                  <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                      d="M13.8462 7.5C13.8462 5.8169 13.1778 4.20245 11.9877 3.01232C10.7975 1.82219 9.1831 1.15385 7.5 1.15385C5.8169 1.15385 4.20245 1.82219 3.01232 3.01232C1.82219 4.20245 1.15385 5.8169 1.15385 7.5C1.15385 8.33339 1.31794 9.15868 1.63687 9.92864C1.95579 10.6986 2.42304 11.3984 3.01232 11.9877C3.6016 12.577 4.30143 13.0442 5.07136 13.3631C5.84131 13.6821 6.66661 13.8462 7.5 13.8462C8.33339 13.8462 9.15869 13.6821 9.92864 13.3631C10.6986 13.0442 11.3984 12.577 11.9877 11.9877C12.577 11.3984 13.0442 10.6986 13.3631 9.92864C13.6821 9.15869 13.8462 8.33339 13.8462 7.5ZM6.92308 9.80769V8.07692H5.19231C4.87368 8.07692 4.61538 7.81863 4.61538 7.5C4.61538 7.18137 4.87368 6.92308 5.19231 6.92308H6.92308V5.19231C6.92308 4.87368 7.18137 4.61538 7.5 4.61538C7.81863 4.61538 8.07692 4.87368 8.07692 5.19231V6.92308H9.80769C10.1263 6.92308 10.3846 7.18137 10.3846 7.5C10.3846 7.81863 10.1263 8.07692 9.80769 8.07692H8.07692V9.80769C8.07692 10.1263 7.81863 10.3846 7.5 10.3846C7.18137 10.3846 6.92308 10.1263 6.92308 9.80769ZM15 7.5C15 8.48491 14.806 9.4604 14.4291 10.3703C14.0522 11.2802 13.4999 12.1071 12.8035 12.8035C12.1071 13.4999 11.2802 14.0522 10.3703 14.4291C9.4604 14.806 8.48491 15 7.5 15C6.51509 15 5.5396 14.806 4.62966 14.4291C3.71979 14.0522 2.89291 13.4999 2.19651 12.8035C1.50012 12.1071 0.947822 11.2802 0.570913 10.3703C0.194003 9.4604 -1.35475e-08 8.48491 0 7.5C2.96403e-08 5.51088 0.789992 3.60304 2.19651 2.19651C3.60304 0.789992 5.51088 0 7.5 0C9.48912 0 11.397 0.789992 12.8035 2.19651C14.21 3.60304 15 5.51088 15 7.5Z"
                      fill="#3289FA" />
                  </svg>
                  <p>手順を追加する</p>
                </button>
              </div>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </form>

</x-dashboard.index>
