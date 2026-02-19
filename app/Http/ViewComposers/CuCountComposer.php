<?php

namespace App\Http\ViewComposers;

use App\Models\Cu;
use Illuminate\View\View;

class CuCountComposer
{
    public function compose(View $view)
    {
        $cuCount = Cu::count();
        $view->with('cuCount', $cuCount);
    }
}
