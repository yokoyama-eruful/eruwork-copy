@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'border-[#DDDDDD] h-[42px] focus:border-indigo-500 focus:ring-indigo-500 rounded placeholder-[#222222] placeholder-opacity-30 text-sm']) }}>
