@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-[11px] mb-1']) }}>
  {{ $value ?? $slot }}
</label>
