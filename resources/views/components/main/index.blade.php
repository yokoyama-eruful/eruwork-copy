<main
  {{ $attributes->class('h-[calc(var(--vh)*100-50px)] lg:h-screen flex-1 overflow-y-auto overflow-x-hidden lg:bg-[#f4f4f4] bg-white lg:p-6') }}>
  {{ $slot }}
</main>
