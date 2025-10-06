<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    public string $type;

    public string $message;

    public bool $shake;

    /**
     * Create a new component instance.
     */
    public function __construct(string $type = 'success', string $message = '', bool $shake = false)
    {
        $this->type = $type;
        $this->message = $message;
        $this->shake = $shake;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.alert');
    }
}
