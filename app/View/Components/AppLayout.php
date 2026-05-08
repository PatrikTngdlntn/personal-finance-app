<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Prop title untuk judul halaman dinamis (Bug #14 Fix).
     */
    public function __construct(
        public string $title = 'Dashboard'
    ) {}

    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
