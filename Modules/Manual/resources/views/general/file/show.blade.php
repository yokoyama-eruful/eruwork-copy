<x-app-layout :url="route('manualFile.index', ['folder_id' => $folder->id])">
  <x-main.index>
    @vite(['Modules/Manual/resources/assets/js/procedure.js', 'Modules/Manual/resources/assets/css/procedure.css'])
    <x-main.top>
      <a class="hidden items-center hover:opacity-40 sm:flex"
        href="{{ route('manualFile.index', ['folder_id' => $folder->id]) }}">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.78964 9.39738C5.6843 9.29192 5.62514 9.14895 5.62514 8.99988C5.62514 8.85082 5.6843 8.70785 5.78964 8.60238L11.4146 2.97738C11.5213 2.87802 11.6623 2.82393 11.808 2.8265C11.9538 2.82907 12.0928 2.88811 12.1959 2.99117C12.2989 3.09423 12.358 3.23327 12.3605 3.37899C12.3631 3.52472 12.309 3.66575 12.2096 3.77238L6.98214 8.99988L12.2096 14.2274C12.2649 14.2789 12.3092 14.341 12.34 14.41C12.3707 14.479 12.3873 14.5535 12.3886 14.629C12.3899 14.7045 12.376 14.7795 12.3477 14.8496C12.3194 14.9196 12.2773 14.9832 12.2239 15.0367C12.1705 15.0901 12.1069 15.1322 12.0368 15.1605C11.9668 15.1888 11.8918 15.2027 11.8162 15.2013C11.7407 15.2 11.6662 15.1835 11.5972 15.1527C11.5282 15.122 11.4661 15.0777 11.4146 15.0224L5.78964 9.39738Z"
            fill="#3289FA" />
        </svg>
        <div class="font-bold text-[#3289FA]">一覧画面に戻る</div>
      </a>
      <h5 class="text-xl font-bold sm:hidden">{{ $file->title }}</h5>
    </x-main.top>
    <div class="sm:flex sm:h-auto sm:min-h-[calc(100vh-100px)] sm:space-x-5">
      <div
        class="top-container mt-5 h-auto min-h-full w-full rounded-[10px] sm:mt-[13px] sm:min-w-[960px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
        <h5 class="hidden text-xl font-bold sm:block">{{ $file->title }}</h5>

        @if (str_contains($file->type, 'image'))
          <div
            class="sticky top-0 z-10 mt-5 h-[220px] w-full border-dashed bg-[#F7F9FA] sm:static sm:h-[450px] sm:rounded-lg sm:border">
            <img class="h-full w-full sm:rounded-lg" src="{{ route('manualFile.thumbnail', ['id' => $file->id]) }}" />
          </div>
        @elseif(str_contains($file->type, 'video'))
          <div
            class="sticky top-0 z-10 mt-5 h-[220px] w-full border-dashed bg-[#F7F9FA] sm:static sm:h-[450px] sm:rounded-lg sm:border">
            <video class="h-full w-full sm:rounded-lg" controls>
              <source src="{{ route('manualFile.movie', ['id' => $file->id]) }}" type="{{ $file->type }}">
              Your browser does not support the video tag.
            </video>
          </div>
        @endif

        @if (!empty($file->details))
          <div class="mt-5 border border-[#DDDDDD] sm:rounded-lg">
            @foreach ($file->details as $detail)
              <div @class([
                  'flex h-10 items-center bg-[#F7F7F7] px-5 text-sm font-bold',
                  'border-t' => !$loop->first,
                  'border-b' => !$loop->last,
              ])>{{ $detail['title'] }}</div>
              <textarea class="auto-resize w-full resize-none border-none p-5 text-[15px]">{{ $detail['content'] }}</textarea>
            @endforeach
          </div>
        @endif

        <div class="sm:hidden">
          <div class="procedure-container">
            @if (!empty($file->steps))
              <div class="procedure-rows">
                @foreach ($file->steps as $index => $step)
                  <div class="procedure-row">
                    <div class="marker">
                      <div class="circle">{{ $index + 1 }}</div>
                    </div>
                    <div class="procedure-box-general">
                      <div class="procedure-box-title">
                        <h4>{{ $step['title'] }}</h4>
                      </div>
                      <div class="form-area-general">
                        <textarea class="auto-resize-textarea h-0 border-none bg-[#F7F7F7]">{{ $step['content'] }}</textarea>
                        @if ($step['file'])
                          <img class="h-auto max-w-full rounded-lg"
                            src="{{ route('manualFile.step', ['id' => $file->id, 'index' => $index]) }}" />
                        @endif
                      </div>
                    </div>
                  </div>
                @endforeach
              </div>
            @endif
          </div>
        </div>
      </div>
      <div
        class="top-container mt-[20px] hidden h-auto min-h-full w-full rounded-[10px] sm:mt-[13px] sm:block sm:min-w-[320px] sm:bg-white sm:p-[20px] sm:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
        <h5 class="hidden text-xl font-bold sm:block">業務手順</h5>
        <div class="procedure-container">
          @if (!empty($file->steps))
            <div class="procedure-rows">
              @foreach ($file->steps as $index => $step)
                <div class="procedure-row">
                  <div class="marker">
                    <div class="circle">{{ $index + 1 }}</div>
                  </div>
                  <div class="procedure-box-general">
                    <div class="procedure-box-title">
                      <h4>{{ $step['title'] }}</h4>
                    </div>
                    <div class="form-area-general">
                      <textarea class="auto-resize-textarea h-0 border-none bg-[#F7F7F7]">{{ $step['content'] }}</textarea>
                      @if ($step['file'])
                        <img class="max-h-[200px] w-auto rounded-lg object-contain"
                          src="{{ route('manualFile.step', ['id' => $file->id, 'index' => $index]) }}" />
                      @endif
                    </div>
                  </div>
                </div>
              @endforeach
            </div>
          @endif
        </div>
      </div>

    </div>
    <script>
      document.querySelectorAll('.auto-resize').forEach(el => {
        el.style.height = el.scrollHeight + 'px';
        el.addEventListener('input', e => {
          e.target.style.height = 'auto';
          e.target.style.height = e.target.scrollHeight + 'px';
        });
      });

      document.querySelectorAll('.auto-resize-textarea').forEach(el => {
        el.style.height = el.scrollHeight + 'px';
        el.addEventListener('textarea', e => {
          e.target.style.height = 'auto';
          e.target.style.height = e.target.scrollHeight + 'px';
        });
      });
    </script>
  </x-main.index>
</x-app-layout>
