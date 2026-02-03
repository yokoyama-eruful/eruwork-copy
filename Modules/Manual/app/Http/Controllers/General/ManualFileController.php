<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class ManualFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $folder = ManualFolder::findOrFail($id);
        $files = ManualFile::where('status', '掲載')
            ->where('manual__folder_id', $folder->id)
            ->paginate(10);

        return view('manual::general.file.index', ['folder' => $folder, 'files' => $files]);
    }

    public function show($folderId, $fileId)
    {
        $folder = ManualFolder::findOrFail($folderId);
        $file = ManualFile::findOrFail($fileId);

        return view('manual::general.file.show', ['folder' => $folder, 'file' => $file]);
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
