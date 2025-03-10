<button
  class="flex-grow rounded bg-ao-main px-6 py-2 text-center font-semibold text-white hover:bg-sky-700 disabled:cursor-not-allowed disabled:opacity-50"
  type="submit" x-on:click="dialogTemplate=false">
  {{ $slot }}
</button>
