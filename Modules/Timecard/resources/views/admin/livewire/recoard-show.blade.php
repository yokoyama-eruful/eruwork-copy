<div class="w-full bg-white" x-data="{
    selectAll: false,
    selectUsers: @entangle('selectUsers'),
    toggleAll() {
        this.selectUsers = this.selectAll ? @entangle('selectUsers') : [];
        @this.set('selectUsers', this.selectUsers);
    },
    submitForm() {
        if (this.selectUsers.length === 0) {
            alert('選択してください');
        } else {
            @this.call('downloadExcel');
        }
    }
}">
  <div class="flex w-full flex-row items-center justify-between space-x-2 border-b bg-white p-2 xl:hidden">
    <input class="js-datepicker w-32 rounded border border-gray-500 py-1" type="text" wire:model.live="startDate">
    ～
    <input class="js-datepicker w-32 rounded border border-gray-500 py-1" type="text" wire:model.live="endDate">
  </div>

  <div class="mt-2 flex flex-col xl:hidden">
    @foreach ($this->users as $user)
      <div class="mb-2 rounded border p-2 shadow">
        <div class="font-semibold">{{ $user->name }}</div>
        <div class="flex justify-between">
          <div>勤務時間:</div>
          <div>{{ $this->workingTime($user->id) }}</div>
        </div>
        <div class="flex justify-between">
          <div>支給額(勤怠時間×時給):</div>
          <div>{{ $this->getTotalPay($user->id) }}</div>
        </div>
        <div class="flex justify-between">
          <div>見　込(確定シフト×時給):</div>
          <div>{{ $this->prospectHourlyRate($user->id) }}</div>
        </div>
      </div>
    @endforeach
  </div>

  <form class="hidden flex-col xl:flex" @submit.prevent="submitForm">
    <div class="mb-1 flex justify-between">
      <div class="flex flex-row items-center space-x-2">
        <div class="font-medium">勤怠記録
        </div>
        <input class="js-datepicker rounded border border-gray-500 px-6 py-1" type="text"
          wire:model.live="startDate">
        <div>～</div>
        <input class="js-datepicker rounded border border-gray-500 px-6 py-1" type="text" wire:model.live="endDate">
      </div>
      <button class="bg-gray-200 px-2 hover:bg-gray-400" type="submit">
        ダウンロード<i class="fa-solid fa-download"></i>
      </button>
    </div>

    @error('selectUsers')
      <span class="text-xs text-red-500">{{ $message }}</span>
    @enderror

    <table class="bg-white">
      <thead class="border-t-ao-dash sticky top-0 z-10 border-t-4 bg-white text-left">
        <tr class="bg-ao-sub text-left">
          <th class="px-4 py-2 text-left text-gray-600">ユーザー名</th>
          <th class="px-4 py-2 text-left text-gray-600">勤怠時間</th>
          <th class="px-4 py-2 text-left text-gray-600">支給額(勤怠時間×時給)</th>
          <th class="px-4 py-2 text-left text-gray-600">見　込(確定シフト×時給)<p class="text-xs">※休憩を考慮しない</p>
          </th>
          <th class="flex items-center justify-center px-4 py-2 text-left text-gray-600">
            <button class="rounded bg-blue-300 px-4 py-2 hover:bg-blue-500" type="button"
              @click="selectAll = !selectAll; document.querySelectorAll('.checkbox').forEach(checkbox => checkbox.checked = selectAll); $wire.set('selectUsers', Array.from(document.querySelectorAll('.checkbox:checked')).map(checkbox => checkbox.value));">
              全選択
            </button>
          </th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->users as $user)
          <tr class="border-b py-2">
            <td class="py-2 ps-5">{{ $user->name }}</td>
            <td class="py-2 ps-5">{{ $this->workingTime($user->id) }}</td>
            <td class="py-2 ps-5">{{ $this->getTotalPay($user->id) }}</td>
            <td class="py-2 ps-5">{{ $this->prospectHourlyRate($user->id) }}</td>
            <td class="flex items-center justify-center py-2">
              <input class="checkbox h-7 w-7" type="checkbox" value="{{ $user->id }}" wire:model="selectUsers">
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

  </form>
</div>
