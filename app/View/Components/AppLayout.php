<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;
use Jenssegers\Agent\Agent;

class AppLayout extends Component
{
    public $url;

    public function __construct($url = null)
    {
        $this->url = $url;
    }

    public function render(): View
    {
        $agent = new Agent;

        $ua = $agent->getUserAgent();
        $isTablet = $agent->isTablet()
            || str_contains($ua, 'iPad')
            || (str_contains($ua, 'Macintosh'));

        return ($agent->isMobile() || $isTablet)
               ? view('home.mobile.layouts.app')
               : view('home.desktop.layouts.app');
    }
}
