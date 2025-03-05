<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Central\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function index(): View
    {
        return view('central.login');
    }

    /**
     * ログイン
     */
    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->only('login_id', 'password');

        if (Auth::guard('central')->attempt($credentials)) {
            return to_route('central.home');
        }

        return back()->withErrors([
            'error' => '認証情報が間違っています。',
        ])->onlyInput('login_id');
    }

    /**
     * ログアウト
     */
    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('central')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return to_route('central.index');
    }
}
