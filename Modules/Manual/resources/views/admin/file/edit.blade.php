<x-dashboard-layout :url="route('manualFileManager.index', ['folder_id' => $file->folder->id])">
  <livewire:manual::admin.file.edit :file="$file" />
</x-dashboard-layout>
