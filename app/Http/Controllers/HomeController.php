<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class HomeController extends Controller
{
    public function index(): View
    {
        $agent = new Agent;

        if ($agent->isMobile() || $agent->isTablet()) {
            return view('home.mobile.index');
        }

        return view('home.desktop.index');
    }
}
