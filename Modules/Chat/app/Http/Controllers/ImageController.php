<?php

declare(strict_types=1);

namespace Modules\Chat\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show(Request $request)
    {
        $fileName = $request->fileName;

        $filePath = storage_path('app/chat/files/' . $fileName);

        if (! file_exists($filePath)) {
            abort(404);
        }

        return response()->file($filePath);
    }
}
