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
        $files = $folder->files;

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
}
