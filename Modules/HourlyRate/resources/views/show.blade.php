<x-dashboard-layout :url="route('hourlyRate.index')">
  <x-dashboard.index>
    <x-dashboard.container>
      <livewire:hourlyrate::hourly-rate-show :$selectedUser />
    </x-dashboard.container>
  </x-dashboard.index>
</x-dashboard-layout>
