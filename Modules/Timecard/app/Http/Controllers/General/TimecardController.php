<?php

declare(strict_types=1);

namespace Modules\Timecard\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Auth;
use Modules\Timecard\Livewire\General\Dto\totalWorkingTimeDto;

class TimecardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('timecard::general.index');
    }

    public function show($date)
    {
        $selectedDate = CarbonImmutable::parse($date);

        $totalYearWorkingTime = totalWorkingTimeDto::year(Auth::user(), $selectedDate);

        $totalYearPay = totalWorkingTimeDto::yearPay(Auth::user(), $selectedDate);

        $barWidth = $this->barWidth($selectedDate);

        return view('timecard::general.show', ['selectedDate' => $selectedDate, 'totalYearWorkingTime' => $totalYearWorkingTime, 'barWidth' => $barWidth, 'totalYearPay' => $totalYearPay]);
    }

    private function barWidth($selectedDate)
    {
        $totalPay = totalWorkingTimeDto::yearPay(Auth::user(), $selectedDate);

        $barWidthLimit = 1750000;

        return min($totalPay / $barWidthLimit, 1) * 100 . '%';
    }
}
