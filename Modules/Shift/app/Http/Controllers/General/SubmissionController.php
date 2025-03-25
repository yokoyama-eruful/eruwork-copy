<?php

declare(strict_types=1);

namespace Modules\Shift\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Modules\Shift\Models\Manager;

class SubmissionController extends Controller
{
    public function __invoke(Manager $manager)
    {
        return view('shift::general.submission.show', ['manager' => $manager]);
    }
}
