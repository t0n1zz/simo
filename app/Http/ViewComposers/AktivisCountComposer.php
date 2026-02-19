<?php

namespace App\Http\ViewComposers;

use App\Models\Aktivis;
use Illuminate\View\View;

class AktivisCountComposer
{
    public function compose(View $view)
    {
        $aktivisCount = Aktivis::with('pekerjaan_aktif.cu')->whereHas('pekerjaan', function ($query) {
            $query->whereIn('tipe', [1, 3])->where('status', 1);
        })->count();

        $view->with('aktivisCount', $aktivisCount);
    }
}
