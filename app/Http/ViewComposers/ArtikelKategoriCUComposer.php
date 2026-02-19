<?php

namespace App\Http\ViewComposers;

use App\Models\Cu;
use App\Models\ArtikelKategori;
use Illuminate\View\View;
use Illuminate\Support\Facades\Route;

class ArtikelKategoriCUComposer
{
    public function compose(View $view)
    {
        $subdomain = Route::input('cu');

        if ($subdomain) {
            $cu = Cu::where('slug', $subdomain)->first();

            if ($cu) {
                $artikelKategoriList = ArtikelKategori::where('id_cu', $cu->id)->orderBy('name')->select('slug', 'name')->get();
                $view->with('artikelKategoriList', $artikelKategoriList);
            } else {
                 $view->with('artikelKategoriList', collect([]));
            }
        } else {
            $view->with('artikelKategoriList', collect([]));
        }
    }
}
