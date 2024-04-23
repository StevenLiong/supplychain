<?php

namespace App\View\Components;

use App\Models\produksi\StandardizeWork;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class DetailDry extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct(
        public $id,
        public $kategori
    ) {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $detail = StandardizeWork::with('dry_cast_resin')->where('kd_manhour', $this->id)->first();
        return view('components.detail-dry', ['detail' => $detail]);
    }
}