<?php

declare(strict_types=1);

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public $url;

    public function __construct($url = null)
    {
        $this->url = $url;
    }

    public function render(): View
    {
        return view('home.layouts.app');
    }
}
