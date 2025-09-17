@props(['name', 'show' => false, 'maxWidth' => '440', 'title' => ''])

@php
  $maxWidth = [
      'sm' => 'sm:max-w-sm',
      'md' => 'sm:max-w-md',
      'lg' => 'sm:max-w-lg',
      'xl' => 'sm:max-w-xl',
      '2xl' => 'sm:max-w-2xl',
      '350' => 'sm:max-w-[350px]',
      '440' => 'sm:max-w-[440px]',
  ][$maxWidth];
@endphp

<div class="fixed inset-0 z-50 overflow-y-auto px-4 py-6 sm:flex sm:items-center sm:justify-center sm:px-0"
  style="display: {{ $show ? 'block' : 'none' }};" x-data="{
      show: @js($show),
      focusables() {
          let selector = 'a, button, input:not([type=\'hidden\']), textarea, select, details, [tabindex]:not([tabindex=\'-1\'])'
          return [...$el.querySelectorAll(selector)]
              .filter(el => !el.hasAttribute('disabled'))
      },
      firstFocusable() { return this.focusables()[0] },
      lastFocusable() { return this.focusables().slice(-1)[0] },
      nextFocusable() { return this.focusables()[this.nextFocusableIndex()] || this.firstFocusable() },
      prevFocusable() { return this.focusables()[this.prevFocusableIndex()] || this.lastFocusable() },
      nextFocusableIndex() { return (this.focusables().indexOf(document.activeElement) + 1) % (this.focusables().length + 1) },
      prevFocusableIndex() { return Math.max(0, this.focusables().indexOf(document.activeElement)) - 1 },
  }" x-init="$watch('show', value => {
      if (value) {
          document.body.classList.add('overflow-y-hidden');
          {{ $attributes->has('focusable') ? 'setTimeout(() => firstFocusable().focus(), 100)' : '' }}
      } else {
          document.body.classList.remove('overflow-y-hidden');
      }
  })"
  x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
  x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null" x-on:close.stop="show = false"
  x-on:keydown.escape.window="show = false" x-on:keydown.tab.prevent="$event.shiftKey || nextFocusable().focus()"
  x-on:keydown.shift.tab.prevent="prevFocusable().focus()" x-show="show">
  <div class="fixed inset-0 transform transition-all" x-show="show" x-on:click="show = false"
    x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
    x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
  </div>

  <div class="{{ $maxWidth }} mb-6 transform overflow-hidden rounded-xl bg-white shadow-xl transition-all sm:w-full"
    x-show="show" x-transition:enter="ease-out duration-300"
    x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
    x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" x-transition:leave="ease-in duration-200"
    x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
    x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
    <div>
      <div class="flex items-center justify-between px-5 py-4">
        <p class="text-start text-base font-bold">{{ $title }}</p>
        <button class="hover:opacity-40" type="button" x-on:click="show = false">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M6 18L18 6M6 6L18 18" stroke="#5E5E5E" stroke-width="1.2" stroke-linecap="round"
              stroke-linejoin="round" />
          </svg>
        </button>
      </div>
      <hr class="border-t">
      <div class="bg-[#F7F7F7]">
        {{ $slot }}
      </div>
      @if (isset($footer))
        <div class="flex justify-center bg-white pb-5 pt-3">
          {{ $footer }}
        </div>
      @endif
    </div>
  </div>
</div>
