<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Tenant\DestroyRequest;
use App\Http\Requests\Tenant\UpdateRequest;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Throwable;

class ConsoleController extends Controller
{
    public function index()
    {
        $tenants = Tenant::whereNull('deleted_at')->paginate(12);

        return view('central.home.index', ['tenants' => $tenants]);
    }

    public function show($id)
    {
        $tenant = Tenant::find($id);

        $userCount = $tenant->run(function () {
            return User::count();
        });

        return view('central.home.show', ['tenant' => $tenant, 'userCount' => $userCount]);
    }

    public function create()
    {
        return view('central.home.create');
    }

    public function store(UpdateRequest $request)
    {
        while ($randomId = $this->generateRandomString(10)) {
            if (Tenant::where('id', $randomId)->doesntExist()) {
                break;
            }
        }

        try {
            $tenant = Tenant::create([
                'id' => $randomId,
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);
            $tenant->domains()->create(['domain' => $randomId . '.localhost']);
            session()->flash('success', 'スキーマを作成しました。');
        } catch (Throwable $e) {
            session()->flash('error', 'スキーマの作成に失敗しました。エラー: ' . $e->getMessage());
            $tenants = Tenant::paginate(12);

            return redirect()->route('central.home', ['tenants' => $tenants]);
        }

        $this->createStorage($randomId);

        $tenants = Tenant::paginate(12);

        return redirect()->route('central.home', ['tenants' => $tenants]);
    }

    public function edit($id)
    {
        $tenant = Tenant::find($id);

        return view('central.home.edit', ['tenant' => $tenant]);
    }

    public function update(UpdateRequest $request, $id)
    {
        $tenant = Tenant::find($id);

        try {
            $tenant->update([
                'name' => $request->name,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]);
            session()->flash('success', '編集しました。');
        } catch (Throwable $e) {
            session()->flash('error', '編集に失敗しました。エラー: ' . $e->getMessage());
        }

        $tenants = Tenant::paginate(12);

        return redirect()->route('central.home', ['tenants' => $tenants]);
    }

    public function delete(DestroyRequest $request, $id)
    {
        $tenant = Tenant::find($id);

        $tenant->update(['deleted_at' => now()]);

        $tenants = Tenant::paginate(12);

        return redirect()->route('central.home', ['tenants' => $tenants]);
    }

    public function search(Request $request)
    {
        $word = $request->input('word');

        $tenants = Tenant::whereNull('deleted_at')->where('name', 'LIKE', '%' . $word . '%')->paginate(12);

        return view('central.home.index', ['tenants' => $tenants]);
    }

    private function generateRandomString($length = 10)
    {
        $characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $charactersLength = mb_strlen($characters);
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }

        return $randomString;
    }

    private function createStorage($randomId)
    {
        $directoryPath = storage_path();
        File::makeDirectory($directoryPath . '/tenants/' . $randomId . '/app', 0755, true);
        File::makeDirectory($directoryPath . '/tenants/' . $randomId . '/framework/cache', 0755, true);
    }
}
