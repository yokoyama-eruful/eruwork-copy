<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
  <div class="mx-4 w-full rounded-lg bg-white p-6 shadow-md" @click.away="openModal = false">
    <div class="mb-6 flex flex-wrap justify-between">
      <p class="text-xl font-semibold">{{ $selectedDate->format('Y.m.d') }}</p>
      <div class="bg-white">
        <button @click="openModal = false">閉じる</button>
      </div>
    </div>

    <div class="mb-4">
      <div class="mb-2 flex items-center justify-between">
        <label class="font-medium">勤務時間</label>
        <button class="rounded bg-blue-500 px-2 py-1 text-sm font-bold text-white hover:bg-blue-700" id="addWorkTime"
          type="button" wire:click="addWorkTime">追加</button>
      </div>
      <div class="rounded bg-gray-100 p-2" id="workTimesContainer">
        @forelse ($workTimeForm->workTimes as $key => $workTime)
          <div class="mb-2 flex items-center rounded-lg border border-gray-300 bg-white p-3 shadow-sm hover:bg-sky-100"
            wire:key="{{ $key }}">
            <div class="flex w-full items-center space-x-4">
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700" for="in-time-{{ $workTime->id }}">開始時刻</label>
                <input
                  class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring-2 focus:ring-sky-500"
                  id="in-time-{{ $workTime->id }}" type="time" value="{{ $workTime->inTime }}"
                  wire:model="workTimeForm.workTimes.{{ $key }}.inTime">
              </div>
              <span class="mt-3 self-center text-gray-700">～</span>
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700" for="out-time-{{ $workTime->id }}">終了時刻</label>
                <input
                  class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring-2 focus:ring-sky-500"
                  id="out-time-{{ $workTime->id }}" type="time" value="{{ $workTime->outTime }}"
                  wire:model="workTimeForm.workTimes.{{ $key }}.outTime">
              </div>
              <button class="removeTime ml-3 self-center text-gray-500"
                wire:click="removeWorkTime('{{ $key }}')">
                <i class="fa-solid fa-xmark" type="button"></i>
              </button>
            </div>
          </div>
        @empty
          <div class="flex items-center justify-center rounded-lg border border-gray-300 bg-white p-4 text-gray-500">
            記録なし
          </div>
        @endforelse
      </div>
    </div>

    <div class="mb-6">
      <div class="mb-2 flex items-center justify-between">
        <label class="font-medium">休憩時間</label>
        <button class="rounded bg-blue-500 px-2 py-1 text-sm font-bold text-white hover:bg-blue-700" id="addBreakTime"
          type="button" wire:click="addBreakTime">追加</button>
      </div>
      <div class="rounded bg-gray-100 p-2" id="breakTimesContainer">
        @forelse ($breakTimeForm->breakTimes as $key => $breakTime)
          <div class="mb-2 flex items-center rounded-lg border border-gray-300 bg-white p-3 shadow-sm hover:bg-sky-100"
            wire:key="{{ $key }}">
            <div class="flex w-full items-center space-x-4">
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700" for="in-time-{{ $breakTime->id }}">開始時刻</label>
                <input
                  class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring-2 focus:ring-sky-500"
                  id="in-time-{{ $breakTime->id }}" type="time" value="{{ $breakTime->inTime }}"
                  wire:model="breakTimeForm.breakTimes.{{ $key }}.inTime">
              </div>
              <span class="mt-3 self-center text-gray-700">～</span>
              <div class="flex-1">
                <label class="block text-sm font-medium text-gray-700" for="out-time-{{ $breakTime->id }}">終了時刻</label>
                <input
                  class="mt-1 block w-full rounded-md border-gray-300 p-2 shadow-sm focus:ring-2 focus:ring-sky-500"
                  id="out-time-{{ $breakTime->id }}" type="time" value="{{ $breakTime->outTime }}"
                  wire:model="breakTimeForm.breakTimes.{{ $key }}.outTime">
              </div>
              <button class="removeTime ml-3 self-center text-gray-500"
                wire:click="removeBreakTime('{{ $key }}')">
                <i class="fa-solid fa-xmark" type="button"></i>
              </button>
            </div>
          </div>
        @empty
          <div class="flex items-center justify-center rounded-lg border border-gray-300 bg-white p-4 text-gray-500">
            記録なし
          </div>
        @endforelse
      </div>
    </div>

    @foreach ($errors->all() as $error)
      <li class="text-red-500">{{ $error }}</li>
    @endforeach

    <button class="w-full rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700"
      wire:click='save'>更新</button>
  </div>
</div>
