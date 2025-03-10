<div class="flex flex-row items-center justify-center"class="relative mx-auto text-sm font-normal"
  x-data="{
      activeAccordion: 'false',
      id: $id('accordion'),
      setActiveAccordion(id) {
          this.activeAccordion = (this.activeAccordion == id) ? '' : id
      }
  }">
  <!-- アイコン -->
  <div
    class="flex h-8 w-8 items-center justify-center overflow-hidden rounded-full border border-gray-300 bg-gray-200 text-4xl text-gray-800">
    @if (Auth::user()->icon)
      <img class="h-full w-full" src="{{ Auth::user()->icon }}">
    @else
      <i class="fa-solid fa-user mt-2 text-2xl"></i>
    @endif
  </div>

  <!-- 名前 -->
  <div class="flex cursor-pointer flex-row text-center" @click="setActiveAccordion(id)">
    <h1 class="truncate px-1 text-lg text-white">{{ Auth::user()->name }}</h1>
    <button class="flex flex-row items-center space-x-2 text-white">
      <i class="fa-solid fa-caret-down"></i>
    </button>
  </div>

  {{-- <div class="absolute right-0 top-10 z-50 w-36 rounded-md border-2 bg-ao-sub text-left text-black"
    x-show="activeAccordion==id" x-collapse x-cloak>

    <x-setting.password />
    <x-setting.icon />
    <x-setting.notification />

    <x-setting.user-setting />
    <x-setting.logout />
  </div> --}}
  <div class="fixed right-8 top-[70px] z-50 h-auto w-96 rounded-2xl bg-slate-300 p-4" x-show="activeAccordion==id"
    x-collapse x-cloak @click.away="activeAccordion = ''">
    <div
      class="mx-auto mt-10 flex h-16 w-16 items-center justify-center overflow-hidden rounded-full border border-gray-300 bg-gray-200 text-4xl text-gray-800">
      @if (Auth::user()->icon)
        <img class="h-full w-full" src="{{ Auth::user()->icon }}">
      @else
        <i class="fa-solid fa-user mt-6 text-5xl"></i>
      @endif
    </div>
    <div class="mt-2 text-center text-lg">{{ Auth::user()->name }}</div>
    <div class="mt-4 flex w-full flex-col space-y-4">
      <x-setting.user-setting />
      <x-setting.logout />
    </div>
  </div>
</div>
