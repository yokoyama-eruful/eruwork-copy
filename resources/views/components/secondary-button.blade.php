<button
  {{ $attributes->merge(['type' => 'button', 'class' => 'h-11 w-[150px] flex items-center justify-center outline outline-1 outline-[#5E5E5E] rounded text-sm font-bold hover:opacity-40']) }}>
  {{ $slot }}
</button>
