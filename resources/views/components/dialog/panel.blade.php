<div class="text-base">
  <div class="fixed inset-0 z-10 mx-auto w-auto overflow-y-auto pt-24 text-left sm:pt-0" style="display: none"
    x-show="dialogTemplate">
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/25"></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-end justify-center p-0 sm:items-center sm:p-4">
      <div class="relative w-full max-w-xl overflow-hidden rounded-t-xl bg-white shadow-lg sm:rounded-b-xl">
        <div class="flex h-10 w-full items-center justify-between bg-ao-main px-3 text-white">
          <div>{{ $title }}</div>

          <!-- Close Button -->
          <button class="hover:text-gray-400" type="button" x-on:click="dialogTemplate=false">
            <span class="sr-only">Close modal</span>
            <svg class="h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd"
                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                clip-rule="evenodd" />
            </svg>
          </button>
        </div>

        <!-- Panel -->
        <div class="p-8">
          {{ $slot }}
        </div>
      </div>
    </div>
  </div>
</div>
