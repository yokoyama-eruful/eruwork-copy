<x-dashboard-layout :url="route('manualFileManager.index', ['folder_id' => $folder->id])">
  <livewire:manual::admin.file.create :folder="$folder" />
</x-dashboard-layout>
