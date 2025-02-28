<?php

declare(strict_types=1);

namespace Modules\Manual\Http\Controllers;

use App\Http\Controllers\Controller;

class ManualController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('manual::index');
    }
}
