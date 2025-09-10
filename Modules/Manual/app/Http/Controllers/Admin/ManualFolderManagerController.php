<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Manual\Models\ManualFolder;

class ManualFolderManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = ManualFolder::get();

        return view('manual::admin.folder.index', ['folders' => $folders]);
    }
}
