<x-app-layout>
  <x-widget>
    <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4">
      <a class="scale-75" href="{{ url('manuals/desktop/manual.pdf') }}" target="_blank">
        <image class="h-auto w-auto rounded-md border border-gray-300 shadow-md hover:opacity-90"
          src="{{ url('manuals/desktop/thumbnail.png') }}">
          <div class="text-center text-xl underline">デスクトップ版</div>
      </a>
      <a class="scale-75" href="{{ url('manuals/mobile/manual.pdf') }}" target="_blank">
        <image class="h-auto w-auto rounded-md border border-gray-300 shadow-md hover:opacity-90"
          src="{{ url('manuals/mobile/thumbnail.png') }}">
          <div class="text-center text-xl underline">モバイル版</div>
      </a>
      @can('register')
        <a class="scale-75" href="{{ url('manuals/desktop-dash/manual.pdf') }}" target="_blank">
          <image class="h-auto w-auto rounded-md border border-gray-300 shadow-md hover:opacity-90"
            src="{{ url('manuals/desktop-dash/thumbnail.png') }}">
            <div class="text-center text-xl underline">デスクトップ版(管理者)</div>
        </a>
        <a class="scale-75" href="{{ url('manuals/mobile-dash/manual.pdf') }}" target="_blank">
          <image class="h-auto w-auto rounded-md border border-gray-300 shadow-md hover:opacity-90"
            src="{{ url('manuals/mobile-dash/thumbnail.png') }}">
            <div class="text-center text-xl underline">モバイル版(管理者)</div>
        </a>
      @endcan
    </div>
  </x-widget>
</x-app-layout>
