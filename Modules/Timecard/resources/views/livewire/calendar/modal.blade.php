<div class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
  <div class="w-full rounded-lg bg-white p-6 shadow-md">
    <div class="mb-6 text-center">
      <p class="text-xl font-semibold">2024年9月13日(金)</p>
      <div class="bg-white">
        <button wire:click="openModal = false">閉じる</button>
      </div>
    </div>

    <div class="mb-4">
      <div class="mb-2 flex items-center justify-between">
        <label class="font-medium">勤務時間</label>
        <button class="rounded bg-blue-500 px-2 py-1 text-sm font-bold text-white hover:bg-blue-700"
          id="addWorkTime">追加</button>
      </div>
      <div class="mb-2 rounded bg-gray-100 p-3" id="workTimesContainer">
        <div class="flex flex-wrap items-center justify-between">
          <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
          <span class="mb-2 sm:mb-0">～</span>
          <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
          <button class="removeTime mb-2 text-gray-500 sm:mb-0">×</button>
        </div>
      </div>
    </div>

    <div class="mb-6">
      <div class="mb-2 flex items-center justify-between">
        <label class="font-medium">休憩時間</label>
        <button class="rounded bg-blue-500 px-2 py-1 text-sm font-bold text-white hover:bg-blue-700"
          id="addBreakTime">追加</button>
      </div>
      <div class="mb-2 rounded bg-gray-100 p-3" id="breakTimesContainer">
        <div class="flex flex-wrap items-center justify-between">
          <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
          <span class="mb-2 sm:mb-0">～</span>
          <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
          <button class="removeTime mb-2 text-gray-500 sm:mb-0">×</button>
        </div>
      </div>
    </div>

    <button class="w-full rounded bg-blue-500 px-4 py-2 font-bold text-white hover:bg-blue-700">更新</button>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
    const addWorkTimeButton = document.getElementById('addWorkTime');
    const workTimesContainer = document.getElementById('workTimesContainer');
    const addBreakTimeButton = document.getElementById('addBreakTime');
    const breakTimesContainer = document.getElementById('breakTimesContainer');

    function createTimeDiv() {
      const newTimeDiv = document.createElement('div');
      newTimeDiv.className = 'flex flex-wrap items-center justify-between mt-2';
      newTimeDiv.innerHTML = `
                <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
                <span class="mb-2 sm:mb-0">～</span>
                <input class="mb-2 rounded border p-1 sm:mb-0" type="time">
                <button class="removeTime mb-2 text-gray-500 sm:mb-0">×</button>
            `;
      const removeButton = newTimeDiv.querySelector('.removeTime');
      removeButton.addEventListener('click', function() {
        newTimeDiv.remove();
      });
      return newTimeDiv;
    }

    addWorkTimeButton.addEventListener('click', function() {
      workTimesContainer.appendChild(createTimeDiv());
    });

    addBreakTimeButton.addEventListener('click', function() {
      breakTimesContainer.appendChild(createTimeDiv());
    });

    workTimesContainer.querySelectorAll('.removeTime').forEach(button => {
      button.addEventListener('click', function() {
        this.parentNode.remove();
      });
    });

    breakTimesContainer.querySelectorAll('.removeTime').forEach(button => {
      button.addEventListener('click', function() {
        this.parentNode.remove();
      });
    });
  });
</script>
