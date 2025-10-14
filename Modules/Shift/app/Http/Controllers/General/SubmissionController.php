<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Modules\Shift\Models\Manager;

class SubmissionController extends Controller
{
    public function index()
    {
        $managers = Manager::where(function ($q) {
            $q->where('submission_start_date', '<', now())
                ->where('submission_end_date', '>', now());
        })
            ->orWhere(function ($q) {
                $q->where('submission_end_date', '<', now());
            })
            ->paginate(10);

        return view('shift::general.submission.index', ['managers' => $managers]);
    }

    public function show(Manager $manager)
    {
        return view('shift::general.submission.show', ['manager' => $manager]);
    }
}
