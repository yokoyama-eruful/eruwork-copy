<?php

declare(strict_types=1);

namespace Modules\Board\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Board\Models\BoardAttachment;
use Modules\Board\Models\BoardPost;

class BoardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = BoardPost::paginate(10);

        return view('board::post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('board::post.create');
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $post = BoardPost::find($id);

        $post
            ->viewers()
            ->updateExistingPivot(Auth::id(), ['read_at' => now()]);

        return view('board::post.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $post = BoardPost::find($id);

        if (! $post->canEdit()) {
            return abort(302, 'アクセス権限がありません');
        }

        return view('board::post.edit', ['post' => $post]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $post = BoardPost::find($id);

        $attachments = $post->attachments;

        foreach ($attachments as $attachment) {
            Storage::delete($attachment->file_path);
        }

        $post->delete();

        return redirect()->route('board.index');
    }

    public function download($fileId): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        $file = BoardAttachment::find($fileId);

        if (! Storage::exists($file->file_path)) {
            abort(404);
        }

        $filePath = storage_path('app/' . $file->file_path);

        return response()->download($filePath, $file->file_name);
    }
}
