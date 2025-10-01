<x-app-layout :url="route('shift.submission.index')">
  @livewire('shift::general.submission-calendar', ['manager' => $manager])
</x-app-layout>
