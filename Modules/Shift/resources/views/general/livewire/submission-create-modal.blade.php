<x-modal name="create-modal-{{ $day->format('Y-m-d') }}" title="シフト希望登録">
  <form wire:submit="save">
    @csrf

    @if ($errors->any())
      <div class="mb-4 rounded border border-red-300 bg-red-50 p-3 text-xs text-red-600">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="text-xl font-bold">
      {{ $day->format('Y.m.d') }}
    </div>

    <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-center">
      <x-input-label value="勤務時間" />
      <div class="flex items-center space-x-5">
        <div @class([
            'cursor-pointer rounded px-2 py-1 font-bold',
            'bg-[#3289FA1A] bg-opacity-10 text-[#3289FA]' => $item === 'time',
            'text-[#AAB0B6] hover:opacity-40' => $item !== 'time',
        ]) wire:click="changeItem('time')">
          時間指定</div>
        <div @class([
            'cursor-pointer rounded px-2 py-1 font-bold',
            'bg-[#3289FA1A] bg-opacity-10 text-[#3289FA]' => $item === 'pattern',
            'text-[#AAB0B6] hover:opacity-40' => $item !== 'pattern',
        ]) wire:click="changeItem('pattern')">
          パターン指定</div>
      </div>
    </div>

    @if ($item === 'time')
      <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-center">
        <x-input-label class="font-normal" value="時間設定" />
        <div class="flex w-full items-center space-x-1">
          <x-text-input class="flex-1" id="start_time_{{ $day->format('Ymd') }}" name="start_time" type="time"
            wire:model="form.startTime" />

          <div class="px-[10px]">〜</div>

          <x-text-input class="flex-1" id="end_time_{{ $day->format('Ymd') }}" name="end_time" type="time"
            wire:model="form.endTime" />
        </div>
      </div>
    @endif

    @if ($item === 'pattern')
      <div class="mr-[20px] mt-4 grid w-full grid-cols-[30%,70%] items-start">
        <x-input-label class="font-normal" value="パターン設定" />
        <div class="flex flex-col justify-center space-y-3">
          @forelse (Auth::user()->patterns as $pattern)
            @if (!is_null($pattern->start_time) && !is_null($pattern->end_time))
              <div class="flex items-center space-x-1">
                <label class="flex cursor-pointer items-center space-x-1">
                  <input name="pattern_id" type="radio"
                    wire:click="selectPattern('{{ $pattern->start_time->format('H:i') }}','{{ $pattern->end_time->format('H:i') }}')">
                  <span>{{ $pattern->start_time->format('H:i') }}~{{ $pattern->end_time->format('H:i') }}</span>
                </label>
              </div>
            @endif
          @endforeach
        </div>
      </div>
    @endif

    <div class="-mx-4 -mb-[30px] mt-[30px] flex items-center justify-center rounded-b bg-white py-4">
      <x-secondary-button x-on:click="$dispatch('close')">
        {{ __('Cancel') }}
      </x-secondary-button>

      <x-primary-button class="ms-3">
        登録
      </x-primary-button>
    </div>
  </form>
</x-modal>
