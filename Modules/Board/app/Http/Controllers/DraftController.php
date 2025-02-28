<?php

declare(strict_types=1);

namespace Modules\Board\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Modules\Board\Models\BoardPost;

class DraftController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BoardPost::where('user_id', Auth::id())
            ->Where('status', false)
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('draft::draft.index', ['posts' => $posts]);
    }
}
