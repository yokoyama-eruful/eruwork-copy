<?php

declare(strict_types=1);

namespace App\Http\Controllers\Timecard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\View\View;
use Modules\Timecard\Models\TimecardUser;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('timecard.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'pin' => ['required', 'digits:4'],
        ]);

        $user = TimecardUser::first();

        if (! $user) {
            return back()->withErrors([
                'pin' => '勤怠ユーザーが未設定です',
            ]);
        }

        if ($request->pin !== Crypt::decryptString($user->pin_encrypted)) {
            return back()->withErrors([
                'pin' => 'PINが違います',
            ]);
        }

        Auth::guard('timecard')->login($user);

        return redirect()->route('punch.index');
    }
}
