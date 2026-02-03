<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function show(Request $request)
    {
        $fileName = (string) $request->query('fileName', '');
        $groupId = (string) $request->query('groupId', '');

        if ($groupId === '' || ! ctype_digit($groupId)) {
            abort(404);
        }

        if ($fileName === '' || Str::contains($fileName, ['/', '\\'])) {
            abort(404);
        }

        $safeFileName = basename($fileName);
        $relativePath = 'chat/files/' . $groupId . '/' . $safeFileName;

        if (! Storage::exists($relativePath)) {
            abort(404);
        }

        return response()->file(Storage::path($relativePath));
    }
}
