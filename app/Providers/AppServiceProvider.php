<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Http\ViewComposers\PengumumanBKCUComposer;
use App\Http\ViewComposers\ArtikelKategoriBKCUComposer;
use App\Http\ViewComposers\ArtikelKategoriCUComposer;
use App\Http\ViewComposers\CuComposer;
use App\Http\ViewComposers\PeriodeDiklatComposer;
use App\Http\ViewComposers\PengumumanCUComposer;
use App\Http\ViewComposers\DataGerakanComposer;
use App\Http\ViewComposers\CuCountComposer;
use App\Http\ViewComposers\AktivisCountComposer;
use App\Http\ViewComposers\ManajemenBKCUCountComposer;
use App\Http\ViewComposers\DataCuComposer;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer(
            ['index', 'layouts.index', 'cu.index', '_components.pengumumanBKCU'], 
            PengumumanBKCUComposer::class
        );

        View::composer(
            ['_layouts.header', '_layouts.footer'], 
            ArtikelKategoriBKCUComposer::class
        );

        View::composer(
            ['_layouts.headerCu', '_layouts.footerCu'], 
            ArtikelKategoriCUComposer::class
        );

        View::composer(
            ['_layouts.header'], 
            CuComposer::class
        );

        View::composer(
             ['_layouts.header'], 
             PeriodeDiklatComposer::class
        );

         View::composer(
             ['_components.pengumumanCU'], 
             PengumumanCUComposer::class
         );

         View::composer(
             ['_layouts.footer','profile'], 
             DataGerakanComposer::class
         );

         View::composer(
             ['_layouts.footer','profile'], 
             CuCountComposer::class
         );

         View::composer(
             ['_layouts.footer','profile'], 
             AktivisCountComposer::class
         );

         View::composer(
             ['_layouts.footer','profile'], 
             ManajemenBKCUCountComposer::class
         );

         View::composer(
             ['_layouts.footerCu'], 
             DataCuComposer::class
         );
    }
}
