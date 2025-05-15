<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class InputText extends Component
{
    public $type;
    public $name;
    public $id;
    public $value;
    public $placeholder;
    /**
     * Create a new component instance.
     */
    public function __construct(
        $type = 'text',
        $name = '',
        $id = '',
        $value = '',
        $placeholder = ''
    ) {
        $this->type = $type;
        $this->name = $name;
        $this->id = $id;
        $this->value = $value;
        $this->placeholder = $placeholder;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.input-text');
    }
}
