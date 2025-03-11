<div x-data="{ menuOpen: false }">
  <div class="relative flex items-center" x-menu x-model="menuOpen">
    {{ $slot }}
  </div>
</div>
