<x-dashboard-layout>
  <x-widget>
    <div class="flex flex-wrap items-center justify-between pb-2">
      <div class="flex flex-row items-center space-x-2 py-1">
        <div class="h-auto self-stretch border-l-4 border-hai-main"></div>
        <div class="text-lg font-bold">シフト管理</div>
      </div>
      <livewire:shift::admin.manager-create />
    </div>

    <table class="hidden min-w-full bg-white xl:table">
      <thead>
        <tr class="border-t-ao-dash border-t-4 bg-ao-sub text-left">
          <th class="px-4 py-2 text-left text-gray-600">シフト表期間</th>
          <th class="px-4 py-2 text-left text-gray-600">シフト受付期間</th>
          <th class="flex justify-center px-4 py-2 text-left text-gray-600">状　態</th>
          <th class="max-w-24 px-4 py-2 text-left text-gray-600"></th>
          <th class="max-w-24 px-4 py-2 text-left text-gray-600"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($managers as $manager)
          <tr class="border-b py-2">
            <td class="py-3 ps-5">
              <div class="text-lg">
                {{ $manager->start_date->isoFormat('YYYY年MM月DD日(ddd)') }}～{{ $manager->end_date->isoFormat('YYYY年MM月DD日(ddd)') }}
              </div>
            </td>
            <td class="py-3 ps-5">
              <div class="text-lg">
                {{ $manager->submission_start_date->isoFormat('YYYY年MM月DD日(ddd)') }}～{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日(ddd)') }}
              </div>
            </td>
            <td class="flex justify-center px-4 py-3">
              <div
                class="{{ $manager->ReceptionStatus == '受付中' ? 'bg-sky-400' : '' }} {{ $manager->ReceptionStatus == '受付終了' ? 'bg-rose-400' : '' }} {{ $manager->ReceptionStatus == '準備中' ? 'bg-emerald-400' : '' }} inline-block rounded-full p-2 px-4 text-white">
                {{ $manager->ReceptionStatus }}
              </div>
            </td>
            <td class="px-6 py-4 text-center">
              <a class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-ao-main hover:text-white"
                href="{{ route('shiftManager.show', ['manager' => $manager]) }}">
                表　示
              </a>
            </td>
            <td class="px-6 py-4 text-center">
              <form method="POST" action="{{ route('shiftManager.destroy', ['manager' => $manager]) }}">
                @csrf
                @method('delete')
                <button
                  class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-red-600 hover:text-white"
                  type="submit" onclick='return confirm("本当に削除しますか")'>
                  削除
                  <i class="fa-solid fa-trash me-1"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>

    <div class="block xl:hidden">
      @foreach ($managers as $manager)
        <div class="mb-2 flex flex-wrap justify-between rounded border p-2 shadow">
          <div>
            <div
              class="{{ $manager->ReceptionStatus == '受付中' ? 'bg-sky-400' : '' }} {{ $manager->ReceptionStatus == '受付終了' ? 'bg-rose-400' : '' }} {{ $manager->ReceptionStatus == '準備中' ? 'bg-emerald-400' : '' }} mb-2 inline-block rounded px-4 text-white">
              {{ $manager->ReceptionStatus }}
            </div>
            <div class="font-medium">シフト表期間</div>
            <div class="text-lg">
              {{ $manager->start_date->isoFormat('YYYY年MM月DD日(ddd)') }}～{{ $manager->end_date->isoFormat('YYYY年MM月DD日(ddd)') }}
            </div>
            <div class="pt-2 font-medium">シフト受付期間</div>
            <div class="text-lg">
              {{ $manager->submission_start_date->isoFormat('YYYY年MM月DD日(ddd)') }}～{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日(ddd)') }}
            </div>
          </div>
          <div class="flex flex-row items-end space-x-2">
            <a class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-ao-main hover:text-white"
              href="{{ route('shiftManager.show', ['manager' => $manager]) }}">
              表　示
            </a>
            <form method="POST" action="{{ route('shiftManager.destroy', ['manager' => $manager]) }}">
              @csrf
              @method('delete')
              <button
                class="inline-block rounded px-2 py-2 font-semibold text-hai-main hover:bg-red-600 hover:text-white"
                type="submit" onclick='return confirm("本当に削除しますか")'>
                削除
                <i class="fa-solid fa-trash me-1"></i>
              </button>
            </form>
          </div>
        </div>
      @endforeach
    </div>

    <div class="mt-4">
      {{ $managers->links('vendor.pagination.tailwind') }}
    </div>
  </x-widget>
</x-dashboard-layout>
