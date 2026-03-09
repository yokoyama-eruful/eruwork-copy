@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-bold text-[0.6875rem] mb-1']) }}>
  {{ $value ?? $slot }}
</label>
