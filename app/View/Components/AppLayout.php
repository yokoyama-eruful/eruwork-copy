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

        return $agent->isMobile() || $agent->isTablet()
               ? view('home.mobile.layouts.app')
               : view('home.desktop.layouts.app');
    }
}
