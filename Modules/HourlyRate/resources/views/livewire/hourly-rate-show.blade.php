<div class="min-w-84 h-full rounded-lg bg-white">
  <div class="h-[5%] font-bold">時給詳細</div>
  <div class="h-[95%] overflow-y-auto border-2 border-gray-300">
    <div class="flex items-center justify-between bg-gray-100 px-4 py-2">
      <div>{{ $user->name }}</div>
      <livewire:hourlyrate::hourly-rate-create :$user :key="$user->id" />
    </div>
    <table class="min-w-full bg-white">
      <thead>
        <tr class="border-t-4 text-left">
          <th class="px-4 py-2 text-left">時　給</th>
          <th class="px-4 py-2 text-left">適用開始日</th>
          <th class="max-w-24 px-4 py-2 text-left"></th>
        </tr>
      </thead>
      <tbody>
        @foreach ($this->rateTable as $hourlyRate)
          <tr class="border-b border-dotted border-gray-400">
            <td class="py-3 ps-5">{{ $hourlyRate->rate }}円</td>
            <td class="ps-5">{{ $hourlyRate->effective_date->format('Y年m月d日') }}</td>
            <td class="flex items-center justify-end px-4">
              <livewire:hourlyrate::hourly-rate-edit :$hourlyRate :key="$hourlyRate->id" />
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
