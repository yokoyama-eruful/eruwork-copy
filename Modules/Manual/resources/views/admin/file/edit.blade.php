@php
  $previousUrl = url()->previous();
  $targetUrl = Str::contains($previousUrl, 'draft')
      ? route('manualFileManager.draft')
      : route('manualFileManager.index', ['folder_id' => $file->folder->id]);
@endphp

<x-dashboard-layout :url="$targetUrl">
  <livewire:manual::admin.file.edit :file="$file" />
</x-dashboard-layout>
