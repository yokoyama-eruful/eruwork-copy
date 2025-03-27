<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Modules\Shift\Models\Manager;

class ShiftManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = Manager::orderByDesc('start_date')->paginate(10);

        return view('shift::admin.index', ['managers' => $managers]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Manager $manager)
    {
        return view('shift::admin.show', ['manager' => $manager]);
    }

    public function destroy(Manager $manager)
    {
        $manager->delete();

        return to_route('shiftManager.index');
    }
}
