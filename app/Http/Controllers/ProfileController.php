<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Auth\UserSettingRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(UserSettingRequest $request): RedirectResponse
    {
        if ($request->icon) {
            $this->iconUpdate($request);
        }

        if ($request->current_password && $request->new_password) {
            $this->passwordUpdate($request);
        }

        return to_route('home');

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    private function iconUpdate($request)
    {
        $manager = new ImageManager(new Driver);

        $file = $request->file('icon');

        $filePath = $file->getRealPath();

        $image = $manager->read($filePath);

        $base64 = $image->resize(100, 100)->toPng()->toDataUri();

        Auth::user()->profile->update([
            'icon' => $base64,
        ]);
    }

    private function passwordUpdate($request)
    {
        $request->checkPassword();

        Auth::user()
            ->update([
                'password' => $request->new_password,
            ]);
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
