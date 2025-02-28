<?php

declare(strict_types=1);

namespace Modules\Board\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Board\Http\Requests\PostRequest;
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
     * Store a newly created resource in storage.
     */
    public function store(PostRequest $request)
    {
        $params = $request->params();
        $status = true;

        if ($request->input('action') == 'save') {
            $status = false;
        }

        $post = BoardPost::create(
            [
                'title' => $params['title'],
                'contents' => $params['contents'],
                'user_id' => Auth::id(),
                'status' => $status,
            ]
        );

        $users = User::get();
        $post->viewers()
            ->sync($users);

        $post->saveFiles($params['files']);

        return redirect()->route('board.index');
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
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $params = $request->params();

        $post = BoardPost::find($id);

        $status = true;

        if ($request->input('action') == 'save' && $post->status == false) {
            $status = false;
        }

        $post = BoardPost::updateOrCreate(
            ['id' => $id],
            [
                'title' => $params['title'],
                'contents' => $params['contents'],
                'user_id' => Auth::id(),
                'status' => $status,
            ]
        );

        $post->saveFiles($params['files']);

        return redirect()->route('board.index');
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
