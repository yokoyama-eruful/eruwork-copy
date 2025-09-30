<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Modules\Manual\Models\ManualFile;
use Modules\Manual\Models\ManualFolder;

class ManualFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($id)
    {
        $folder = ManualFolder::find($id);
        $files = ManualFile::where('status', '掲載')->where('manual__folder_id', $folder->id)->get();

        return view('manual::general.file.index', ['folder' => $folder, 'files' => $files]);
    }

    public function show($folderId, $fileId)
    {
        $folder = ManualFolder::find($folderId);

        $file = ManualFile::find($fileId);

        return view('manual::general.file.show', ['folder' => $folder, 'file' => $file]);
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
