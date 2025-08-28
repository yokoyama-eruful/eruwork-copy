@props(['value'])

<label {{ $attributes->merge(['class' => 'font-bold text-xs']) }}>
  {{ $value ?? $slot }}
</label>
