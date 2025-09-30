<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;

class ProfileController extends Controller
{
    public function icon($id)
    {
        $user = User::find($id);

        return response()->file(storage_path('app/' . $user->icon));
    }
}
