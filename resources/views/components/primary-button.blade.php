<button
  {{ $attributes->merge(['type' => 'submit', 'class' => 'h-11 w-[150px] flex items-center justify-center rounded text-sm font-bold bg-[#3289FA] text-white hover:opacity-40']) }}>
  {{ $slot }}
</button>
