<?php

namespace App\Http\ViewComposers;

use App\Models\Cu;
use Illuminate\View\View;

class CuComposer
{
    public function compose(View $view)
    {
        $cuList = Cu::select('slug', 'name')->orderBy('no_ba')->get()->chunk(15);
        $view->with('cuList', $cuList);
    }
}
