<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DashboardCard extends Component
{
    /**
     * Create a new component instance.
     */

    public $value, $label, $text, $color, $icon;

    public function __construct($value, $label, $text, $color, $icon)
    {
        $this->value = $value;
        $this->label = $label;
        $this->text = $text;
        $this->color = $color;
        $this->icon = $icon;
    }


    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.dashboard-card');
    }
}
