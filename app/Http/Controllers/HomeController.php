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

        $ua = $agent->getUserAgent();
        $isTablet = $agent->isTablet()
            || str_contains($ua, 'iPad')
            || (str_contains($ua, 'Macintosh'));

        if ($agent->isMobile() || $isTablet) {
            return view('home.mobile.index');
        }

        return view('home.desktop.index');
    }
}
