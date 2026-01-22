@if ($paginator->hasPages())
  <nav class="mt-[8px] flex items-center justify-center" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
      <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
        <span
          class="relative inline-flex cursor-default items-center rounded-l-md px-2 py-2 text-sm font-medium leading-5 text-gray-400"
          aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.79013 8.60261C5.68479 8.70808 5.62562 8.85105 5.62562 9.00011C5.62562 9.14918 5.68479 9.29214 5.79013 9.39761L11.4151 15.0226C11.5218 15.122 11.6628 15.1761 11.8085 15.1735C11.9542 15.1709 12.0933 15.1119 12.1963 15.0088C12.2994 14.9058 12.3584 14.7667 12.361 14.621C12.3636 14.4753 12.3095 14.3342 12.2101 14.2276L6.98263 9.00011L12.2101 3.77261C12.2654 3.72112 12.3097 3.65902 12.3405 3.59002C12.3712 3.52102 12.3877 3.44653 12.3891 3.37101C12.3904 3.29548 12.3765 3.22046 12.3482 3.15042C12.3199 3.08037 12.2778 3.01675 12.2244 2.96334C12.171 2.90992 12.1074 2.86781 12.0373 2.83952C11.9673 2.81123 11.8923 2.79734 11.8167 2.79867C11.7412 2.8 11.6667 2.81653 11.5977 2.84728C11.5287 2.87802 11.4666 2.92235 11.4151 2.97761L5.79013 8.60261Z"
              fill="#AAB0B6" />
          </svg>
        </span>
      </span>
    @else
      <button
        class="relative inline-flex items-center rounded-l-md px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:outline-none active:bg-gray-100"
        type="button" aria-label="{{ __('pagination.previous') }}" wire:click="previousPage"
        wire:loading.attr="disabled" rel="prev">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.79013 8.60261C5.68479 8.70808 5.62562 8.85105 5.62562 9.00011C5.62562 9.14918 5.68479 9.29214 5.79013 9.39761L11.4151 15.0226C11.5218 15.122 11.6628 15.1761 11.8085 15.1735C11.9542 15.1709 12.0933 15.1119 12.1963 15.0088C12.2994 14.9058 12.3584 14.7667 12.361 14.621C12.3636 14.4753 12.3095 14.3342 12.2101 14.2276L6.98263 9.00011L12.2101 3.77261C12.2654 3.72112 12.3097 3.65902 12.3405 3.59002C12.3712 3.52102 12.3877 3.44653 12.3891 3.37101C12.3904 3.29548 12.3765 3.22046 12.3482 3.15042C12.3199 3.08037 12.2778 3.01675 12.2244 2.96334C12.171 2.90992 12.1074 2.86781 12.0373 2.83952C11.9673 2.81123 11.8923 2.79734 11.8167 2.79867C11.7412 2.8 11.6667 2.81653 11.5977 2.84728C11.5287 2.87802 11.4666 2.92235 11.4151 2.97761L5.79013 8.60261Z"
            fill="#3289FA" />
        </svg>
      </button>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
      {{-- "Three Dots" Separator --}}
      @if (is_string($element))
        <span aria-disabled="true">
          <span
            class="relative -ml-px inline-flex cursor-default items-center px-4 py-2 text-sm font-medium leading-5 text-gray-700">{{ $element }}</span>
        </span>
      @endif

      {{-- Array Of Links --}}
      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <span aria-current="page">
              <span
                class="relative -ml-px inline-flex cursor-default items-center px-4 py-2 text-sm font-bold leading-5 text-[#3289FA]">{{ $page }}</span>
            </span>
          @else
            <button
              class="relative -ml-px inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-[#343434] transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:outline-none active:bg-gray-100"
              type="button" aria-label="{{ __('Go to page :page', ['page' => $page]) }}"
              wire:click="gotoPage({{ $page }})" wire:loading.attr="disabled">
              {{ $page }}
            </button>
          @endif
        @endforeach
      @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
      <button
        class="relative -ml-px inline-flex items-center rounded-r-md px-2 py-2 text-sm font-medium leading-5 text-gray-500 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:outline-none active:bg-gray-100"
        type="button" aria-label="{{ __('pagination.next') }}" wire:click="nextPage" wire:loading.attr="disabled"
        rel="next">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M12.2099 8.60261C12.3152 8.70808 12.3744 8.85105 12.3744 9.00011C12.3744 9.14918 12.3152 9.29214 12.2099 9.39761L6.58487 15.0226C6.47824 15.122 6.33721 15.1761 6.19148 15.1735C6.04575 15.1709 5.90671 15.1119 5.80365 15.0088C5.70059 14.9058 5.64156 14.7667 5.63899 14.621C5.63642 14.4753 5.69051 14.3342 5.78987 14.2276L11.0174 9.00011L5.78987 3.77261C5.73461 3.72112 5.69028 3.65902 5.65953 3.59002C5.62879 3.52102 5.61226 3.44653 5.61093 3.37101C5.60959 3.29548 5.62349 3.22046 5.65178 3.15042C5.68007 3.08037 5.72218 3.01675 5.77559 2.96334C5.82901 2.90992 5.89263 2.86781 5.96267 2.83952C6.03271 2.81123 6.10773 2.79734 6.18326 2.79867C6.25879 2.8 6.33327 2.81653 6.40227 2.84728C6.47127 2.87802 6.53337 2.92235 6.58487 2.97761L12.2099 8.60261Z"
            fill="#3289FA" />
        </svg>
      </button>
    @else
      <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
        <span
          class="relative -ml-px inline-flex cursor-default items-center rounded-r-md px-2 py-2 text-sm font-medium leading-5 text-gray-400"
          aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M12.2099 8.60261C12.3152 8.70808 12.3744 8.85105 12.3744 9.00011C12.3744 9.14918 12.3152 9.29214 12.2099 9.39761L6.58487 15.0226C6.47824 15.122 6.33721 15.1761 6.19148 15.1735C6.04575 15.1709 5.90671 15.1119 5.80365 15.0088C5.70059 14.9058 5.64156 14.7667 5.63899 14.621C5.63642 14.4753 5.69051 14.3342 5.78987 14.2276L11.0174 9.00011L5.78987 3.77261C5.73461 3.72112 5.69028 3.65902 5.65953 3.59002C5.62879 3.52102 5.61226 3.44653 5.61093 3.37101C5.60959 3.29548 5.62349 3.22046 5.65178 3.15042C5.68007 3.08037 5.72218 3.01675 5.77559 2.96334C5.82901 2.90992 5.89263 2.86781 5.96267 2.83952C6.03271 2.81123 6.10773 2.79734 6.18326 2.79867C6.25879 2.8 6.33327 2.81653 6.40227 2.84728C6.47127 2.87802 6.53337 2.92235 6.58487 2.97761L12.2099 8.60261Z"
              fill="#AAB0B6" />
          </svg>
        </span>
      </span>
    @endif
  </nav>
@endif
