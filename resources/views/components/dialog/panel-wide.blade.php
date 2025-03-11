<template x-teleport="body">
  <div class="fixed inset-0 z-10 mx-auto max-w-full overflow-y-auto pt-24 text-left sm:pt-0" x-dialog>
    <!-- Overlay -->
    <div class="fixed inset-0 bg-black/25" x-dialog:overlay x-transition:enter.opacity></div>

    <!-- Panel -->
    <div class="relative flex min-h-full items-end justify-center p-0 sm:items-center sm:p-4">
      <div class="relative w-full max-w-xl overflow-hidden rounded-t-xl bg-white shadow-lg sm:rounded-b-xl"
        x-dialog:panel x-transition.in>
        <!-- Mobile: Top "grab" handle... -->
        <div class="absolute left-0 right-0 top-[-10px] h-[50px] sm:hidden" x-data="{ startY: 0, currentY: 0, moving: false, get distance() { return this.moving ? Math.max(0, this.currentY - this.startY) : 0 } }"
          x-on:touchstart="moving = true; startY = currentY = $event.touches[0].clientY"
          x-on:touchmove="currentY = $event.touches[0].clientY"
          x-on:touchend="if (distance > 100) dialogTemplate=false; moving = false;"
          x-effect="$el.parentElement.style.transform = 'translateY('+distance+'px)'">
          <div class="flex justify-center pt-[12px]">
            <div class="h-[5px] w-[10%] rounded-full bg-gray-400"></div>
          </div>
        </div>

        <!-- Close Button -->
        <div class="absolute right-0 top-0 pr-4 pt-4">
          <button
            class="rounded-lg bg-gray-100 p-2 text-gray-600 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
            type="button" x-on:click="dialogTemplate=false">
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
</template>
