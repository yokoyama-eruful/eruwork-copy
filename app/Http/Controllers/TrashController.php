<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Tenant\Requests\DestroyRequest;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class TrashController extends Controller
{
    public function index()
    {
        $tenants = Tenant::whereNotNull('deleted_at')->paginate(12);

        return view('central.trash.index', ['tenants' => $tenants]);
    }

    public function restore($id)
    {
        Tenant::find($id)->update(['deleted_at' => null]);

        $tenants = Tenant::whereNotNull('deleted_at')->paginate(12);

        return redirect()->route('central.trash.index', ['tenants' => $tenants]);
    }

    public function delete(DestroyRequest $request, $id)
    {
        $tenant = Tenant::find($id);

        $tenant->delete();

        File::deleteDirectory(storage_path() . '/tenants/' . $id);

        $tenants = Tenant::paginate(12);

        return redirect()->route('central.home', ['tenants' => $tenants]);
    }

    public function search(Request $request)
    {
        $word = $request->input('word');

        $tenants = Tenant::NotNull('deleted_at')->where('name', 'LIKE', '%' . $word . '%')->paginate(12);

        return view('central.trash.index', ['tenants' => $tenants]);
    }
}
