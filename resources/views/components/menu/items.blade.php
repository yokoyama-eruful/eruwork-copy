<div class="z-10 w-48 divide-y divide-gray-100 rounded-md border border-gray-200 bg-white py-1 shadow-md outline-none"
  x-menu:items x-transition:enter.origin.top.right
  x-anchor.bottom-start="document.getElementById($id('alpine-menu-button'))" x-cloak>
  {{ $slot }}
</div>
