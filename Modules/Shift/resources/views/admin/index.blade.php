<x-dashboard-layout>
  <x-dashboard.index>
    <x-dashboard.top>
      <h5 class="block text-xl font-bold sm:hidden">シフト表管理</h5>
      <livewire:shift::admin.manager-create />
    </x-dashboard.top>
    <x-dashboard.container>
      <h5 class="hidden text-xl font-bold sm:block">シフト管理</h5>
      <div class="mt-[30px] hidden grid-cols-[10%,64%,14%,8%,4%] sm:grid">
        <div class="px-[30px] text-left text-xs font-normal text-[#AAB0B6]">ステータス</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">期間</div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]">受付終了日</div>
        <div class="text-center text-xs font-normal text-[#AAB0B6]"></div>
        <div class="text-left text-xs font-normal text-[#AAB0B6]"></div>
      </div>
      <div class="mt-[24px] rounded-lg border-b sm:-mx-0 sm:mt-[8px] sm:border">
        @foreach ($managers as $manager)
          <div @class([
              'sm:grid sm:grid-cols-[10%,64%,14%,8%,4%] sm:py-[30px] py-3 text-[15px] sm:px-0 px-5 cursor-pointer hidden',
              'border-b' => !$loop->last,
          ])>
            <div @class([
                'hidden truncate px-[12px] w-fit font-bold sm:block text-xs text-white mx-[30px] rounded-full py-1',
                'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                'bg-[#F76E80]' => $manager->ReceptionStatus === '受付終了',
                'bg-[#7F8E94]' => $manager->ReceptionStatus === '準備中',
            ])>
              {{ $manager->ReceptionStatus }}
            </div>

            <div class="text-[15px] font-bold">
              {{ $manager->start_date->isoFormat('YYYY年MM月DD日（ddd）') }}～{{ $manager->end_date->isoFormat('YYYY年MM月DD日（ddd）') }}
            </div>

            <div class="text-[15px]">{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日') }}</div>

            <a class="text-[#3289FA] hover:opacity-40"
              href="{{ route('shiftManager.show', ['manager' => $manager]) }}">表示する</a>

            <livewire:shift::admin.manager-delete :manager="$manager">
          </div>
        @endforeach
      </div>

      <div class="mt-[30px] block sm:hidden">
        <div class="mx-5 rounded-lg border">
          @foreach ($managers as $manager)
            <div @class(['py-5 px-[13px] cursor-pointer', 'border-b' => !$loop->last])
              onclick="window.location='{{ route('shiftManager.show', ['manager' => $manager]) }}'">
              <div class="flex items-center justify-between">
                <div @class([
                    'px-[15px] py-1 flex items-center justify-center rounded-full text-[10px] font-bold text-white',
                    'bg-[#F76E80]' => $manager->ReceptionStatus === '終了',
                    'bg-[#48CBFF]' => $manager->ReceptionStatus === '受付中',
                    'bg-[#39A338]' => $manager->ReceptionStatus === '準備中',
                ])>{{ $manager->ReceptionStatus }}</div>
                <div class="flex items-center space-x-[10px] text-xs">
                  <div class="text-[#AAB0B6]">受付終了日:</div>
                  <div>{{ $manager->submission_end_date->isoFormat('YYYY年MM月DD日') }}</div>
                </div>
              </div>
              <div class="mt-3 text-sm font-bold">
                {{ $manager->start_date->isoFormat('YYYY年MM月DD日（ddd）') }}　～　{{ $manager->end_date->isoFormat('YYYY年MM月DD日（ddd）') }}
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{ $managers->links('vendor.pagination.tailwind') }}
    </x-dashboard.container>
  </x-dashboard.index>

  {{-- <x-widget>
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
                class="{{ $manager->ReceptionStatus == '受付中' ? 'bg-sky-400' : '' }} {{ $manager->ReceptionStatus == '受付終了' ? 'bg-rose-400' : '' }} {{ $manager->ReceptionStatus == '準備中' ? 'bg-emerald-400' : '' }} inline-block rounded p-2 px-4 text-white">
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
  </x-widget> --}}
</x-dashboard-layout>
