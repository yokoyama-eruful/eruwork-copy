<!--
@if ($paginator->hasPages())
<nav class="flex items-center justify-between" role="navigation" aria-label="{{ __('Pagination Navigation') }}">
    <div class="flex flex-1 justify-between sm:hidden">
      @if ($paginator->onFirstPage())
<span
class="relative inline-flex cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500">
          {!! __('pagination.previous') !!}
        </span>
@else
<a class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700" href="{{ $paginator->previousPageUrl() }}">
          {!! __('pagination.previous') !!}
        </a>
@endif

      @if ($paginator->hasMorePages())
<a class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700" href="{{ $paginator->nextPageUrl() }}">
          {!! __('pagination.next') !!}
        </a>
@else
<span
class="relative ml-3 inline-flex cursor-default items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500">
          {!! __('pagination.next') !!}
        </span>
@endif
    </div>

    <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
      <div class="flex items-center space-x-2">
        <div class="flex items-center">
          <p class="text-xs leading-none">{{ $paginator->count() }}</p>
          <p class="ml-1 text-[9px] leading-none">件表示</p>
        </div>
        <div class="text-[8px] text-[#343434]">/</div>
        <div class="flex items-center text-[#343434]">
          <p class="text-xs leading-none">{{ $paginator->total() }}</p>
          <p class="ml-1 text-[9px] leading-none">件中</p>
        </div>
      </div>

      <div>
        <span class="relative z-0 inline-flex rounded-md shadow-sm rtl:flex-row-reverse">
          {{-- Previous Page Link --}}
          @if ($paginator->onFirstPage())
<span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
              <span
class="relative inline-flex cursor-default items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500" aria-hidden="true">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
                </svg>
              </span>
            </span>
@else
<a class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500" href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('pagination.previous') }}" rel="prev">
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
              </svg>
            </a>
@endif

          {{-- Pagination Elements --}}
          @foreach ($elements as $element)
{{-- "Three Dots" Separator --}}
            @if (is_string($element))
<span aria-disabled="true">
                <span
class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700">{{ $element }}</span>
              </span>
@endif

            {{-- Array Of Links --}}
            @if (is_array($element))
@foreach ($element as $page => $url)
@if ($page == $paginator->currentPage())
<span aria-current="page">
                    <span
class="relative -ml-px inline-flex cursor-default items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-500">{{ $page }}</span>
                  </span>
@else
<a class="relative -ml-px inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium leading-5 text-gray-700 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700" href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                    {{ $page }}
                  </a>
@endif
@endforeach
@endif
@endforeach

          {{-- Next Page Link --}}
          @if ($paginator->hasMorePages())
<a class="relative -ml-px inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500" href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" rel="next">
              <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
              </svg>
            </a>
@else
<span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
              <span
class="relative -ml-px inline-flex cursor-default items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium leading-5 text-gray-500" aria-hidden="true">
                <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
              </span>
            </span>
@endif
        </span>
      </div>
    </div>
  </nav>
@endif
-->

@if ($paginator->hasPages())
  <div class="mt-[7px]">
    <div class="flex items-center space-x-2">
      <div class="flex items-center">
        <p class="text-xs leading-none">{{ $paginator->count() }}</p>
        <p class="ml-1 text-[9px] leading-none">件表示</p>
      </div>
      <div class="text-[8px] text-[#343434]">/</div>
      <div class="flex items-center text-[#343434]">
        <p class="text-xs leading-none">{{ $paginator->total() }}</p>
        <p class="ml-1 text-[9px] leading-none">件中</p>
      </div>
    </div>
  </div>
  <div class="mt-[8px] flex items-center justify-center">
    @if ($paginator->onFirstPage())
      <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
        <span
          class="relative inline-flex cursor-default items-center rounded-l-md px-2 py-2 text-sm font-medium leading-5 text-gray-500"
          aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M5.79013 8.60261C5.68479 8.70808 5.62562 8.85105 5.62562 9.00011C5.62562 9.14918 5.68479 9.29214 5.79013 9.39761L11.4151 15.0226C11.5218 15.122 11.6628 15.1761 11.8085 15.1735C11.9542 15.1709 12.0933 15.1119 12.1963 15.0088C12.2994 14.9058 12.3584 14.7667 12.361 14.621C12.3636 14.4753 12.3095 14.3342 12.2101 14.2276L6.98263 9.00011L12.2101 3.77261C12.2654 3.72112 12.3097 3.65902 12.3405 3.59002C12.3712 3.52102 12.3877 3.44653 12.3891 3.37101C12.3904 3.29548 12.3765 3.22046 12.3482 3.15042C12.3199 3.08037 12.2778 3.01675 12.2244 2.96334C12.171 2.90992 12.1074 2.86781 12.0373 2.83952C11.9673 2.81123 11.8923 2.79734 11.8167 2.79867C11.7412 2.8 11.6667 2.81653 11.5977 2.84728C11.5287 2.87802 11.4666 2.92235 11.4151 2.97761L5.79013 8.60261Z"
              fill="#3289FA" />
          </svg>

        </span>
      </span>
    @else
      <a class="relative inline-flex items-center rounded-l-md px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
        href="{{ $paginator->previousPageUrl() }}" aria-label="{{ __('pagination.previous') }}" rel="prev">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M5.79013 8.60261C5.68479 8.70808 5.62562 8.85105 5.62562 9.00011C5.62562 9.14918 5.68479 9.29214 5.79013 9.39761L11.4151 15.0226C11.5218 15.122 11.6628 15.1761 11.8085 15.1735C11.9542 15.1709 12.0933 15.1119 12.1963 15.0088C12.2994 14.9058 12.3584 14.7667 12.361 14.621C12.3636 14.4753 12.3095 14.3342 12.2101 14.2276L6.98263 9.00011L12.2101 3.77261C12.2654 3.72112 12.3097 3.65902 12.3405 3.59002C12.3712 3.52102 12.3877 3.44653 12.3891 3.37101C12.3904 3.29548 12.3765 3.22046 12.3482 3.15042C12.3199 3.08037 12.2778 3.01675 12.2244 2.96334C12.171 2.90992 12.1074 2.86781 12.0373 2.83952C11.9673 2.81123 11.8923 2.79734 11.8167 2.79867C11.7412 2.8 11.6667 2.81653 11.5977 2.84728C11.5287 2.87802 11.4666 2.92235 11.4151 2.97761L5.79013 8.60261Z"
            fill="#3289FA" />
        </svg>
      </a>
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
            <a class="relative -ml-px inline-flex items-center px-4 py-2 text-sm font-medium leading-5 text-[#343434] ring-gray-300 transition duration-150 ease-in-out hover:text-gray-500 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-700"
              href="{{ $url }}" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
              {{ $page }}
            </a>
          @endif
        @endforeach
      @endif
    @endforeach

    @if ($paginator->hasMorePages())
      <a class="relative -ml-px inline-flex items-center rounded-r-md px-2 py-2 text-sm font-medium leading-5 text-gray-500 ring-gray-300 transition duration-150 ease-in-out hover:text-gray-400 focus:z-10 focus:border-blue-300 focus:outline-none focus:ring active:bg-gray-100 active:text-gray-500"
        href="{{ $paginator->nextPageUrl() }}" aria-label="{{ __('pagination.next') }}" rel="next">
        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path fill-rule="evenodd" clip-rule="evenodd"
            d="M12.2099 8.60261C12.3152 8.70808 12.3744 8.85105 12.3744 9.00011C12.3744 9.14918 12.3152 9.29214 12.2099 9.39761L6.58487 15.0226C6.47824 15.122 6.33721 15.1761 6.19148 15.1735C6.04575 15.1709 5.90671 15.1119 5.80365 15.0088C5.70059 14.9058 5.64156 14.7667 5.63899 14.621C5.63642 14.4753 5.69051 14.3342 5.78987 14.2276L11.0174 9.00011L5.78987 3.77261C5.73461 3.72112 5.69028 3.65902 5.65953 3.59002C5.62879 3.52102 5.61226 3.44653 5.61093 3.37101C5.60959 3.29548 5.62349 3.22046 5.65178 3.15042C5.68007 3.08037 5.72218 3.01675 5.77559 2.96334C5.82901 2.90992 5.89263 2.86781 5.96267 2.83952C6.03271 2.81123 6.10773 2.79734 6.18326 2.79867C6.25879 2.8 6.33327 2.81653 6.40227 2.84728C6.47127 2.87802 6.53337 2.92235 6.58487 2.97761L12.2099 8.60261Z"
            fill="#3289FA" />
        </svg>

      </a>
    @else
      <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
        <span
          class="relative -ml-px inline-flex cursor-default items-center rounded-r-md px-2 py-2 text-sm font-medium leading-5 text-gray-500"
          aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path fill-rule="evenodd" clip-rule="evenodd"
              d="M12.2099 8.60261C12.3152 8.70808 12.3744 8.85105 12.3744 9.00011C12.3744 9.14918 12.3152 9.29214 12.2099 9.39761L6.58487 15.0226C6.47824 15.122 6.33721 15.1761 6.19148 15.1735C6.04575 15.1709 5.90671 15.1119 5.80365 15.0088C5.70059 14.9058 5.64156 14.7667 5.63899 14.621C5.63642 14.4753 5.69051 14.3342 5.78987 14.2276L11.0174 9.00011L5.78987 3.77261C5.73461 3.72112 5.69028 3.65902 5.65953 3.59002C5.62879 3.52102 5.61226 3.44653 5.61093 3.37101C5.60959 3.29548 5.62349 3.22046 5.65178 3.15042C5.68007 3.08037 5.72218 3.01675 5.77559 2.96334C5.82901 2.90992 5.89263 2.86781 5.96267 2.83952C6.03271 2.81123 6.10773 2.79734 6.18326 2.79867C6.25879 2.8 6.33327 2.81653 6.40227 2.84728C6.47127 2.87802 6.53337 2.92235 6.58487 2.97761L12.2099 8.60261Z"
              fill="#3289FA" />
          </svg>
        </span>
      </span>
    @endif
  </div>
@endif
