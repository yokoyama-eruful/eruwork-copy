<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class ManualFileManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $folder = ManualFolder::find($id);
        $files = $folder->files->where('status', '掲載');

        return view('manual::admin.file.index', ['folder' => $folder, 'files' => $files]);
    }

    public function create($id)
    {
        $folder = ManualFolder::find($id);

        return view('manual::admin.file.create', ['folder' => $folder]);
    }

    public function edit($folderId, $fileId)
    {
        $folder = ManualFolder::find($folderId);
        $file = ManualFile::find($fileId);

        return view('manual::admin.file.edit', ['file' => $file]);
    }

    public function draft()
    {
        $files = ManualFile::where('status', '下書き')->get();

        return view('manual::admin.file.draft', ['files' => $files]);
    }

    public function thumbnail($id)
    {
        $file = ManualFile::find($id);

        return response()->file(storage_path('app/' . $file->thumbnail_path));
    }

    public function movie($id)
    {
        $file = ManualFile::find($id);

        return response()->file(storage_path('app/' . $file->movie_path));
    }

    public function step($id, $index)
    {
        $file = ManualFile::find($id);

        return response()->file(storage_path('app/' . $file->steps[$index]['file']));
    }
}
