<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class ManualFileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $folder = ManualFolder::findOrFail($id);
        $files = $folder->files()->where('status', '掲載')->paginate(10);

        return view('manual::admin.file.index', ['folder' => $folder, 'files' => $files]);
    }

    public function create($id)
    {
        $folder = ManualFolder::findOrFail($id);

        return view('manual::admin.file.create', ['folder' => $folder]);
    }

    public function edit($folderId, $fileId)
    {
        $folder = ManualFolder::findOrFail($folderId);
        $file = ManualFile::findOrFail($fileId);

        return view('manual::admin.file.edit', ['file' => $file]);
    }

    public function draft()
    {
        $files = ManualFile::where('status', '下書き')->get();

        return view('manual::admin.file.draft', ['files' => $files]);
    }

    public function thumbnail($id)
    {
        $file = ManualFile::findOrFail($id);
        $path = $file->thumbnail_path;

        if (! $path || ! Storage::exists($path)) {
            abort(404);
        }

        return response()->file(Storage::path($path));
    }

    public function movie($id)
    {
        $file = ManualFile::findOrFail($id);
        $path = $file->movie_path;

        if (! $path || ! Storage::exists($path)) {
            abort(404);
        }

        return response()->file(Storage::path($path));
    }

    public function step($id, $index)
    {
        $file = ManualFile::findOrFail($id);
        $step = $file->steps[$index]['file'] ?? null;

        if (! $step || ! Storage::exists($step)) {
            abort(404);
        }

        return response()->file(Storage::path($step));
    }
}
