<x-dashboard-layout :url="route('timecardManager.index')">
  <livewire:timecard::admin.timecard-show :user="$user" :date="$date" />
</x-dashboard-layout>
