<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Modules\Manual\Models\ManualFolder;

class ManualFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $folders = ManualFolder::get();

        return view('manual::general.folder.index', ['folders' => $folders]);
    }
}
