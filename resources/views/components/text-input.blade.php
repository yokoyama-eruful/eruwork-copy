@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'border-[#DDDDDD] focus:border-indigo-500 focus:ring-indigo-500 rounded-lg mt-[7px]']) }}>
