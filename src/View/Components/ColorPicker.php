<?php

namespace WireUi\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\View\Component;
use WireUi\Traits\Components\IsFormComponent;

class ColorPicker extends Component
{
    use IsFormComponent;

    public function __construct(
        public $rightIcon = 'swatch',
        public array|Collection $colors = [],
        public bool $colorNameAsValue = false,
    ) {
    }

    public function getColors(): array
    {
        return collect($this->colors)
            ->map(function (string|array $color, string|int $index) {
                if (is_array($color)) {
                    return $color;
                }

                if (is_numeric($index)) {
                    $index = $color;
                }

                return [
                    'name'  => $index,
                    'value' => $color,
                ];
            })
            ->values()
            ->toArray();
    }

    protected function blade(): View
    {
        return view('wireui::components.color-picker');
    }
}
