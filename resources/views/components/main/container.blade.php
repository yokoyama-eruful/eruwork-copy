@props([
  'mobileTopMarginClass' => 'mt-[20px]',
  'mobileBottomMarginClass' => 'mb-[50px]',
])

@vite(['resources/css/container.css'])
<div
  class="top-container {{ $mobileBottomMarginClass }} {{ $mobileTopMarginClass }} w-full rounded-[10px] lg:mb-0 lg:mt-[13px] lg:bg-white lg:p-[20px] lg:shadow-[0_4px_13px_rgba(93,95,98,0.25)]">
  {{ $slot }}
</div>
