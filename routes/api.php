<?php

use Illuminate\Http\Request;
use App\Http\Controllers\AuthController;

Route::group(['middleware' => 'throttle:1000,1', 'withoutMiddleware' => 'throttle:api'], function () {
    //pemilihan
    Route::get('/pemilihan/indexCalon/{name}', 'App\\Http\\Controllers\\PemilihanController@indexCalon');
    Route::get('/pemilihan/indexCalonTerpilih/{id}', 'App\\Http\\Controllers\\PemilihanController@indexCalonTerpilih');
    Route::post('/pemilihan/storePilihan', 'App\\Http\\Controllers\\PemilihanController@storePilihan');
    Route::post('/pemilihan/storeMultiPilihan', 'App\\Http\\Controllers\\PemilihanController@storeMultiPilihan');

    //voting
    Route::get('/voting/indexPilihan/{name}', 'App\\Http\\Controllers\\VotingController@indexPilihan');
    Route::get('/voting/indexSuara/{id}', 'App\\Http\\Controllers\\VotingController@indexSuara');
    Route::post('/voting/storePilihan', 'App\\Http\\Controllers\\VotingController@storePilihan');
    
    //aset tetap
    Route::get('/asetTetap/get/{kode}', 'App\\Http\\Controllers\\AsetTetapController@get');
});

Route::group(['middleware' => 'throttle:200,1'], function () {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {

        // Route::group(['prefix'=>'v1'],function(){

        // auth
        // Route::get('/userId', 'App\\Http\\Controllers\\AuthController@userId');
        // Route::get('/profile', 'App\\Http\\Controllers\\AuthController@profile');

        // system
        Route::get('/system/version', 'App\\Http\\Controllers\\SystemController@version');

        // user
        Route::get('/user/indexActivity', 'App\\Http\\Controllers\\UserController@indexActivity');
        Route::get('/user/getActivity/{id}', 'App\\Http\\Controllers\\UserController@getActivity');
        Route::post('/user/updatePassword/{id}', 'App\\Http\\Controllers\\UserController@updatePassword');
        Route::post('/user/updateFoto/{id}', 'App\\Http\\Controllers\\UserController@updateFoto');
        Route::post('/user/updateIdentitas/{id}', 'App\\Http\\Controllers\\UserController@updateIdentitas');
        Route::get('/user/indexCuPermission/{id}', 'App\\Http\\Controllers\\UserController@indexCuPermission');

        Route::group(['middleware' => ['permission:index_user']], function () {
            Route::get('/user', 'App\\Http\\Controllers\\UserController@index');
            Route::get('/user/indexCu/{id}', 'App\\Http\\Controllers\\UserController@indexCu');
            Route::get('/user/count', 'App\\Http\\Controllers\\UserController@count');
        });
        Route::group(['middleware' => ['permission:create_user']], function () {
            Route::get('/user/create', 'App\\Http\\Controllers\\UserController@create');
            Route::post('/user/store', 'App\\Http\\Controllers\\UserController@store');
        });
        Route::group(['middleware' => ['permission:update_user']], function () {
            Route::get('/user/edit/{id}', 'App\\Http\\Controllers\\UserController@edit');
            Route::get('/user/editHakAkses/{id}', 'App\\Http\\Controllers\\UserController@editHakAkses');
            Route::post('/user/update/{id}', 'App\\Http\\Controllers\\UserController@update');
            Route::post('/user/updateStatus/{id}', 'App\\Http\\Controllers\\UserController@updateStatus');
            Route::post('/user/updateHakAkses/{id}', 'App\\Http\\Controllers\\UserController@updateHakAkses');
            Route::post('/user/updateResetPassword/{id}', 'App\\Http\\Controllers\\UserController@updateResetPassword');
        });
        Route::group(['middleware' => ['permission:destroy_user']], function () {
            Route::delete('/user/{id}', 'App\\Http\\Controllers\\UserController@destroy');
        });

        //media
        Route::get('/media/count', 'App\\Http\\Controllers\\MediaController@count');
        Route::get('/media/history', 'App\\Http\\Controllers\\MediaController@history');
        Route::group(['middleware' => ['permission:index_media']], function () {
            Route::get('/media', 'App\\Http\\Controllers\\MediaController@index');
            Route::get('/media/indexCu/{id}', 'App\\Http\\Controllers\\MediaController@indexCu');
        });
        Route::group(['middleware' => ['permission:create_media']], function () {
            Route::get('/media/create', 'App\\Http\\Controllers\\MediaController@create');
            Route::post('/media/store', 'App\\Http\\Controllers\\MediaController@store');
        });
        Route::group(['middleware' => ['permission:update_media']], function () {
            Route::get('/media/edit/{id}', 'App\\Http\\Controllers\\MediaController@edit');
            Route::post('/media/update/{id}', 'App\\Http\\Controllers\\MediaController@update');
        });
        Route::group(['middleware' => ['permission:destroy_media']], function () {
            Route::delete('/media/{id}', 'App\\Http\\Controllers\\MediaController@destroy');
        });

        //artikel
        Route::get('/artikel/count', 'App\\Http\\Controllers\\ArtikelController@count');
        Route::get('/artikel/history', 'App\\Http\\Controllers\\ArtikelController@history');
        Route::group(['middleware' => ['permission:index_artikel']], function () {
            Route::get('/artikel', 'App\\Http\\Controllers\\ArtikelController@index');
            Route::get('/artikel/indexCu/{id}', 'App\\Http\\Controllers\\ArtikelController@indexCu');
            Route::post('/artikel/upload', 'App\\Http\\Controllers\\ArtikelController@upload');
        });
        Route::group(['middleware' => ['permission:create_artikel']], function () {
            Route::get('/artikel/create', 'App\\Http\\Controllers\\ArtikelController@create');
            Route::post('/artikel/store', 'App\\Http\\Controllers\\ArtikelController@store');
        });
        Route::group(['middleware' => ['permission:update_artikel']], function () {
            Route::get('/artikel/edit/{id}', 'App\\Http\\Controllers\\ArtikelController@edit');
            Route::post('/artikel/update/{id}', 'App\\Http\\Controllers\\ArtikelController@update');
            Route::post('/artikel/updateTerbitkan/{id}', 'App\\Http\\Controllers\\ArtikelController@updateTerbitkan');
            Route::post('/artikel/updateUtamakan/{id}', 'App\\Http\\Controllers\\ArtikelController@updateUtamakan');
        });
        Route::group(['middleware' => ['permission:destroy_artikel']], function () {
            Route::delete('/artikel/{id}', 'App\\Http\\Controllers\\ArtikelController@destroy');
        });

        //artikel kategori
        Route::get('/artikelKategori/history', 'App\\Http\\Controllers\\ArtikelKategoriController@history');
        Route::group(['middleware' => ['permission:index_artikel_kategori']], function () {
            Route::get('/artikelKategori', 'App\\Http\\Controllers\\ArtikelKategoriController@index');
            Route::get('/artikelKategori/get', 'App\\Http\\Controllers\\ArtikelKategoriController@get');
            Route::get('/artikelKategori/indexCu/{id}', 'App\\Http\\Controllers\\ArtikelKategoriController@indexCu');
            Route::get('/artikelKategori/getCu/{id}', 'App\\Http\\Controllers\\ArtikelKategoriController@getCu');
        });
        Route::group(['middleware' => ['permission:create_artikel_kategori']], function () {
            Route::get('/artikelKategori/create', 'App\\Http\\Controllers\\ArtikelKategoriController@create');
            Route::post('/artikelKategori/store', 'App\\Http\\Controllers\\ArtikelKategoriController@store');
        });
        Route::group(['middleware' => ['permission:update_artikel_kategori']], function () {
            Route::get('/artikelKategori/edit/{id}', 'App\\Http\\Controllers\\ArtikelKategoriController@edit');
            Route::post('/artikelKategori/update/{id}', 'App\\Http\\Controllers\\ArtikelKategoriController@update');
        });
        Route::group(['middleware' => ['permission:destroy_artikel_kategori']], function () {
            Route::delete('/artikelKategori/{id}', 'App\\Http\\Controllers\\ArtikelKategoriController@destroy');
        });

        //artikel penulis
        Route::get('/artikelPenulis/count', 'App\\Http\\Controllers\\ArtikelPenulisController@count');
        Route::get('/artikelPenulis/history', 'App\\Http\\Controllers\\ArtikelPenulisController@history');
        Route::get('/artikelPenulis', 'App\\Http\\Controllers\\ArtikelPenulisController@index');
        Route::get('/artikelPenulis/get', 'App\\Http\\Controllers\\ArtikelPenulisController@get');
        Route::group(['middleware' => ['permission:index_artikel_penulis']], function () {
            Route::get('/artikelPenulis/indexCu/{id}', 'App\\Http\\Controllers\\ArtikelPenulisController@indexCu');
            Route::get('/artikelPenulis/getCu/{id}', 'App\\Http\\Controllers\\ArtikelPenulisController@getCu');
        });
        Route::group(['middleware' => ['permission:create_artikel_penulis']], function () {
            Route::get('/artikelPenulis/create', 'App\\Http\\Controllers\\ArtikelPenulisController@create');
            Route::post('/artikelPenulis/store', 'App\\Http\\Controllers\\ArtikelPenulisController@store');
        });
        Route::group(['middleware' => ['permission:update_artikel_penulis']], function () {
            Route::get('/artikelPenulis/edit/{id}', 'App\\Http\\Controllers\\ArtikelPenulisController@edit');
            Route::post('/artikelPenulis/update/{id}', 'App\\Http\\Controllers\\ArtikelPenulisController@update');
        });
        Route::group(['middleware' => ['permission:destroy_artikel_penulis']], function () {
            Route::delete('/artikelPenulis/{id}', 'App\\Http\\Controllers\\ArtikelPenulisController@destroy');
        });

        // artikel simo
        Route::get('/artikelSimo', 'App\\Http\\Controllers\\ArtikelSimoController@index');
        Route::get('/artikelSimo/get', 'App\\Http\\Controllers\\ArtikelSimoController@get');
        Route::post('/artikelSimo/upload', 'App\\Http\\Controllers\\ArtikelSimoController@upload');
        Route::get('/artikelSimo/count', 'App\\Http\\Controllers\\ArtikelSimoController@count');
        Route::get('/artikelSimo/history', 'App\\Http\\Controllers\\ArtikelSimoController@history');
        Route::group(['middleware' => ['permission:create_artikel']], function () {
            Route::get('/artikelSimo/create', 'App\\Http\\Controllers\\ArtikelSimoController@create');
            Route::post('/artikelSimo/store', 'App\\Http\\Controllers\\ArtikelSimoController@store');
        });
        Route::group(['middleware' => ['permission:update_artikel']], function () {
            Route::get('/artikelSimo/edit/{id}', 'App\\Http\\Controllers\\ArtikelSimoController@edit');
            Route::post('/artikelSimo/update/{id}', 'App\\Http\\Controllers\\ArtikelSimoController@update');
            Route::post('/artikelSimo/updateUtamakan/{id}', 'App\\Http\\Controllers\\ArtikelSimoController@updateUtamakan');
        });
        Route::group(['middleware' => ['permission:destroy_artikel']], function () {
            Route::delete('/artikelSimo/{id}', 'App\\Http\\Controllers\\ArtikelSimoController@destroy');
        });

        // cu
        Route::get('/cu/count', 'App\\Http\\Controllers\\CuController@count');
        Route::get('/cu/history', 'App\\Http\\Controllers\\CuController@history');
        Route::get('/cu/getHeader', 'App\\Http\\Controllers\\CuController@getHeader');
        Route::get('/cu/escete/{id}', 'App\\Http\\Controllers\\CuController@escete');
        Route::get('/cu/getUpdateESCETE', 'App\\Http\\Controllers\\CuController@getUpdateESCETE');
        Route::group(['middleware' => ['permission:index_cu']], function () {
            Route::get('/cu', 'App\\Http\\Controllers\\CuController@index');
            Route::get('/cu/deleted', 'App\\Http\\Controllers\\CuController@indexDeleted');
            Route::get('/cu/get', 'App\\Http\\Controllers\\CuController@get');
            Route::get('/cu/getPus/{id}', 'App\\Http\\Controllers\\CuController@getPus');
            Route::get('/cu/edit/{id}', 'App\\Http\\Controllers\\CuController@edit');
        });
        Route::group(['middleware' => ['permission:create_cu']], function () {
            Route::get('/cu/create', 'App\\Http\\Controllers\\CuController@create');
            Route::post('/cu/store', 'App\\Http\\Controllers\\CuController@store');
        });
        Route::group(['middleware' => ['permission:update_cu']], function () {
            Route::post('/cu/update/{id}', 'App\\Http\\Controllers\\CuController@update');
            Route::post('/cu/restore/{id}', 'App\\Http\\Controllers\\CuController@restore');
        });
        Route::group(['middleware' => ['permission:destroy_cu']], function () {
            Route::delete('/cu/{id}', 'App\\Http\\Controllers\\CuController@destroy');
        });
        Route::get('/cu/getBirthday', 'App\\Http\\Controllers\\CuController@getBirthday');

        // tp
        Route::get('/tp/count', 'App\\Http\\Controllers\\TpController@count');
        Route::get('/tp/history', 'App\\Http\\Controllers\\TpController@history');
        Route::get('/tp/getCu/{id}', 'App\\Http\\Controllers\\TpController@getCu');
        Route::group(['middleware' => ['permission:index_tp']], function () {
            Route::get('/tp', 'App\\Http\\Controllers\\TpController@index');
            Route::get('/tp/get', 'App\\Http\\Controllers\\TpController@get');
            Route::get('/tp/indexCu/{id}', 'App\\Http\\Controllers\\TpController@indexCu');
        });
        Route::group(['middleware' => ['permission:create_tp']], function () {
            Route::get('/tp/create', 'App\\Http\\Controllers\\TpController@create');
            Route::post('/tp/store', 'App\\Http\\Controllers\\TpController@store');
        });
        Route::group(['middleware' => ['permission:update_tp']], function () {
            Route::get('/tp/edit/{id}', 'App\\Http\\Controllers\\TpController@edit');
            Route::post('/tp/update/{id}', 'App\\Http\\Controllers\\TpController@update');
        });
        Route::group(['middleware' => ['permission:destroy_tp']], function () {
            Route::delete('/tp/{id}', 'App\\Http\\Controllers\\TpController@destroy');
        });

        // produk
        Route::get('/produkcu/getCu/{id}', 'App\\Http\\Controllers\\ProdukCuController@getCu');
        Route::get('/produkcu/getCuJalinan/{id}', 'App\\Http\\Controllers\\ProdukCuController@getCuJalinan');
        Route::get('/produkcu/getSimpananCu/{id}', 'App\\Http\\Controllers\\ProdukCuController@getSimpananCu');
        Route::get('/produkcu/getPinjamanCu/{id}', 'App\\Http\\Controllers\\ProdukCuController@getPinjamanCu');
        Route::get('/produkcu/count', 'App\\Http\\Controllers\\ProdukCuController@count');
        Route::get('/produkcu/history', 'App\\Http\\Controllers\\ProdukCuController@history');
        Route::group(['middleware' => ['permission:index_produk_cu']], function () {
            Route::get('/produkcu', 'App\\Http\\Controllers\\ProdukCuController@index');
            Route::get('/produkcu/get', 'App\\Http\\Controllers\\ProdukCuController@get');
            Route::get('/produkcu/indexCu/{id}', 'App\\Http\\Controllers\\ProdukCuController@indexCu');
        });
        Route::group(['middleware' => ['permission:create_produk_cu']], function () {
            Route::get('/produkcu/create', 'App\\Http\\Controllers\\ProdukCuController@create');
            Route::post('/produkcu/store', 'App\\Http\\Controllers\\ProdukCuController@store');
        });
        Route::group(['middleware' => ['permission:update_produk_cu']], function () {
            Route::get('/produkcu/edit/{id}', 'App\\Http\\Controllers\\ProdukCuController@edit');
            Route::post('/produkcu/update/{id}', 'App\\Http\\Controllers\\ProdukCuController@update');
        });
        Route::group(['middleware' => ['permission:destroy_produk_cu']], function () {
            Route::delete('/produkcu/{id}', 'App\\Http\\Controllers\\ProdukCuController@destroy');
        });

        //booking nomor sertifikat
        Route::post('/sertifikatKegiatan/uploadExcelPeserta', 'App\\Http\\Controllers\\SertifikatController@uploadExcelPeserta');
        Route::post('/sertifikatKegiatan/storeNomorSertifikatKegiatan/{id}', 'App\\Http\\Controllers\\SertifikatController@storeNomorSertifikatKegiatan');
        Route::get('/sertifikatKegiatan/index', 'App\\Http\\Controllers\\SertifikatController@indexNomorSertifikat');
        Route::post('/sertifikatKegiatan/updateNomorSertifikatKegiatan/{id}', 'App\\Http\\Controllers\\SertifikatController@updateNomorSertifikatKegiatan');
        Route::delete('/sertifikatKegiatan/destroyNomorSertifikatKegiatan/{id}', 'App\\Http\\Controllers\\SertifikatController@destroyNomorSertifikatKegiatan');

        // sertifikat kegiatan
        Route::get('/sertifikatKegiatan', 'App\\Http\\Controllers\\SertifikatController@index');
        Route::get('/sertifikatKegiatan/create', 'App\\Http\\Controllers\\SertifikatController@create');
        Route::post('/sertifikatKegiatan/store', 'App\\Http\\Controllers\\SertifikatController@store');
        Route::get('/sertifikatKegiatan/edit/{id}', 'App\\Http\\Controllers\\SertifikatController@edit');
        Route::get('/sertifikatKegiatan/editFormNomor/{id}', 'App\\Http\\Controllers\\SertifikatController@editFormNomor');
        Route::post('/sertifikatKegiatan/update/{id}', 'App\\Http\\Controllers\\SertifikatController@update');
        Route::delete('/sertifikatKegiatan/{id}', 'App\\Http\\Controllers\\SertifikatController@destroy');

        //generate sertifikat
        Route::post('/generateSertifikat', 'App\\Http\\Controllers\\SertifikatController@generateSertifikat');

        // kode kegiatan
        Route::get('/kodeKegiatan', 'App\\Http\\Controllers\\KodeKegiatanController@index');
        Route::get('/kodeKegiatan/get', 'App\\Http\\Controllers\\KodeKegiatanController@get');
        Route::get('/kodeKegiatan/create', 'App\\Http\\Controllers\\KodeKegiatanController@create');
        Route::post('/kodeKegiatan/store', 'App\\Http\\Controllers\\KodeKegiatanController@store');
        Route::get('/kodeKegiatan/edit/{id}', 'App\\Http\\Controllers\\KodeKegiatanController@edit');
        Route::post('/kodeKegiatan/update/{id}', 'App\\Http\\Controllers\\KodeKegiatanController@update');
        Route::delete('/kodeKegiatan/{id}', 'App\\Http\\Controllers\\KodeKegiatanController@destroy');

        // kegiatan bkcu
        Route::get('/kegiatanBKCU/index/{kegiatan_tipe}', 'App\\Http\\Controllers\\KegiatanBKCUController@index');
        Route::get('/kegiatanBKCU/baru', 'App\\Http\\Controllers\\KegiatanBKCUController@indexBaru');
        Route::get('/kegiatanBKCU/mulai', 'App\\Http\\Controllers\\KegiatanBKCUController@indexMulai');
        Route::get('/kegiatanBKCU/buka', 'App\\Http\\Controllers\\KegiatanBKCUController@indexBuka');
        Route::get('/kegiatanBKCU/jalan', 'App\\Http\\Controllers\\KegiatanBKCUController@indexJalan');
        Route::get('/kegiatanBKCU/diikuti', 'App\\Http\\Controllers\\KegiatanBKCUController@indexDiikuti');
        Route::get('/kegiatanBKCU/kegiatan', 'App\\Http\\Controllers\\KegiatanBKCUController@indexKegiatan');
        Route::get('/kegiatanBKCU/periode/{kegiatan_tipe}/{periode}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPeriode');
        Route::get('/kegiatanBKCU/indexPisah/{kegiatan_tipe}/{periode}/{status}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPisah');
        Route::get('/kegiatanBKCU/indexSemuaPeserta/{tipe_kegiatan}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaPeserta');
        Route::get('/kegiatanBKCU/indexSemuaPesertaMitra/{tipe_kegiatan}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaPesertaMitra');
        Route::get('/kegiatanBKCU/indexSemuaPesertaCu/{tipe_kegiatan}/cu/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaPesertaCu');
        Route::get('/kegiatanBKCU/indexSemuaPanitia', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaPanitia');
        Route::get('/kegiatanBKCU/indexSemuaPanitiaCu/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaPanitiaCu');
        Route::get('/kegiatanBKCU/indexSemuaFasilitator', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaFasilitator');
        Route::get('/kegiatanBKCU/indexSemuaFasilitatorCu/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexSemuaFasilitatorCu');
        Route::get('/kegiatanBKCU/indexPeserta/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPeserta');
        Route::get('/kegiatanBKCU/indexMateri/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexMateri');
        Route::get('/kegiatanBKCU/indexListMateri/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexListMateri');
        Route::get('/kegiatanBKCU/indexPanitia/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPanitia');
        Route::get('/kegiatanBKCU/indexNilaiListMateri/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexNilaiListMateri');
        Route::get('/kegiatanBKCU/indexKeputusan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexKeputusan');
        Route::get('/kegiatanBKCU/indexKeputusanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexKeputusanKomentar');
        Route::get('/kegiatanBKCU/indexPertanyaan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPertanyaan');
        Route::get('/kegiatanBKCU/indexPertanyaanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPertanyaanKomentar');
        Route::get('/kegiatanBKCU/indexTugas/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexTugas');
        Route::get('/kegiatanBKCU/indexTugasJawaban/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexTugasJawaban');
        Route::get('/kegiatanBKCU/indexPesertaHadir/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPesertahadir');
        Route::get('/kegiatanBKCU/indexPesertaCu/{id}/cu/{cu}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPesertaCu');
        Route::get('/kegiatanBKCU/indexPesertaCountCu/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPesertaCountCu');
        Route::get('/kegiatanBKCU/indexPesertaHadirCountCu/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPesertaHadirCountCu');
        Route::get('/kegiatanBKCU/indexKeputusanCount/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexKeputusanCount');
        Route::get('/kegiatanBKCU/indexPertanyaanCount/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@indexPertanyaanCount');
        Route::get('/kegiatanBKCU/getPeriode/{kegiatan_tipe}', 'App\\Http\\Controllers\\KegiatanBKCUController@getPeriode');
        Route::get('/kegiatanBKCU/edit/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@edit');
        Route::get('/kegiatanBKCU/checkPeserta/{kegiatan_id}/{aktivis_id}', 'App\\Http\\Controllers\\KegiatanBKCUController@checkPeserta');
        Route::get('/kegiatanBKCU/checkPanitia/{kegiatan_id}/{aktivis_id}', 'App\\Http\\Controllers\\KegiatanBKCUController@checkPanitia');
        Route::post('/kegiatanBKCU/getNomorSertifikat/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@getNomorSertifikat');
        Route::post('/kegiatanBKCU/updatePesertaHadir/{kegiatan_id}/{aktivis_id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updatePesertaHadir');
        Route::post('/kegiatanBKCU/updatePanitiaHadir/{kegiatan_id}/{aktivis_id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updatePanitiaHadir');
        Route::get('/kegiatanBKCU/countJalan', 'App\\Http\\Controllers\\KegiatanBKCUController@countJalan');
        Route::get('/kegiatanBKCU/countDiikuti', 'App\\Http\\Controllers\\KegiatanBKCUController@countDiikuti');
        Route::get('/kegiatanBKCU/countPeserta/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@countPeserta');
        Route::get('/kegiatanBKCU/countPesertaHadir/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@countPesertaHadir');
        Route::get('/kegiatanBKCU/countKeputusan/{id}/{cu}/{user}', 'App\\Http\\Controllers\\KegiatanBKCUController@countKeputusan');
        Route::post('/kegiatanBKCU/storeKeputusan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeKeputusan');
        Route::post('/kegiatanBKCU/updateKeputusan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateKeputusan');
        Route::delete('/kegiatanBKCU/destroyKeputusan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyKeputusan');
        Route::post('/kegiatanBKCU/storeKeputusanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeKeputusanKomentar');
        Route::post('/kegiatanBKCU/updateKeputusanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateKeputusanKomentar');
        Route::delete('/kegiatanBKCU/destroyKeputusanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyKeputusanKomentar');
        Route::get('/kegiatanBKCU/countPertanyaan/{id}/{cu}/{user}', 'App\\Http\\Controllers\\KegiatanBKCUController@countPertanyaan');
        Route::post('/kegiatanBKCU/storePertanyaan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storePertanyaan');
        Route::post('/kegiatanBKCU/updatePertanyaan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updatePertanyaan');
        Route::delete('/kegiatanBKCU/destroyPertanyaan/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyPertanyaan');
        Route::post('/kegiatanBKCU/storePertanyaanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storePertanyaanKomentar');
        Route::post('/kegiatanBKCU/updatePertanyaanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updatePertanyaanKomentar');
        Route::post('/kegiatanBKCU/jawabanPertanyaan/{id}/{tipe}', 'App\\Http\\Controllers\\KegiatanBKCUController@jawabanPertanyaan');
        Route::delete('/kegiatanBKCU/destroyPertanyaanKomentar/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyPertanyaanKomentar');
        Route::post('/kegiatanBKCU/storePeserta/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storePeserta');
        Route::post('/kegiatanBKCU/updatePeserta/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updatePeserta');
        Route::delete('/kegiatanBKCU/destroyPeserta/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyPeserta');
        Route::post('/kegiatanBKCU/batalPeserta/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@batalPeserta');
        Route::get('/kegiatanBKCU/create', 'App\\Http\\Controllers\\KegiatanBKCUController@create');
        Route::post('/kegiatanBKCU/store/{kegiatan_tipe}', 'App\\Http\\Controllers\\KegiatanBKCUController@store');
        Route::post('/kegiatanBKCU/update/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@update');
        Route::post('/kegiatanBKCU/updateStatus/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateStatus');
        Route::post('/kegiatanBKCU/storeMateri/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeMateri');
        Route::post('/kegiatanBKCU/updateMateri/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateMateri');
        Route::delete('/kegiatanBKCU/destroyMateri/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyMateri');
        Route::delete('/kegiatanBKCU/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroy');
        Route::post('/kegiatanBKCU/storeTugas/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeTugas');
        Route::post('/kegiatanBKCU/storeTugasJawaban/{kegiatan_tipe}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeTugasJawaban');
        Route::get('/kegiatanBKCU/editTugasJawaban/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@editTugasJawaban');
        Route::post('/kegiatanBKCU/updateTugas/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateTugas');
        Route::post('/kegiatanBKCU/updateTugasJawaban/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateTugasJawaban');
        Route::delete('/kegiatanBKCU/destroyTugas/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyTugas');
        Route::delete('/kegiatanBKCU/destroyTugasJawaban/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyTugasJawaban');
        Route::post('/kegiatanBKCU/penerimaSertifikat', 'App\\Http\\Controllers\\KegiatanBKCUController@PenerimaSertifikat');

        Route::post('/kegiatanBKCU/storeListMateri/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@storeListMateri');
        Route::get('/kegiatanBKCU/editNilai/{id}/{kegiatan_id}', 'App\\Http\\Controllers\\KegiatanBKCUController@editNilai');
        Route::post('/kegiatanBKCU/saveNilai/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@saveNilai');
        Route::post('/kegiatanBKCU/updateListMateri/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@updateListMateri');
        Route::delete('/kegiatanBKCU/destroyListMateri/{kegiatan_tipe}/{id}', 'App\\Http\\Controllers\\KegiatanBKCUController@destroyListMateri');

        // kegiatan rekom
        Route::get('/kegiatanRekom/history', 'App\\Http\\Controllers\\KegiatanRekomController@history');
        Route::get('/kegiatanRekom', 'App\\Http\\Controllers\\KegiatanRekomController@index');
        Route::get('/kegiatanRekom/get', 'App\\Http\\Controllers\\KegiatanRekomController@get');
        Route::get('/kegiatanRekom/indexKegiatan/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@indexKegiatan');
        Route::get('/kegiatanRekom/indexHasil/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@indexHasil');
        Route::get('/kegiatanRekom/create', 'App\\Http\\Controllers\\KegiatanRekomController@create');
        Route::post('/kegiatanRekom/store', 'App\\Http\\Controllers\\KegiatanRekomController@store');
        Route::get('/kegiatanRekom/edit/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@edit');
        Route::post('/kegiatanRekom/update/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@update');
        Route::delete('/kegiatanRekom/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@destroy');

        // kegiatan rekom hasil
        Route::post('/kegiatanRekom/storeHasil', 'App\\Http\\Controllers\\KegiatanRekomController@storeHasil');
        Route::post('/kegiatanRekom/updateHasil/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@updateHasil');
        Route::delete('/kegiatanRekom/destroyHasil/{id}', 'App\\Http\\Controllers\\KegiatanRekomController@destroyHasil');

        // aktivis
        Route::get('/aktivis/get/{id}', 'App\\Http\\Controllers\\AktivisController@get');
        Route::get('/aktivis/get_monitoring_cu/{id}', 'App\\Http\\Controllers\\AktivisController@get_monitoring_cu');
        Route::get('/aktivis/history', 'App\\Http\\Controllers\\AktivisController@history');
        Route::get('/aktivis/cariData/{nik}', 'App\\Http\\Controllers\\AktivisController@cariData');
        Route::get('/aktivis/count', 'App\\Http\\Controllers\\AktivisController@count');
        Route::get('/aktivis/edit/{id}', 'App\\Http\\Controllers\\AktivisController@edit');
        Route::post('/aktivis/update/{id}', 'App\\Http\\Controllers\\AktivisController@update');
        Route::get('/aktivis/indexPekerjaan/{id}', 'App\\Http\\Controllers\\AktivisController@indexPekerjaan');
        Route::get('/aktivis/indexPendidikan/{id}', 'App\\Http\\Controllers\\AktivisController@indexPendidikan');
        Route::get('/aktivis/indexAnggotaCu/{id}', 'App\\Http\\Controllers\\AktivisController@indexAnggotaCu');
        Route::get('/aktivis/indexKeluarga/{id}', 'App\\Http\\Controllers\\AktivisController@indexKeluarga');
        Route::get('/aktivis/indexOrganisasi/{id}', 'App\\Http\\Controllers\\AktivisController@indexOrganisasi');
        Route::get('/aktivis/indexDiklat/{id}', 'App\\Http\\Controllers\\AktivisController@indexDiklat');
        Route::get('/aktivis/indexPertemuan/{id}', 'App\\Http\\Controllers\\AktivisController@indexPertemuan');
        Route::get('/aktivis/indexKeterangan/{id}', 'App\\Http\\Controllers\\AktivisController@indexKeterangan');
        Route::get('/aktivis/createPekerjaan', 'App\\Http\\Controllers\\AktivisController@createPekerjaan');
        Route::get('/aktivis/createPendidikan', 'App\\Http\\Controllers\\AktivisController@createPendidikan');
        Route::get('/aktivis/createOrganisasi', 'App\\Http\\Controllers\\AktivisController@createOrganisasi');
        Route::get('/aktivis/createDiklat', 'App\\Http\\Controllers\\AktivisController@createDiklat');
        Route::get('/aktivis/createKeluarga', 'App\\Http\\Controllers\\AktivisController@createKeluarga');
        Route::get('/aktivis/createAnggotaCu', 'App\\Http\\Controllers\\AktivisController@createAnggotaCu');
        Route::post('/aktivis/savePekerjaan/{id}', 'App\\Http\\Controllers\\AktivisController@savePekerjaan');
        Route::post('/aktivis/savePendidikan/{id}', 'App\\Http\\Controllers\\AktivisController@savePendidikan');
        Route::post('/aktivis/saveOrganisasi/{id}', 'App\\Http\\Controllers\\AktivisController@saveOrganisasi');
        Route::post('/aktivis/saveDiklat/{id}', 'App\\Http\\Controllers\\AktivisController@saveDiklat');
        Route::post('/aktivis/saveKeluarga/{id}', 'App\\Http\\Controllers\\AktivisController@saveKeluarga');
        Route::post('/aktivis/saveAnggotaCu/{id}', 'App\\Http\\Controllers\\AktivisController@saveAnggotaCu');
        Route::delete('/aktivis/pekerjaan/{id}', 'App\\Http\\Controllers\\AktivisController@destroyPekerjaan');
        Route::delete('/aktivis/pendidikan/{id}', 'App\\Http\\Controllers\\AktivisController@destroyPendidikan');
        Route::delete('/aktivis/organisasi/{id}', 'App\\Http\\Controllers\\AktivisController@destroyOrganisasi');
        Route::delete('/aktivis/diklat/{id}', 'App\\Http\\Controllers\\AktivisController@destroyDiklat');
        Route::delete('/aktivis/keterangan/{id}', 'App\\Http\\Controllers\\AktivisController@destroyKeterangan');
        Route::post('/aktivis/saveKeterangan/{id}', 'App\\Http\\Controllers\\AktivisController@saveKeterangan');
        Route::delete('/aktivis/keluarga/{id}', 'App\\Http\\Controllers\\AktivisController@destroyKeluarga');
        Route::delete('/aktivis/anggotaCu/{id}', 'App\\Http\\Controllers\\AktivisController@destroyAnggotaCu');
        Route::get('/aktivis/index/{tingkat}/{status}', 'App\\Http\\Controllers\\AktivisController@index');
        Route::post('/aktivis/indexTingkat/', 'App\\Http\\Controllers\\AktivisController@indexTingkat');
        Route::get('/aktivis/indexLembaga', 'App\\Http\\Controllers\\AktivisController@indexLembaga');
        Route::get('/aktivis/indexCu/{id}/{tingkat}/{status}', 'App\\Http\\Controllers\\AktivisController@indexCu');
        Route::get('/aktivis/indexTingkatArr/{kegiatan_id}/{tingkat}', 'App\\Http\\Controllers\\AktivisController@indexTingkatArr');
        Route::get('/aktivis/indexCuTingkatArr/{kegiatan_id}/{id}/{tingkat}', 'App\\Http\\Controllers\\AktivisController@indexCuTingkatArr');
        // Route::group(['middleware' => ['permission:index_aktivis']], function () {
        // });
        Route::group(['middleware' => ['permission:create_aktivis']], function () {
            Route::get('/aktivis/create', 'App\\Http\\Controllers\\AktivisController@create');
            Route::post('/aktivis/store', 'App\\Http\\Controllers\\AktivisController@store');
        });
        Route::group(['middleware' => ['permission:update_aktivis']], function () {
            // nothing
        });
        Route::group(['middleware' => ['permission:destroy_aktivis']], function () {
            Route::delete('/aktivis/{id}', 'App\\Http\\Controllers\\AktivisController@destroy');
        });

        //aset tetap
        Route::get('/asetTetap/generate/{id}', 'App\\Http\\Controllers\\AsetTetapController@generate');
        Route::get('/asetTetap', 'App\\Http\\Controllers\\AsetTetapController@index');
        Route::get('/asetTetap/indexSelesai', 'App\\Http\\Controllers\\AsetTetapController@indexSelesai');
        Route::get('/asetTetap/indexHapus', 'App\\Http\\Controllers\\AsetTetapController@indexHapus');
        Route::get('/asetTetap/history', 'App\\Http\\Controllers\\AsetTetapController@history');
        Route::get('/asetTetap/indexSub/{id}', 'App\\Http\\Controllers\\AsetTetapController@indexSub');
        Route::group(['middleware' => ['permission:index_aset_tetap']], function () {
        });
        Route::group(['middleware' => ['permission:create_aset_tetap']], function () {
            Route::get('/asetTetap/create', 'App\\Http\\Controllers\\AsetTetapController@create');
            Route::post('/asetTetap/store', 'App\\Http\\Controllers\\AsetTetapController@store');
        });
        Route::group(['middleware' => ['permission:update_aset_tetap']], function () {
            Route::get('/asetTetap/edit/{id}', 'App\\Http\\Controllers\\AsetTetapController@edit');
            Route::post('/asetTetap/update/{id}', 'App\\Http\\Controllers\\AsetTetapController@update');
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap']], function () {
            Route::delete('/asetTetap/{id}', 'App\\Http\\Controllers\\AsetTetapController@destroy');
            Route::delete('/asetTetap/hapusDariLaporan/{id}', 'App\\Http\\Controllers\\AsetTetapController@hapusDariLaporan');
        });

        //aset tetap jenis
        Route::get('/asetTetapGolongan/get', 'App\\Http\\Controllers\\AsetTetapGolonganController@get');
        Route::get('/asetTetapKelompok/get/{id}', 'App\\Http\\Controllers\\AsetTetapKelompokController@get');
        Route::get('/asetTetapJenis/get/{id}', 'App\\Http\\Controllers\\AsetTetapJenisController@get');
        Route::group(['middleware' => ['permission:index_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan', 'App\\Http\\Controllers\\AsetTetapGolonganController@index');
            Route::get('/asetTetapKelompok', 'App\\Http\\Controllers\\AsetTetapKelompokController@index');
            Route::get('/asetTetapJenis', 'App\\Http\\Controllers\\AsetTetapJenisController@index');
        });
        Route::group(['middleware' => ['permission:create_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan/create', 'App\\Http\\Controllers\\AsetTetapGolonganController@create');
            Route::get('/asetTetapKelompok/create', 'App\\Http\\Controllers\\AsetTetapKelompokController@create');
            Route::get('/asetTetapJenis/create', 'App\\Http\\Controllers\\AsetTetapJenisController@create');
            Route::post('/asetTetapGolongan/store', 'App\\Http\\Controllers\\AsetTetapGolonganController@store');
            Route::post('/asetTetapKelompok/store', 'App\\Http\\Controllers\\AsetTetapKelompokController@store');
            Route::post('/asetTetapJenis/store', 'App\\Http\\Controllers\\AsetTetapJenisController@store');
        });
        Route::group(['middleware' => ['permission:update_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan/edit/{id}', 'App\\Http\\Controllers\\AsetTetapGolonganController@edit');
            Route::get('/asetTetapKelompok/edit/{id}', 'App\\Http\\Controllers\\AsetTetapKelompokController@edit');
            Route::get('/asetTetapJenis/edit/{id}', 'App\\Http\\Controllers\\AsetTetapJenisController@edit');
            Route::post('/asetTetapGolongan/update/{id}', 'App\\Http\\Controllers\\AsetTetapGolonganController@update');
            Route::post('/asetTetapKelompok/update/{id}', 'App\\Http\\Controllers\\AsetTetapKelompokController@update');
            Route::post('/asetTetapJenis/update/{id}', 'App\\Http\\Controllers\\AsetTetapJenisController@update');
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap_jenis']], function () {
            Route::delete('/asetTetapGolongan/{id}', 'App\\Http\\Controllers\\AsetTetapGolonganController@destroy');
            Route::delete('/asetTetapKelompok/{id}', 'App\\Http\\Controllers\\AsetTetapKelompokController@destroy');
            Route::delete('/asetTetapJenis/{id}', 'App\\Http\\Controllers\\AsetTetapJenisController@destroy');
        });

        //aset tetap lokasi
        Route::get('/asetTetapLokasi/get', 'App\\Http\\Controllers\\AsetTetapLokasiController@get');
        Route::group(['middleware' => ['permission:index_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi', 'App\\Http\\Controllers\\AsetTetapLokasiController@index');
        });
        Route::group(['middleware' => ['permission:create_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi/create', 'App\\Http\\Controllers\\AsetTetapLokasiController@create');
            Route::post('/asetTetapLokasi/store', 'App\\Http\\Controllers\\AsetTetapLokasiController@store');
        });
        Route::group(['middleware' => ['permission:update_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi/edit/{id}', 'App\\Http\\Controllers\\AsetTetapLokasiController@edit');
            Route::post('/asetTetapLokasi/update/{id}', 'App\\Http\\Controllers\\AsetTetapLokasiController@update');
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap_lokasi']], function () {
            Route::delete('/asetTetapLokasi/{id}', 'App\\Http\\Controllers\\AsetTetapLokasiController@destroy');
        });

        // surat
        Route::get('/surat/getPeriode/{cu}', 'App\\Http\\Controllers\\SuratController@getPeriode');
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/surat/indexCu/{cu}/tipe/{tipe}/periode/{periode}', 'App\\Http\\Controllers\\SuratController@indexCu');
            Route::get('/surat/getKode/{id}', 'App\\Http\\Controllers\\SuratController@getKode');
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/surat/create', 'App\\Http\\Controllers\\SuratController@create');
            Route::post('/surat/store', 'App\\Http\\Controllers\\SuratController@store');
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/surat/edit/{id}', 'App\\Http\\Controllers\\SuratController@edit');
            Route::post('/surat/update/{id}', 'App\\Http\\Controllers\\SuratController@update');
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/surat/{id}', 'App\\Http\\Controllers\\SuratController@destroy');
        });

        //surat kategori
        Route::get('/suratKategori/history', 'App\\Http\\Controllers\\SuratKategoriController@history');
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratKategori', 'App\\Http\\Controllers\\SuratKategoriController@index');
            Route::get('/suratKategori/get', 'App\\Http\\Controllers\\SuratKategoriController@get');
            Route::get('/suratKategori/indexCu/{id}', 'App\\Http\\Controllers\\SuratKategoriController@indexCu');
            Route::get('/suratKategori/getCu/{id}', 'App\\Http\\Controllers\\SuratKategoriController@getCu');
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratKategori/create', 'App\\Http\\Controllers\\SuratKategoriController@create');
            Route::post('/suratKategori/store', 'App\\Http\\Controllers\\SuratKategoriController@store');
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratKategori/edit/{id}', 'App\\Http\\Controllers\\SuratKategoriController@edit');
            Route::post('/suratKategori/update/{id}', 'App\\Http\\Controllers\\SuratKategoriController@update');
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratKategori/{id}', 'App\\Http\\Controllers\\SuratKategoriController@destroy');
        });

        //surat kode
        Route::get('/suratKode/history', 'App\\Http\\Controllers\\SuratKodeController@history');
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratKode', 'App\\Http\\Controllers\\SuratKodeController@index');
            Route::get('/suratKode/get', 'App\\Http\\Controllers\\SuratKodeController@get');
            Route::get('/suratKode/indexCu/{id}', 'App\\Http\\Controllers\\SuratKodeController@indexCu');
            Route::get('/suratKode/getCu/{id}', 'App\\Http\\Controllers\\SuratKodeController@getCu');
            Route::get('/suratKode/getTipe/{periode}', 'App\\Http\\Controllers\\SuratKodeController@getTipe');
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratKode/create', 'App\\Http\\Controllers\\SuratKodeController@create');
            Route::post('/suratKode/store', 'App\\Http\\Controllers\\SuratKodeController@store');
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratKode/edit/{id}', 'App\\Http\\Controllers\\SuratKodeController@edit');
            Route::post('/suratKode/update/{id}', 'App\\Http\\Controllers\\SuratKodeController@update');
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratKode/{id}', 'App\\Http\\Controllers\\SuratKodeController@destroy');
        });

        // surat masuk
        Route::get('/suratMasuk/getPeriode/{cu}', 'App\\Http\\Controllers\\SuratMasukController@getPeriode');
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratMasuk/indexCu/{cu}/{periode}', 'App\\Http\\Controllers\\SuratMasukController@indexCu');
            Route::get('/suratMasuk/getKode/{id}', 'App\\Http\\Controllers\\SuratMasukController@getKode');
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratMasuk/create', 'App\\Http\\Controllers\\SuratMasukController@create');
            Route::post('/suratMasuk/store', 'App\\Http\\Controllers\\SuratMasukController@store');
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratMasuk/edit/{id}', 'App\\Http\\Controllers\\SuratMasukController@edit');
            Route::post('/suratMasuk/update/{id}', 'App\\Http\\Controllers\\SuratMasukController@update');
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratMasuk/{id}', 'App\\Http\\Controllers\\SuratMasukController@destroy');
        });

        //dokumen
        Route::get('/dokumen/count', 'App\\Http\\Controllers\\DokumenController@count');
        Route::get('/dokumen/history', 'App\\Http\\Controllers\\DokumenController@history');
        Route::get('/dokumen/indexGerakanPublik', 'App\\Http\\Controllers\\DokumenController@indexGerakanPublik');
        Route::get('/dokumen/indexGerakanPublikCu/{id}', 'App\\Http\\Controllers\\DokumenController@indexGerakanPublikCu');
        Route::get('/dokumen/', 'App\\Http\\Controllers\\DokumenController@index');
        Route::get('/dokumen/indexCu/{id}', 'App\\Http\\Controllers\\DokumenController@indexCu');
        Route::group(['middleware' => ['permission:index_dokumen']], function () {
        });
        Route::group(['middleware' => ['permission:create_dokumen']], function () {
            Route::get('/dokumen/create', 'App\\Http\\Controllers\\DokumenController@create');
            Route::post('/dokumen/store', 'App\\Http\\Controllers\\DokumenController@store');
        });
        Route::group(['middleware' => ['permission:update_dokumen']], function () {
            Route::get('/dokumen/edit/{id}', 'App\\Http\\Controllers\\DokumenController@edit');
            Route::post('/dokumen/update/{id}', 'App\\Http\\Controllers\\DokumenController@update');
        });
        Route::group(['middleware' => ['permission:destroy_dokumen']], function () {
            Route::delete('/dokumen/{id}', 'App\\Http\\Controllers\\DokumenController@destroy');
        });

        //dokumen kategori
        Route::get('/dokumenKategori/history', 'App\\Http\\Controllers\\DokumenKategoriController@history');
        Route::group(['middleware' => ['permission:index_dokumen_kategori']], function () {
            Route::get('/dokumenKategori', 'App\\Http\\Controllers\\DokumenKategoriController@index');
            Route::get('/dokumenKategori/get', 'App\\Http\\Controllers\\DokumenKategoriController@get');
            Route::get('/dokumenKategori/indexCu/{id}', 'App\\Http\\Controllers\\DokumenKategoriController@indexCu');
            Route::get('/dokumenKategori/getCu/{id}', 'App\\Http\\Controllers\\DokumenKategoriController@getCu');
        });
        Route::group(['middleware' => ['permission:create_dokumen_kategori']], function () {
            Route::get('/dokumenKategori/create', 'App\\Http\\Controllers\\DokumenKategoriController@create');
            Route::post('/dokumenKategori/store', 'App\\Http\\Controllers\\DokumenKategoriController@store');
        });
        Route::group(['middleware' => ['permission:update_dokumen_kategori']], function () {
            Route::get('/dokumenKategori/edit/{id}', 'App\\Http\\Controllers\\DokumenKategoriController@edit');
            Route::post('/dokumenKategori/update/{id}', 'App\\Http\\Controllers\\DokumenKategoriController@update');
        });
        Route::group(['middleware' => ['permission:destroy_dokumen_kategori']], function () {
            Route::delete('/dokumenKategori/{id}', 'App\\Http\\Controllers\\DokumenKategoriController@destroy');
        });

        // assesment Access
        Route::get('/assesmentAccess/history', 'App\\Http\\Controllers\\AssesmentAccessController@history');
        Route::get(
            '/assesmentAccess/cariData/{cu}/{periode}',
            'App\\Http\\Controllers\\AssesmentAccessController@cariData'
        );
        Route::get('/assesmentAccess/edit/{id}', 'App\\Http\\Controllers\\AssesmentAccessController@edit');
        Route::get('/assesmentAccess/editPenilaian/{id}', 'App\\Http\\Controllers\\AssesmentAccessController@editPenilaian');
        Route::group(['middleware' => ['permission:index_assesment_access']], function () {
            Route::get('/assesmentAccess', 'App\\Http\\Controllers\\AssesmentAccessController@index');
            Route::get('/assesmentAccess/indexCu/{id}', 'App\\Http\\Controllers\\AssesmentAccessController@indexCu');
            Route::get('/assesmentAccess/count', 'App\\Http\\Controllers\\AssesmentAccessController@count');
        });
        Route::group(['middleware' => ['permission:create_assesment_access']], function () {
            Route::get('/assesmentAccess/create', 'App\\Http\\Controllers\\AssesmentAccessController@create');
            Route::post('/assesmentAccess/store', 'App\\Http\\Controllers\\AssesmentAccessController@store');
        });
        Route::group(['middleware' => ['permission:update_assesment_access']], function () {
            Route::post('/assesmentAccess/update/{id}', 'App\\Http\\Controllers\\AssesmentAccessController@update');
            Route::post('/assesmentAccess/updateSingle/{id}/{perspektif}', 'App\\Http\\Controllers\\AssesmentAccessController@updateSingle');
        });
        Route::group(['middleware' => ['permission:destroy_assesment_access']], function () {
            Route::delete('/assesmentAccess/{id}', 'App\\Http\\Controllers\\AssesmentAccessController@destroy');
        });


        // assesment Culeg
        Route::get('/assesmentCuleg/history', 'App\\Http\\Controllers\\AssesmentCulegController@history');
        Route::get(
            '/assesmentCuleg/cariData/{cu}/{periode}',
            'App\\Http\\Controllers\\AssesmentAccessController@cariData'
        );
        Route::get('/assesmentCuleg/edit/{id}', 'App\\Http\\Controllers\\AssesmentCulegController@edit');
        Route::get('/assesmentCuleg/editPenilaian/{id}', 'App\\Http\\Controllers\\AssesmentCulegController@editPenilaian');
        Route::group(['middleware' => ['permission:index_assesment_culeg']], function () {
            Route::get('/assesmentCuleg', 'App\\Http\\Controllers\\AssesmentCulegController@index');
            Route::get('/assesmentCuleg/indexCu/{id}', 'App\\Http\\Controllers\\AssesmentCulegController@indexCu');
            Route::get('/assesmentCuleg/count', 'App\\Http\\Controllers\\AssesmentCulegController@count');
        });
        Route::group(['middleware' => ['permission:create_assesment_culeg']], function () {
            Route::get('/assesmentCuleg/create', 'App\\Http\\Controllers\\AssesmentCulegController@create');
            Route::post('/assesmentCuleg/store', 'App\\Http\\Controllers\\AssesmentCulegController@store');
        });
        Route::group(['middleware' => ['permission:update_assesment_culeg']], function () {
            Route::post('/assesmentCuleg/update/{id}', 'App\\Http\\Controllers\\AssesmentCulegController@update');
            Route::post('/assesmentCuleg/updateSingle/{id}/{perspektif}', 'App\\Http\\Controllers\\AssesmentCulegController@updateSingle');
        });
        Route::group(['middleware' => ['permission:destroy_assesment_culeg']], function () {
            Route::delete('/assesmentCuleg/{id}', 'App\\Http\\Controllers\\AssesmentCulegController@destroy');
        });

        // monitoring
        Route::get('/monitoring/history', 'App\\Http\\Controllers\\MonitoringController@history');
        Route::post('monitoring/laporan', 'App\\Http\\Controllers\\MonitoringController@downloadLaporan');
        Route::post('monitoring/laporanKonsolidasi', 'App\\Http\\Controllers\\MonitoringController@downloadLaporanKonsolidasi');
        Route::get('/monitoring/getPeriode/{cu}', 'App\\Http\\Controllers\\MonitoringController@getPeriode');
        Route::group(['middleware' => ['permission:index_monitoring']], function () {
            Route::get('/monitoring/status/{status}', 'App\\Http\\Controllers\\MonitoringController@index');
            Route::get('/monitoring/summary/{cu}', 'App\\Http\\Controllers\\MonitoringController@summary');
            Route::get('/monitoring/indexCu/{cu}/{tp}/{status}', 'App\\Http\\Controllers\\MonitoringController@indexCu');
            Route::get('/monitoring/get/{id}', 'App\\Http\\Controllers\\MonitoringController@get');
            Route::get('/monitoring/count', 'App\\Http\\Controllers\\MonitoringController@count');
            Route::get('/monitoring/indexKonsolidasi/{tahun}/{bulan}', 'App\\Http\\Controllers\\MonitoringController@indexKonsolidasi');
        });
        Route::group(['middleware' => ['permission:create_monitoring']], function () {
            Route::get('/monitoring/create', 'App\\Http\\Controllers\\MonitoringController@create');
            Route::post('/monitoring/store', 'App\\Http\\Controllers\\MonitoringController@store');
        });
        Route::group(['middleware' => ['permission:update_monitoring']], function () {
            Route::get('/monitoring/edit/{id}', 'App\\Http\\Controllers\\MonitoringController@edit');
            Route::post('/monitoring/update/{id}', 'App\\Http\\Controllers\\MonitoringController@update');
            Route::post('/monitoring/updateRekom/{id}', 'App\\Http\\Controllers\\MonitoringController@updateRekom');
        });
        Route::group(['middleware' => ['permission:destroy_monitoring']], function () {
            Route::delete('/monitoring/{id}', 'App\\Http\\Controllers\\MonitoringController@destroy');
        });

        // monitoring pencapaian
        Route::get('/monitoringPencapaian/history', 'App\\Http\\Controllers\\MonitoringPencapaianController@history');
        Route::group(['middleware' => ['permission:index_monitoring']], function () {
            Route::get('/monitoringPencapaian/get/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianController@get');
            Route::get('/monitoringPencapaian/count', 'App\\Http\\Controllers\\MonitoringPencapaianController@count');
        });
        Route::group(['middleware' => ['permission:create_monitoring']], function () {
            Route::post('/monitoringPencapaian/store', 'App\\Http\\Controllers\\MonitoringPencapaianController@store');
        });
        Route::group(['middleware' => ['permission:update_monitoring']], function () {
            Route::post('/monitoringPencapaian/update/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianController@update');
        });
        Route::group(['middleware' => ['permission:destroy_monitoring']], function () {
            Route::delete('/monitoringPencapaian/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianController@destroy');
        });

        // monitoring cu
        Route::get('/monitoringCu/history', 'App\\Http\\Controllers\\MonitoringCuController@history');
        Route::post('monitoringCu/laporan', 'App\\Http\\Controllers\\MonitoringCuController@downloadLaporan');
        Route::post('monitoringCu/laporanKonsolidasi', 'App\\Http\\Controllers\\MonitoringCuController@downloadLaporanKonsolidasi');
        Route::get('/monitoringCu/getPeriode/{cu}', 'App\\Http\\Controllers\\MonitoringCuController@getPeriode');
        Route::group(['middleware' => ['permission:index_monitoring_cu']], function () {
            Route::get('/monitoringCu/status/{status}', 'App\\Http\\Controllers\\MonitoringCuController@index');
            Route::get('/monitoringCu/summary/{cu}', 'App\\Http\\Controllers\\MonitoringCuController@summary');
            Route::get('/monitoringCu/indexCu/{cu}/{tp}/{status}', 'App\\Http\\Controllers\\MonitoringCuController@indexCu');
            Route::get('/monitoringCu/get/{id}', 'App\\Http\\Controllers\\MonitoringCuController@get');
            Route::get('/monitoringCu/count', 'App\\Http\\Controllers\\MonitoringCuController@count');
            Route::get('/monitoringCu/indexKonsolidasi/{tahun}/{bulan}', 'App\\Http\\Controllers\\MonitoringCuController@indexKonsolidasi');
        });
        Route::group(['middleware' => ['permission:create_monitoring_cu']], function () {
            Route::get('/monitoringCu/create', 'App\\Http\\Controllers\\MonitoringCuController@create');
            Route::post('/monitoringCu/store', 'App\\Http\\Controllers\\MonitoringCuController@store');
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::get('/monitoringCu/edit/{id}', 'App\\Http\\Controllers\\MonitoringCuController@edit');
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu']], function () {
            Route::post('/monitoringCu/update/{id}', 'App\\Http\\Controllers\\MonitoringCuController@update');
            Route::post('/monitoringCu/updateRekom/{id}', 'App\\Http\\Controllers\\MonitoringCuController@updateRekom');
        });
        Route::group(['middleware' => ['permission:destroy_monitoring_cu']], function () {
            Route::delete('/monitoringCu/{id}', 'App\\Http\\Controllers\\MonitoringCuController@destroy');
        });

         // monitoring pencapaian cu
        Route::get('/monitoringPencapaianCu/history', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@history');
        Route::group(['middleware' => ['permission:index_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::get('/monitoringPencapaianCu/get/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@get');
            Route::get('/monitoringPencapaianCu/count', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@count');
        });
        Route::group(['middleware' => ['permission:create_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::post('/monitoringPencapaianCu/store', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@store');
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::post('/monitoringPencapaianCu/update/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@update');
        });
        Route::group(['middleware' => ['permission:destroy_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::delete('/monitoringPencapaianCu/{id}', 'App\\Http\\Controllers\\MonitoringPencapaianCuController@destroy');
        });

        // mitra perserorangan
        Route::get('/mitraOrang/history', 'App\\Http\\Controllers\\MitraOrangController@history');
        Route::get('/mitraOrang', 'App\\Http\\Controllers\\MitraOrangController@index');
        Route::get('/mitraOrang/indexPeserta/{kegiatan_id}', 'App\\Http\\Controllers\\MitraOrangController@indexPeserta');
        Route::get('/mitraOrang/indexCu/{id}', 'App\\Http\\Controllers\\MitraOrangController@indexCu');
        Route::group(['middleware' => ['permission:index_mitra_orang']], function () {
            Route::get('/mitraOrang/count', 'App\\Http\\Controllers\\MitraOrangController@count');
        });
        Route::group(['middleware' => ['permission:create_mitra_orang']], function () {
            Route::get('/mitraOrang/create', 'App\\Http\\Controllers\\MitraOrangController@create');
            Route::post('/mitraOrang/store', 'App\\Http\\Controllers\\MitraOrangController@store');
        });
        Route::group(['middleware' => ['permission:update_mitra_orang']], function () {
            Route::get('/mitraOrang/edit/{id}', 'App\\Http\\Controllers\\MitraOrangController@edit');
            Route::post('/mitraOrang/update/{id}', 'App\\Http\\Controllers\\MitraOrangController@update');
            Route::post('/mitraOrang/restore/{id}', 'App\\Http\\Controllers\\MitraOrangController@restore');
        });
        Route::group(['middleware' => ['permission:destroy_mitra_orang']], function () {
            Route::delete('/mitraOrang/{id}', 'App\\Http\\Controllers\\MitraOrangController@destroy');
        });

        // mitra lembaga
        Route::get('/mitraLembaga/history', 'App\\Http\\Controllers\\MitraLembagaController@history');
        Route::get('/mitraLembaga', 'App\\Http\\Controllers\\MitraLembagaController@index');
        Route::get('/mitraLembaga/indexCu/{id}', 'App\\Http\\Controllers\\MitraLembagaController@indexCu');
        Route::group(['middleware' => ['permission:index_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/count', 'App\\Http\\Controllers\\MitraLembagaController@count');
        });
        Route::group(['middleware' => ['permission:create_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/create', 'App\\Http\\Controllers\\MitraLembagaController@create');
            Route::post('/mitraLembaga/store', 'App\\Http\\Controllers\\MitraLembagaController@store');
        });
        Route::group(['middleware' => ['permission:update_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/edit/{id}', 'App\\Http\\Controllers\\MitraLembagaController@edit');
            Route::post('/mitraLembaga/update/{id}', 'App\\Http\\Controllers\\MitraLembagaController@update');
            Route::post('/mitraLembaga/restore/{id}', 'App\\Http\\Controllers\\MitraLembagaController@restore');
        });
        Route::group(['middleware' => ['permission:destroy_mitra_lembaga']], function () {
            Route::delete('/mitraLembaga/{id}', 'App\\Http\\Controllers\\MitraLembagaController@destroy');
        });

        // anggota cu
        Route::get('/anggotaCu/systemNIK', 'App\\Http\\Controllers\\AnggotaCuController@systemNIK');
        Route::get('/anggotaCu/history', 'App\\Http\\Controllers\\AnggotaCuController@history');
        Route::get('/anggotaCu/count', 'App\\Http\\Controllers\\AnggotaCuController@count');
        Route::get('/anggotaCu/cariDataInformasi/{nik}', 'App\\Http\\Controllers\\AnggotaCuController@cariDataInformasi');
        Route::get('/anggotaCu/cariDataKTP/{nik}', 'App\\Http\\Controllers\\AnggotaCuController@cariDataKTP');
        Route::get('/anggotaCu/cariDataBA/{cu}/{noba}', 'App\\Http\\Controllers\\AnggotaCuController@cariDataBA');
        Route::get('/anggotaCu/indexProduk/{id}/cu/{cu}', 'App\\Http\\Controllers\\AnggotaProdukCuController@index');
        Route::get('/anggotaCu/indexProdukSaldo/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuController@indexSaldo');
        Route::get('/anggotaCu', 'App\\Http\\Controllers\\AnggotaCuController@index');
        Route::get('/anggotaCu/indexCu/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuController@indexCu');
        Route::get('/anggotaCu/indexCuFasilitator/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuController@indexCuFasilitator');
        Route::get('/anggotaCu/indexCuMentor/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuController@indexCuMentor');
        Route::get('/anggotaCu/keluar', 'App\\Http\\Controllers\\AnggotaCuController@indexKeluar');
        Route::get('/anggotaCu/indexMeninggal', 'App\\Http\\Controllers\\AnggotaCuController@indexMeninggal');
        Route::get('/anggotaCu/indexCuKeluar/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuController@indexCuKeluar');
        Route::get('/anggotaCu/indexCuMeninggal/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuController@indexCuMeninggal');
        Route::get('/anggotaCu/getCu/{cu}', 'App\\Http\\Controllers\\AnggotaCuController@getCu');
        Route::get('/anggotaCu/getCuJalinan/{cu}/{bulan}/{tahun}', 'App\\Http\\Controllers\\AnggotaCuController@getCuJalinan');
        Route::get('/anggotaCu/getCuKeluar/{cu}', 'App\\Http\\Controllers\\AnggotaCuController@getCuKeluar');
        Route::group(['middleware' => ['permission:create_anggota_cu']], function () {
            Route::get('/anggotaCu/create', 'App\\Http\\Controllers\\AnggotaCuController@create');
            Route::post('/anggotaCu/store', 'App\\Http\\Controllers\\AnggotaCuController@store');
            Route::post('/anggotaCu/storeCu/{id}', 'App\\Http\\Controllers\\AnggotaCuController@storeCu');
            Route::post('/anggotaCu/storeProduk/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuController@store');
        });
        Route::group(['middleware' => ['permission:update_anggota_cu']], function () {
            Route::get('/anggotaCu/edit/{id}', 'App\\Http\\Controllers\\AnggotaCuController@edit');
            Route::post('/anggotaCu/update/{id}', 'App\\Http\\Controllers\\AnggotaCuController@update');
            Route::post('/anggotaCu/updateCu/{id}', 'App\\Http\\Controllers\\AnggotaCuController@updateCu');
            Route::post('/anggotaCu/updatePindahTp/{id}', 'App\\Http\\Controllers\\AnggotaCuController@updatePindahTp');
            Route::post('/anggotaCu/updateKeluar/{id}', 'App\\Http\\Controllers\\AnggotaCuController@updateKeluar');
            Route::post('/anggotaCu/updateBatalKeluar/{id}', 'App\\Http\\Controllers\\AnggotaCuController@updateBatalKeluar');
            Route::post('/anggotaCu/updateNik/{id}', 'App\\Http\\Controllers\\AnggotaCuController@updateNik');
            Route::post('/anggotaCu/restore/{id}', 'App\\Http\\Controllers\\AnggotaCuController@restore');
            Route::post('/anggotaCu/updateProduk/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuController@update');
        });
        Route::group(['middleware' => ['permission:destroy_anggota_cu']], function () {
            Route::delete('/anggotaCu/{id}/cu/{cu}', 'App\\Http\\Controllers\\AnggotaCuController@destroy');
            Route::delete('/anggotaCuCu/{id}', 'App\\Http\\Controllers\\AnggotaCuController@destroyCu');
            Route::delete('/anggotaProdukCu/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuController@destroy');
        });
        Route::group(['middleware' => ['permission:upload_anggota_cu']], function () {
            Route::post('/anggotaCu/uploadExcel', 'App\\Http\\Controllers\\AnggotaCuController@uploadExcel');
            Route::post('/anggotaCu/uploadExcelProduk', 'App\\Http\\Controllers\\AnggotaCuController@uploadExcelProduk');
            Route::get('/anggotaCuDraft/index/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuDraftController@index');
            Route::post('/anggotaCuDraft/store/{id}', 'App\\Http\\Controllers\\AnggotaCuDraftController@store');
            Route::post('/anggotaCuDraft/storeAll/{cu}', 'App\\Http\\Controllers\\AnggotaCuDraftController@storeAll');
            Route::get('/anggotaCuDraft/edit/{id}', 'App\\Http\\Controllers\\AnggotaCuDraftController@edit');
            Route::post('/anggotaCuDraft/update/{id}', 'App\\Http\\Controllers\\AnggotaCuDraftController@update');
            Route::delete('/anggotaCuDraft/destroy/{id}', 'App\\Http\\Controllers\\AnggotaCuDraftController@destroy');
            Route::delete('/anggotaCuDraft/destroyAll/{cu}', 'App\\Http\\Controllers\\AnggotaCuDraftController@destroyAll');
            Route::get('/anggotaCuDraft/count/{cu}/{tp}', 'App\\Http\\Controllers\\AnggotaCuDraftController@count');
            Route::get('/anggotaProdukCuDraft/index/{cu}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@index');
            Route::post('/anggotaProdukCuDraft/store/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@store');
            Route::post('/anggotaProdukCuDraft/storeAll/{cu}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@storeAll');
            Route::get('/anggotaProdukCuDraft/edit/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@edit');
            Route::post('/anggotaProdukCuDraft/update/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@update');
            Route::delete('/anggotaProdukCuDraft/destroy/{id}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@destroy');
            Route::delete('/anggotaProdukCuDraft/destroyAll/{cu}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@destroyAll');
            Route::get('/anggotaProdukCuDraft/count/{cu}', 'App\\Http\\Controllers\\AnggotaProdukCuDraftController@count');
        });

        // jalinan klaim
        Route::get('/jalinanKlaim/count', 'App\\Http\\Controllers\\JalinanKlaimController@count');
        Route::get('/jalinanKlaim/history', 'App\\Http\\Controllers\\JalinanKlaimController@history');
        Route::get('/jalinanKlaim/cekData/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@cekData');
        Route::get('/jalinanKlaim/getKlaim/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@getKlaim');
        Route::get('/jalinanKlaim/getVerifikator/{verifikator_pengurus}/{verifikator_pengawas}/{verifikator_manajemen}', 'App\\Http\\Controllers\\JalinanKlaimController@getVerifikator');
        Route::post('/jalinanKlaim/updateVerifikasi/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@updateVerifikasi');
        Route::get('/jalinanKlaim/getPencairan', 'App\\Http\\Controllers\\JalinanKlaimController@getPencairan');
        Route::get('/jalinanKlaim/getStatus/{status_klaim}', 'App\\Http\\Controllers\\JalinanKlaimController@getStatus');
        Route::get('/jalinanKlaim/getHistory/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@getHistory');
        Route::get('/jalinanKlaim/getDuplicate/{name}/tanggal/{tanggal_lahir}/tipe/{tipe}', 'App\\Http\\Controllers\\JalinanKlaimController@getDuplicate');
        Route::get('/jalinanKlaim/getKlaimLama/{nik}/cu/{cu}', 'App\\Http\\Controllers\\JalinanKlaimController@getKlaimLama');
        Route::get('/jalinanKlaim/edit/{nik}/cu/{cu}/tipe/{tipe}', 'App\\Http\\Controllers\\JalinanKlaimController@edit');
        Route::group(['middleware' => ['permission:index_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/status/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@index');
            Route::get('/jalinanKlaim/indexCu/{cu}/tp/{tp}/status/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexCu');
            Route::get('/jalinanKlaim/cariData/{nik}', 'App\\Http\\Controllers\\JalinanKlaimController@cariData');
            Route::get('/jalinanKlaim/cariDataId/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@cariDataId');
        });
        Route::group(['middleware' => ['permission:create_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/create', 'App\\Http\\Controllers\\JalinanKlaimController@create');
            Route::post('/jalinanKlaim/store', 'App\\Http\\Controllers\\JalinanKlaimController@store');
        });
        Route::group(['middleware' => ['permission:update_jalinan_klaim']], function () {
            Route::post('/jalinanKlaim/update/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@update');
            Route::post('/jalinanKlaim/updateStatus/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@updateStatus');
            Route::post('/jalinanKlaim/updateNoSurat/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@updateNoSurat');
            Route::post('/jalinanKlaim/periksaKoreksi/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@periksaKoreksi');
            Route::post('/jalinanKlaim/updateSelesai/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@updateSelesai');
        });
        Route::group(['middleware' => ['permission:destroy_jalinan_klaim']], function () {
            Route::delete('/jalinanKlaim/{id}', 'App\\Http\\Controllers\\JalinanKlaimController@destroy');
        });
        Route::group(['middleware' => ['permission:pencairan_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/indexCair/{tanggal_pencairan}', 'App\\Http\\Controllers\\JalinanKlaimController@indexCair');
            Route::post('/jalinanKlaim/updateCair/{id}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@updateCair');
            Route::post('/jalinanKlaim/updateCairBatal/{id}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@updateCairBatal');
            Route::post('/jalinanKlaim/updateCairAll/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@updateCairAll');
        });
        Route::group(['middleware' => ['permission:laporan_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/indexLaporanCu/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanCu');
            Route::get('/jalinanKlaim/indexLaporanCuDetail/{cu}/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanCuDetail');
            Route::get('/jalinanKlaim/indexLaporanPenyebab/{cu}/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanPenyebab');
            Route::get('/jalinanKlaim/indexLaporanPenyebabDetail/{cu}/{status}/{kategori}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanPenyebabDetail');
            Route::get('/jalinanKlaim/indexLaporanUsia/{cu}/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanUsia');
            Route::get('/jalinanKlaim/indexLaporanUsiaDetail/{cu}/{status}/{dari}/{ke}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanUsiaDetail');
            Route::get('/jalinanKlaim/indexLaporanLama/{cu}/{status}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanLama');
            Route::get('/jalinanKlaim/indexLaporanLamaDetail/{cu}/{status}/{dari}/{ke}/{awal}/{akhir}', 'App\\Http\\Controllers\\JalinanKlaimController@indexLaporanLamaDetail');
        });

        //jalinan iuran
        Route::get('/jalinanIuran', 'App\\Http\\Controllers\\JalinanIuranController@index');
        Route::get('/jalinanIuran/indexCu/{id}', 'App\\Http\\Controllers\\JalinanIuranController@indexCu');
        Route::get('/jalinanIuran/indexAnggota/{id}/{cu}/{lokasi}', 'App\\Http\\Controllers\\JalinanIuranController@indexAnggota');
        Route::get('/jalinanIuran/edit/{id}', 'App\\Http\\Controllers\\JalinanIuranController@edit');
        Route::get('/jalinanIuran/create/{cu}/{bulan}/{tahun}', 'App\\Http\\Controllers\\JalinanIuranController@create');
        Route::post('/jalinanIuran/store', 'App\\Http\\Controllers\\JalinanIuranController@store');
        Route::post('/jalinanIuran/update/{id}', 'App\\Http\\Controllers\\JalinanIuranController@update');
        Route::delete('/jalinanIuran/{id}', 'App\\Http\\Controllers\\JalinanIuranController@destroy');
        
        // Route::group(['middleware' => ['permission:index_jalinan_iuran']], function () {
        //     Route::get('/jalinanIuran', 'App\\Http\\Controllers\\JalinanIuranController@index');
        //     Route::get('/jalinanIuran/indexCu/{id}', 'App\\Http\\Controllers\\JalinanIuranController@indexCu');
        //     Route::get('/jalinanIuran/indexAnggota/{id}/{cu}/{lokasi}', 'App\\Http\\Controllers\\JalinanIuranController@indexAnggota');
        //     Route::get('/jalinanIuran/edit/{id}', 'App\\Http\\Controllers\\JalinanIuranController@edit');
        // });
        // Route::group(['middleware' => ['permission:create_jalinan_iuran']], function () {
        //     Route::get('/jalinanIuran/create/{cu}/{bulan}/{tahun}', 'App\\Http\\Controllers\\JalinanIuranController@create');
        //     Route::post('/jalinanIuran/store', 'App\\Http\\Controllers\\JalinanIuranController@store');
        // });
        // Route::group(['middleware' => ['permission:update_jalinan_iuran']], function () {
        //     Route::post('/jalinanIuran/update/{id}', 'App\\Http\\Controllers\\JalinanIuranController@update');
        // });
        // Route::group(['middleware' => ['permission:destroy_jalinan_iuran']], function () {
        //     Route::delete('/jalinanIuran/{id}', 'App\\Http\\Controllers\\JalinanIuranController@destroy');
        // });

        //laporan gerakan
        Route::get('/laporanGerakan', 'App\\Http\\Controllers\\LaporanGerakanController@index');
        Route::group(['middleware' => ['permission:create_laporan_cu']], function () {
            Route::get('/laporanGerakan/create', 'App\\Http\\Controllers\\LaporanGerakanController@create');
            Route::post('/laporanGerakan/store', 'App\\Http\\Controllers\\LaporanGerakanController@store');
        });
        Route::group(['middleware' => ['permission:update_laporan_cu']], function () {
            Route::get('/laporanGerakan/edit/{id}', 'App\\Http\\Controllers\\LaporanGerakanController@edit');
            Route::post('/laporanGerakan/update/{id}', 'App\\Http\\Controllers\\LaporanGerakanController@update');
        });
        Route::group(['middleware' => ['permission:destroy_laporan_cu']], function () {
            Route::delete('/laporanGerakan/{id}', 'App\\Http\\Controllers\\LaporanGerakanController@destroy');
        });

        //laporan cu
        Route::get('/laporanCu/history', 'App\\Http\\Controllers\\LaporanCuController@history');
        Route::group(['middleware' => ['permission:index_laporan_cu']], function () {
            Route::get('/laporanCu', 'App\\Http\\Controllers\\LaporanCuController@index');
            Route::get('/laporanCu/indexTotal', 'App\\Http\\Controllers\\LaporanCuController@indexTotal');
            Route::get('/laporanCu/indexGerakan', 'App\\Http\\Controllers\\LaporanCuController@indexGerakan');
            Route::get('/laporanCu/indexCu/{id}', 'App\\Http\\Controllers\\LaporanCuController@indexCu');
            Route::get('/laporanCu/indexPeriode/{periode}', 'App\\Http\\Controllers\\LaporanCuController@indexPeriode');
            Route::get('/laporanCu/indexPearls', 'App\\Http\\Controllers\\LaporanCuController@indexPearls');
            Route::get('/laporanCu/indexPearlsCu/{id}', 'App\\Http\\Controllers\\LaporanCuController@indexPearlsCu');
            Route::get('/laporanCu/indexPearlsPeriode/{periode}', 'App\\Http\\Controllers\\LaporanCuController@indexPearlsPeriode');
            Route::get('/laporanCu/getPeriode', 'App\\Http\\Controllers\\LaporanCuController@getPeriode');
            Route::get('/laporanCu/getPeriodeCu/{id}', 'App\\Http\\Controllers\\LaporanCuController@getPeriodeCu');
            Route::get('/laporanCu/detail/{id}', 'App\\Http\\Controllers\\LaporanCuController@detail');
            Route::get('/laporanCu/detailPearls/{id}', 'App\\Http\\Controllers\\LaporanCuController@detailPearls');
        });
        Route::group(['middleware' => ['permission:create_laporan_cu']], function () {
            Route::get('/laporanCu/create', 'App\\Http\\Controllers\\LaporanCuController@create');
            Route::post('/laporanCu/store', 'App\\Http\\Controllers\\LaporanCuController@store');
        });
        Route::group(['middleware' => ['permission:update_laporan_cu']], function () {
            Route::get('/laporanCu/edit/{id}', 'App\\Http\\Controllers\\LaporanCuController@edit');
            Route::post('/laporanCu/update/{id}', 'App\\Http\\Controllers\\LaporanCuController@update');
        });
        Route::group(['middleware' => ['permission:destroy_laporan_cu']], function () {
            Route::delete('/laporanCu/{id}', 'App\\Http\\Controllers\\LaporanCuController@destroy');
        });
        Route::group(['middleware' => ['permission:diskusi_laporan_cu']], function () {
            Route::get('/laporanCuDiskusi/get/{id}', 'App\\Http\\Controllers\\LaporanCuDiskusiController@get');
            Route::post('/laporanCuDiskusi/store', 'App\\Http\\Controllers\\LaporanCuDiskusiController@store');
            Route::post('/laporanCuDiskusi/update/{id}', 'App\\Http\\Controllers\\LaporanCuDiskusiController@update');
            Route::delete('/laporanCuDiskusi/{id}', 'App\\Http\\Controllers\\LaporanCuDiskusiController@destroy');
        });
        Route::group(['middleware' => ['permission:upload_laporan_cu']], function () {
            Route::post('/laporanCu/uploadExcel', 'App\\Http\\Controllers\\LaporanCuController@uploadExcel');
            Route::post('/laporanCu/uploadExcelAll', 'App\\Http\\Controllers\\LaporanCuController@uploadExcelAll');

            Route::get('/laporanCuDraft', 'App\\Http\\Controllers\\LaporanCuDraftController@index');
            Route::post('/laporanCuDraft/store/{id}', 'App\\Http\\Controllers\\LaporanCuDraftController@store');
            Route::post('/laporanCuDraft/storeAll', 'App\\Http\\Controllers\\LaporanCuDraftController@storeAll');
            Route::get('/laporanCuDraft/edit/{id}', 'App\\Http\\Controllers\\LaporanCuDraftController@edit');
            Route::post('/laporanCuDraft/update/{id}', 'App\\Http\\Controllers\\LaporanCuDraftController@update');
            Route::delete('/laporanCuDraft/destroy/{id}', 'App\\Http\\Controllers\\LaporanCuDraftController@destroy');
            Route::delete('/laporanCuDraft/destroyAll', 'App\\Http\\Controllers\\LaporanCuDraftController@destroyAll');
            Route::get('/laporanCuDraft/count', 'App\\Http\\Controllers\\LaporanCuDraftController@count');
        });

        //laporan tp
        Route::get('/laporanTp/history', 'App\\Http\\Controllers\\LaporanTpController@history');
        Route::group(['middleware' => ['permission:index_laporan_tp']], function () {
            Route::get('/laporanTp/cu/{id}', 'App\\Http\\Controllers\\LaporanTpController@index');
            Route::get('/laporanTp/indexTp/{id}', 'App\\Http\\Controllers\\LaporanTpController@indexTp');
            Route::get('/laporanTp/indexPeriode/{id}/{periode}', 'App\\Http\\Controllers\\LaporanTpController@indexPeriode');
            Route::get('/laporanTp/indexPearls', 'App\\Http\\Controllers\\LaporanTpController@indexPearls');
            Route::get('/laporanTp/indexPearlsTp/{id}', 'App\\Http\\Controllers\\LaporanTpController@indexPearlsTp');
            Route::get('/laporanTp/indexPearlsPeriode/{id}/{periode}', 'App\\Http\\Controllers\\LaporanTpController@indexPearlsPeriode');
            Route::get('/laporanTp/getPeriode', 'App\\Http\\Controllers\\LaporanTpController@getPeriode');
            Route::get('/laporanTp/getPeriodeTp/{id}/{periode}', 'App\\Http\\Controllers\\LaporanTpController@getPeriodeTp');
            Route::get('/laporanTp/listLaporanTp/{cu}/{periode}', 'App\\Http\\Controllers\\LaporanTpController@listLaporanTp');
            Route::get('/laporanTp/detail/{id}', 'App\\Http\\Controllers\\LaporanTpController@detail');
            Route::get('/laporanTp/detailPearls/{id}', 'App\\Http\\Controllers\\LaporanTpController@detailPearls');
        });
        Route::group(['middleware' => ['permission:create_laporan_tp']], function () {
            Route::get('/laporanTp/create', 'App\\Http\\Controllers\\LaporanTpController@create');
            Route::post('/laporanTp/store', 'App\\Http\\Controllers\\LaporanTpController@store');
        });
        Route::group(['middleware' => ['permission:update_laporan_tp']], function () {
            Route::get('/laporanTp/edit/{id}', 'App\\Http\\Controllers\\LaporanTpController@edit');
            Route::post('/laporanTp/update/{id}', 'App\\Http\\Controllers\\LaporanTpController@update');
        });
        Route::group(['middleware' => ['permission:destroy_laporan_tp']], function () {
            Route::delete('/laporanTp/{id}', 'App\\Http\\Controllers\\LaporanTpController@destroy');
        });
        Route::group(['middleware' => ['permission:diskusi_laporan_tp']], function () {
            Route::get('/laporanTpDiskusi/get/{id}', 'App\\Http\\Controllers\\LaporanTpDiskusiController@get');
            Route::post('/laporanTpDiskusi/store', 'App\\Http\\Controllers\\LaporanTpDiskusiController@store');
            Route::post('/laporanTpDiskusi/update/{id}', 'App\\Http\\Controllers\\LaporanTpDiskusiController@update');
            Route::delete('/laporanTpDiskusi/{id}', 'App\\Http\\Controllers\\LaporanTpDiskusiController@destroy');
        });
        Route::group(['middleware' => ['permission:upload_laporan_tp']], function () {
            Route::post('/laporanTp/uploadExcel', 'App\\Http\\Controllers\\LaporanTpController@uploadExcel');
            Route::post('/laporanTp/uploadExcelAll', 'App\\Http\\Controllers\\LaporanTpController@uploadExcelAll');

            Route::get('/laporanTpDraft', 'App\\Http\\Controllers\\LaporanTpDraftController@index');
            Route::post('/laporanTpDraft/store/{id}', 'App\\Http\\Controllers\\LaporanTpDraftController@store');
            Route::post('/laporanTpDraft/storeAll', 'App\\Http\\Controllers\\LaporanTpDraftController@storeAll');
            Route::get('/laporanTpDraft/edit/{id}', 'App\\Http\\Controllers\\LaporanTpDraftController@edit');
            Route::post('/laporanTpDraft/update/{id}', 'App\\Http\\Controllers\\LaporanTpDraftController@update');
            Route::delete('/laporanTpDraft/destroy/{id}', 'App\\Http\\Controllers\\LaporanTpDraftController@destroy');
            Route::delete('/laporanTpDraft/destroyAll', 'App\\Http\\Controllers\\LaporanTpDraftController@destroyAll');
            Route::get('/laporanTpDraft/count', 'App\\Http\\Controllers\\LaporanTpDraftController@count');
        });

        //coa
        Route::get('/coa/history', 'App\\Http\\Controllers\\CoaController@history');
        Route::group(['middleware' => ['permission:index_coa']], function () {
            Route::get('/coa', 'App\\Http\\Controllers\\CoaController@index');
            Route::get('/coa/get', 'App\\Http\\Controllers\\CoaController@get');
        });
        Route::group(['middleware' => ['permission:create_coa']], function () {
            Route::get('/coa/create', 'App\\Http\\Controllers\\CoaController@create');
            Route::post('/coa/store', 'App\\Http\\Controllers\\CoaController@store');
        });
        Route::group(['middleware' => ['permission:update_coa']], function () {
            Route::get('/coa/edit/{id}', 'App\\Http\\Controllers\\CoaController@edit');
            Route::post('/coa/update/{id}', 'App\\Http\\Controllers\\CoaController@update');
        });
        Route::group(['middleware' => ['permission:destroy_coa']], function () {
            Route::delete('/coa/{id}', 'App\\Http\\Controllers\\CoaController@destroy');
        });

        //saran
        Route::group(['middleware' => ['permission:index_saran']], function () {
            Route::get('/saran', 'App\\Http\\Controllers\\SaranController@index');
            Route::get('/saran/count', 'App\\Http\\Controllers\\SaranController@count');
        });
        Route::get('/saran/create', 'App\\Http\\Controllers\\SaranController@create');
        Route::post('/saran/store', 'App\\Http\\Controllers\\SaranController@store');
        Route::group(['middleware' => ['permission:destroy_saran']], function () {
            Route::delete('/saran/{id}', 'App\\Http\\Controllers\\SaranController@destroy');
        });

        //error log
        Route::group(['middleware' => ['permission:index_saran']], function () {
            Route::get('/errorLog', 'App\\Http\\Controllers\\ErrorLogController@index');
            Route::get('/errorLog/count', 'App\\Http\\Controllers\\ErrorLogController@count');
        });
        Route::get('/errorLog/create', 'App\\Http\\Controllers\\ErrorLogController@create');
        Route::post('/errorLog/store', 'App\\Http\\Controllers\\ErrorLogController@store');
        Route::group(['middleware' => ['permission:destroy_saran']], function () {
            Route::delete('/errorLog/{id}', 'App\\Http\\Controllers\\ErrorLogController@destroy');
        });

        //pengumuman
        Route::group(['middleware' => ['permission:index_pengumuman']], function () {
            Route::get('/pengumuman', 'App\\Http\\Controllers\\PengumumanController@index');
            Route::get('/pengumuman/indexCu/{id}', 'App\\Http\\Controllers\\PengumumanController@indexCu');
            Route::get('/pengumuman/count', 'App\\Http\\Controllers\\PengumumanController@count');
        });
        Route::group(['middleware' => ['permission:create_pengumuman']], function () {
            Route::get('/pengumuman/create', 'App\\Http\\Controllers\\PengumumanController@create');
            Route::post('/pengumuman/store', 'App\\Http\\Controllers\\PengumumanController@store');
        });
        Route::group(['middleware' => ['permission:update_pengumuman']], function () {
            Route::get('/pengumuman/edit/{id}', 'App\\Http\\Controllers\\PengumumanController@edit');
            Route::post('/pengumuman/update/{id}', 'App\\Http\\Controllers\\PengumumanController@update');
        });
        Route::group(['middleware' => ['permission:destroy_pengumuman']], function () {
            Route::delete('/pengumuman/{id}', 'App\\Http\\Controllers\\PengumumanController@destroy');
        });

        //pemilihan
        Route::group(['middleware' => ['permission:index_pemilihan']], function () {
            Route::get('/pemilihan', 'App\\Http\\Controllers\\PemilihanController@index');
            Route::get('/pemilihan/indexCu/{id}', 'App\\Http\\Controllers\\PemilihanController@indexCu');
            Route::get('/pemilihan/indexPemilihan', 'App\\Http\\Controllers\\PemilihanController@indexPemilihan');
            Route::get('/pemilihan/indexPemilihanCu/{id}', 'App\\Http\\Controllers\\PemilihanController@indexPemilihanCu');
            Route::get('/pemilihan/indexDataSuara/{id}', 'App\\Http\\Controllers\\PemilihanController@indexDataSuara');
            Route::get('/pemilihan/indexUser/{id}', 'App\\Http\\Controllers\\PemilihanController@indexUser');
            Route::get('/pemilihan/checkUser/{pemilihan_id}', 'App\\Http\\Controllers\\PemilihanController@checkUser');
            Route::get('/pemilihan/edit/{id}', 'App\\Http\\Controllers\\PemilihanController@edit');
            Route::post('/pemilihan/storeSuara', 'App\\Http\\Controllers\\PemilihanController@storeSuara');
            Route::post('/pemilihan/updateSuara/{id}', 'App\\Http\\Controllers\\PemilihanController@updateSuara');
            Route::delete('/pemilihan/destroySuara/{id}', 'App\\Http\\Controllers\\PemilihanController@destroySuara');
            Route::post('/pemilihan/uploadSuara/{id}', 'App\\Http\\Controllers\\PemilihanController@uploadSuara');
        });
        Route::group(['middleware' => ['permission:create_pemilihan']], function () {
            Route::get('/pemilihan/create', 'App\\Http\\Controllers\\PemilihanController@create');
            Route::post('/pemilihan/store', 'App\\Http\\Controllers\\PemilihanController@store');
        });
        Route::group(['middleware' => ['permission:update_pemilihan']], function () {
            Route::get('/pemilihan/updateStatus/{id}/{cu}', 'App\\Http\\Controllers\\PemilihanController@updateStatus');
        });
        Route::group(['middleware' => ['permission:destroy_pemilihan']], function () {
            Route::delete('/pemilihan/{id}', 'App\\Http\\Controllers\\PemilihanController@destroy');
        });

        //voting
        Route::group(['middleware' => ['permission:index_voting']], function () {
            Route::get('/voting', 'App\\Http\\Controllers\\VotingController@index');
            Route::get('/voting/indexCu/{id}', 'App\\Http\\Controllers\\VotingController@indexCu');
            Route::get('/voting/indexVoting', 'App\\Http\\Controllers\\VotingController@indexVoting');
            Route::get('/voting/indexVotingCu/{id}', 'App\\Http\\Controllers\\VotingController@indexVotingCu');
            Route::get('/voting/indexDataSuara/{id}', 'App\\Http\\Controllers\\VotingController@indexDataSuara');
            Route::get('/voting/indexDataTanggapan/{id}', 'App\\Http\\Controllers\\VotingController@indexDataTanggapan');
            Route::get('/voting/indexUser/{id}', 'App\\Http\\Controllers\\VotingController@indexUser');
            Route::get('/voting/checkUser/{voting_id}', 'App\\Http\\Controllers\\VotingController@checkUser');
            Route::get('/voting/edit/{id}', 'App\\Http\\Controllers\\VotingController@edit');
            Route::post('/voting/storeSuara', 'App\\Http\\Controllers\\VotingController@storeSuara');
            Route::post('/voting/updateSuara/{id}', 'App\\Http\\Controllers\\VotingController@updateSuara');
            Route::delete('/voting/destroySuara/{id}', 'App\\Http\\Controllers\\VotingController@destroySuara');
            Route::post('/voting/uploadSuara/{id}', 'App\\Http\\Controllers\\VotingController@uploadSuara');
        });
        Route::group(['middleware' => ['permission:create_voting']], function () {
            Route::get('/voting/create', 'App\\Http\\Controllers\\VotingController@create');
            Route::post('/voting/store', 'App\\Http\\Controllers\\VotingController@store');
        });
        Route::group(['middleware' => ['permission:update_voting']], function () {
            Route::get('/voting/updateStatus/{id}/{cu}', 'App\\Http\\Controllers\\VotingController@updateStatus');
            Route::post('/voting/updateSuaraCu', 'App\\Http\\Controllers\\VotingController@updateSuaraCu');
        });
        Route::group(['middleware' => ['permission:destroy_voting']], function () {
            Route::delete('/voting/{id}', 'App\\Http\\Controllers\\VotingController@destroy');
        });

        //kubn
        Route::get('/kubn/history', 'App\\Http\\Controllers\\KubnController@history');
        Route::get('/kubn/indexAnggota/{id}', 'App\\Http\\Controllers\\KubnController@indexAnggota');
        Route::get('/kubn/indexDiklat/{id}', 'App\\Http\\Controllers\\KubnController@indexDiklat');
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kubn', 'App\\Http\\Controllers\\KubnController@index');
            Route::get('/kubn/get', 'App\\Http\\Controllers\\KubnController@get');
            Route::get('/kubn/indexCu/{id}', 'App\\Http\\Controllers\\KubnController@indexCu');
            Route::get('/kubn/getCu/{id}', 'App\\Http\\Controllers\\KubnController@getCu');
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kubn/create', 'App\\Http\\Controllers\\KubnController@create');
            Route::post('/kubn/store', 'App\\Http\\Controllers\\KubnController@store');
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kubn/edit/{id}', 'App\\Http\\Controllers\\KubnController@edit');
            Route::post('/kubn/update/{id}', 'App\\Http\\Controllers\\KubnController@update');
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kubn/{id}', 'App\\Http\\Controllers\\KubnController@destroy');
        });

        //Kubn Usaha
        Route::get('/kubnUsaha/history', 'App\\Http\\Controllers\\KubnUsahaController@history');
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kubnUsaha', 'App\\Http\\Controllers\\KubnUsahaController@index');
            Route::get('/kubnUsaha/get', 'App\\Http\\Controllers\\KubnUsahaController@get');
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kubnUsaha/create', 'App\\Http\\Controllers\\KubnUsahaController@create');
            Route::post('/kubnUsaha/store', 'App\\Http\\Controllers\\KubnUsahaController@store');
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kubnUsaha/edit/{id}', 'App\\Http\\Controllers\\KubnUsahaController@edit');
            Route::post('/kubnUsaha/update/{id}', 'App\\Http\\Controllers\\KubnUsahaController@update');
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kubnUsaha/{id}', 'App\\Http\\Controllers\\KubnUsahaController@destroy');
        });

        //Kombas
        Route::get('/kombas/history', 'App\\Http\\Controllers\\KombasController@history');
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kombas/index/{tipe}', 'App\\Http\\Controllers\\KombasController@index');
            Route::get('/kombas/indexCu/{id}/{tipe}', 'App\\Http\\Controllers\\KombasController@indexCu');
            Route::get('/kombas/get', 'App\\Http\\Controllers\\KombasController@get');
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kombas/create', 'App\\Http\\Controllers\\KombasController@create');
            Route::post('/kombas/store', 'App\\Http\\Controllers\\KombasController@store');
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kombas/edit/{id}', 'App\\Http\\Controllers\\KombasController@edit');
            Route::post('/kombas/update/{id}', 'App\\Http\\Controllers\\KombasController@update');
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kombas/{id}', 'App\\Http\\Controllers\\KombasController@destroy');
        });

        //enterpreneur
        Route::get('/enterpreneur/history', 'App\\Http\\Controllers\\EnterpreneurController@history');
        Route::get('/enterpreneur/indexDiklat/{id}', 'App\\Http\\Controllers\\EnterpreneurController@indexDiklat');
        Route::group(['middleware' => ['permission:index_enterpreneur']], function () {
            Route::get('/enterpreneur', 'App\\Http\\Controllers\\EnterpreneurController@index');
            Route::get('/enterpreneur/get', 'App\\Http\\Controllers\\EnterpreneurController@get');
            Route::get('/enterpreneur/indexCu/{id}', 'App\\Http\\Controllers\\EnterpreneurController@indexCu');
            Route::get('/enterpreneur/getCu/{id}', 'App\\Http\\Controllers\\EnterpreneurController@getCu');
        });
        Route::group(['middleware' => ['permission:create_enterpreneur']], function () {
            Route::get('/enterpreneur/create', 'App\\Http\\Controllers\\EnterpreneurController@create');
            Route::post('/enterpreneur/store', 'App\\Http\\Controllers\\EnterpreneurController@store');
        });
        Route::group(['middleware' => ['permission:update_enterpreneur']], function () {
            Route::get('/enterpreneur/edit/{id}', 'App\\Http\\Controllers\\EnterpreneurController@edit');
            Route::post('/enterpreneur/update/{id}', 'App\\Http\\Controllers\\EnterpreneurController@update');
        });
        Route::group(['middleware' => ['permission:destroy_enterpreneur']], function () {
            Route::delete('/enterpreneur/{id}', 'App\\Http\\Controllers\\EnterpreneurController@destroy');
        });

        //umkm
        Route::get('/umkm/history', 'App\\Http\\Controllers\\UmkmController@history');
        Route::get('/umkm/indexDiklat/{id}', 'App\\Http\\Controllers\\UmkmController@indexDiklat');
        Route::group(['middleware' => ['permission:index_umkm']], function () {
            Route::get('/umkm', 'App\\Http\\Controllers\\UmkmController@index');
            Route::get('/umkm/get', 'App\\Http\\Controllers\\UmkmController@get');
            Route::get('/umkm/indexCu/{id}', 'App\\Http\\Controllers\\UmkmController@indexCu');
            Route::get('/umkm/getCu/{id}', 'App\\Http\\Controllers\\UmkmController@getCu');
        });
        Route::group(['middleware' => ['permission:create_umkm']], function () {
            Route::get('/umkm/create', 'App\\Http\\Controllers\\UmkmController@create');
            Route::post('/umkm/store', 'App\\Http\\Controllers\\UmkmController@store');
        });
        Route::group(['middleware' => ['permission:update_umkm']], function () {
            Route::get('/umkm/edit/{id}', 'App\\Http\\Controllers\\UmkmController@edit');
            Route::post('/umkm/update/{id}', 'App\\Http\\Controllers\\UmkmController@update');
        });
        Route::group(['middleware' => ['permission:destroy_umkm']], function () {
            Route::delete('/umkm/{id}', 'App\\Http\\Controllers\\UmkmController@destroy');
        });

        //mentor
        Route::get('/mentor/history', 'App\\Http\\Controllers\\MentorController@history');
        Route::get('/mentor/indexDiklat/{id}', 'App\\Http\\Controllers\\MentorController@indexDiklat');
        Route::group(['middleware' => ['permission:index_mentor']], function () {
            Route::get('/mentor', 'App\\Http\\Controllers\\MentorController@index');
            Route::get('/mentor/get', 'App\\Http\\Controllers\\MentorController@get');
            Route::get('/mentor/indexCu/{id}', 'App\\Http\\Controllers\\MentorController@indexCu');
            Route::get('/mentor/getCu/{id}', 'App\\Http\\Controllers\\MentorController@getCu');
        });
        Route::group(['middleware' => ['permission:create_mentor']], function () {
            Route::get('/mentor/create', 'App\\Http\\Controllers\\MentorController@create');
            Route::post('/mentor/store', 'App\\Http\\Controllers\\MentorController@store');
        });
        Route::group(['middleware' => ['permission:update_mentor']], function () {
            Route::get('/mentor/edit/{id}', 'App\\Http\\Controllers\\MentorController@edit');
            Route::post('/mentor/update/{id}', 'App\\Http\\Controllers\\MentorController@update');
        });
        Route::group(['middleware' => ['permission:destroy_mentor']], function () {
            Route::delete('/mentor/{id}', 'App\\Http\\Controllers\\MentorController@destroy');
        });

         //fasilitator
         Route::get('/fasilitator/history', 'App\\Http\\Controllers\\FasilitatorController@history');
         Route::get('/fasilitator/indexDiklat/{id}', 'App\\Http\\Controllers\\FasilitatorController@indexDiklat');
         Route::group(['middleware' => ['permission:index_fasilitator']], function () {
             Route::get('/fasilitator', 'App\\Http\\Controllers\\FasilitatorController@index');
             Route::get('/fasilitator/get', 'App\\Http\\Controllers\\FasilitatorController@get');
             Route::get('/fasilitator/indexCu/{id}', 'App\\Http\\Controllers\\FasilitatorController@indexCu');
             Route::get('/fasilitator/getCu/{id}', 'App\\Http\\Controllers\\FasilitatorController@getCu');
         });
         Route::group(['middleware' => ['permission:create_fasilitator']], function () {
             Route::get('/fasilitator/create', 'App\\Http\\Controllers\\FasilitatorController@create');
             Route::post('/fasilitator/store', 'App\\Http\\Controllers\\FasilitatorController@store');
         });
         Route::group(['middleware' => ['permission:update_fasilitator']], function () {
             Route::get('/fasilitator/edit/{id}', 'App\\Http\\Controllers\\FasilitatorController@edit');
             Route::post('/fasilitator/update/{id}', 'App\\Http\\Controllers\\FasilitatorController@update');
         });
         Route::group(['middleware' => ['permission:destroy_fasilitator']], function () {
             Route::delete('/fasilitator/{id}', 'App\\Http\\Controllers\\FasilitatorController@destroy');
         });

         //Keahlian
         Route::get('/keahlian/history', 'App\\Http\\Controllers\\KeahlianController@history');
         Route::get('/keahlian', 'App\\Http\\Controllers\\KeahlianController@index');
         Route::get('/keahlian/get', 'App\\Http\\Controllers\\KeahlianController@get');
         Route::group(['middleware' => ['permission:create_keahlian']], function () {
             Route::get('/keahlian/create', 'App\\Http\\Controllers\\KeahlianController@create');
             Route::post('/keahlian/store', 'App\\Http\\Controllers\\KeahlianController@store');
         });
         Route::group(['middleware' => ['permission:update_keahlian']], function () {
             Route::get('/keahlian/edit/{id}', 'App\\Http\\Controllers\\KeahlianController@edit');
             Route::post('/keahlian/update/{id}', 'App\\Http\\Controllers\\KeahlianController@update');
         });
         Route::group(['middleware' => ['permission:destroy_keahlian']], function () {
             Route::delete('/keahlian/{id}', 'App\\Http\\Controllers\\KeahlianController@destroy');
         });

        //Jenis Diklat
        Route::get('/jenisDiklat/history', 'App\\Http\\Controllers\\JenisDiklatController@history');
        Route::get('/jenisDiklat', 'App\\Http\\Controllers\\JenisDiklatController@index');
        Route::get('/jenisDiklat/get', 'App\\Http\\Controllers\\JenisDiklatController@get');
        Route::group(['middleware' => ['permission:create_jenis_diklat']], function () {
            Route::get('/jenisDiklat/create', 'App\\Http\\Controllers\\JenisDiklatController@create');
            Route::post('/jenisDiklat/store', 'App\\Http\\Controllers\\JenisDiklatController@store');
        });
        Route::group(['middleware' => ['permission:update_jenis_diklat']], function () {
            Route::get('/jenisDiklat/edit/{id}s', 'App\\Http\\Controllers\\JenisDiklatController@edit');
            Route::post('/jenisDiklat/update/{id}', 'App\\Http\\Controllers\\JenisDiklatController@update');
        });
        Route::group(['middleware' => ['permission:destroy_jenis_diklat']], function () {
            Route::delete('/jenisDiklat/{id}', 'App\\Http\\Controllers\\JenisDiklatController@destroy');
        });

        // puskopdit
        Route::get('/pus', 'App\\Http\\Controllers\\PusController@index');
        Route::get('/pus_all', 'App\\Http\\Controllers\\PusController@indexAll');
        Route::post('/pus/store', 'App\\Http\\Controllers\\PusController@store');

        // tempat 
        Route::get('/tempat', 'App\\Http\\Controllers\\TempatController@index');
        Route::get('/tempat/get/{id}', 'App\\Http\\Controllers\\TempatController@get');
        Route::get('/tempat/create', 'App\\Http\\Controllers\\TempatController@create');
        Route::get('/tempat/edit/{id}', 'App\\Http\\Controllers\\TempatController@edit');
        Route::post('/tempat/store', 'App\\Http\\Controllers\\TempatController@store');
        Route::post('/tempat/update/{id}', 'App\\Http\\Controllers\\TempatController@update');
        Route::delete('/tempat/{id}', 'App\\Http\\Controllers\\TempatController@destroy');

        //pekerjaan
        Route::get('/pekerjaan', 'App\\Http\\Controllers\\PekerjaanController@index');
        Route::get('/pekerjaan/get', 'App\\Http\\Controllers\\PekerjaanController@get');
        Route::get('/pekerjaan/create', 'App\\Http\\Controllers\\PekerjaanController@create');
        Route::get('/pekerjaan/edit/{id}', 'App\\Http\\Controllers\\PekerjaanController@edit');
        Route::post('/pekerjaan/store', 'App\\Http\\Controllers\\PekerjaanController@store');
        Route::post('/pekerjaan/update/{id}', 'App\\Http\\Controllers\\PekerjaanController@update');
        Route::delete('/pekerjaan/{id}', 'App\\Http\\Controllers\\PekerjaanController@destroy');

        //suku
        Route::get('/suku', 'App\\Http\\Controllers\\SukuController@index');
        Route::get('/suku/get', 'App\\Http\\Controllers\\SukuController@get');
        Route::get('/suku/create', 'App\\Http\\Controllers\\SukuController@create');
        Route::get('/suku/edit/{id}', 'App\\Http\\Controllers\\SukuController@edit');
        Route::post('/suku/store', 'App\\Http\\Controllers\\SukuController@store');
        Route::post('/suku/update/{id}', 'App\\Http\\Controllers\\SukuController@update');
        Route::delete('/suku/{id}', 'App\\Http\\Controllers\\SukuController@destroy');

        //provinces
        Route::get('/provinces', 'App\\Http\\Controllers\\ProvincesController@index');
        Route::get('/provinces/get', 'App\\Http\\Controllers\\ProvincesController@get');
        Route::get('/provinces/create', 'App\\Http\\Controllers\\ProvincesController@create');
        Route::get('/provinces/edit/{id}', 'App\\Http\\Controllers\\ProvincesController@edit');
        Route::post('/provinces/store', 'App\\Http\\Controllers\\ProvincesController@store');
        Route::post('/provinces/update/{id}', 'App\\Http\\Controllers\\ProvincesController@update');
        Route::delete('/provinces/{id}', 'App\\Http\\Controllers\\ProvincesController@destroy');

        //regencies
        Route::get('/regencies', 'App\\Http\\Controllers\\RegenciesController@index');
        Route::get('/regencies/get', 'App\\Http\\Controllers\\RegenciesController@get');
        Route::get('/regencies/indexProvinces/{id}', 'App\\Http\\Controllers\\RegenciesController@indexProvinces');
        Route::get('/regencies/getProvinces/{id}', 'App\\Http\\Controllers\\RegenciesController@getProvinces');
        Route::get('/regencies/create', 'App\\Http\\Controllers\\RegenciesController@create');
        Route::get('/regencies/edit/{id}', 'App\\Http\\Controllers\\RegenciesController@edit');
        Route::post('/regencies/store', 'App\\Http\\Controllers\\RegenciesController@store');
        Route::post('/regencies/update/{id}', 'App\\Http\\Controllers\\RegenciesController@update');
        Route::delete('/regencies/{id}', 'App\\Http\\Controllers\\RegenciesController@destroy');

        //districts
        Route::get('/districts', 'App\\Http\\Controllers\\DistrictsController@index');
        Route::get('/districts/get', 'App\\Http\\Controllers\\DistrictsController@get');
        Route::get('/districts/indexRegencies/{id}', 'App\\Http\\Controllers\\DistrictsController@indexRegencies');
        Route::get('/districts/getRegencies/{id}', 'App\\Http\\Controllers\\DistrictsController@getRegencies');
        Route::get('/districts/create', 'App\\Http\\Controllers\\DistrictsController@create');
        Route::get('/districts/edit/{id}', 'App\\Http\\Controllers\\DistrictsController@edit');
        Route::post('/districts/store', 'App\\Http\\Controllers\\DistrictsController@store');
        Route::post('/districts/update/{id}', 'App\\Http\\Controllers\\DistrictsController@update');
        Route::delete('/districts/{id}', 'App\\Http\\Controllers\\DistrictsController@destroy');

        //villages
        Route::get('/villages', 'App\\Http\\Controllers\\VillagesController@index');
        Route::get('/villages/get', 'App\\Http\\Controllers\\VillagesController@get');
        Route::get('/villages/indexDistricts/{id}', 'App\\Http\\Controllers\\VillagesController@indexDistricts');
        Route::get('/villages/getDistricts/{id}', 'App\\Http\\Controllers\\VillagesController@getDistricts');
        Route::get('/villages/create', 'App\\Http\\Controllers\\VillagesController@create');
        Route::get('/villages/edit/{id}', 'App\\Http\\Controllers\\VillagesController@edit');
        Route::post('/villages/store', 'App\\Http\\Controllers\\VillagesController@store');
        Route::post('/villages/update/{id}', 'App\\Http\\Controllers\\VillagesController@update');
        Route::delete('/villages/{id}', 'App\\Http\\Controllers\\VillagesController@destroy');

        // file
        Route::get('download/{filename}', 'App\\Http\\Controllers\\SystemController@download_file');
        Route::get('download_folder/{filename}/{foldername}', 'App\\Http\\Controllers\\SystemController@download_file_folder');
        Route::get('countOrganisasi', 'App\\Http\\Controllers\\SystemController@countOrganisasi');

        // notification
        Route::get('/notification/get', 'App\\Http\\Controllers\\NotificationController@get');
        Route::get('/notification/getAll', 'App\\Http\\Controllers\\NotificationController@getAll');
        Route::get('/notification/markRead/{id}', 'App\\Http\\Controllers\\NotificationController@markRead');
        Route::get('/notification/markAllRead', 'App\\Http\\Controllers\\NotificationController@markAllRead');

        //file upload
        Route::post('/fileUpload/store', 'App\\Http\\Controllers\\FileUploadController@store');
        Route::delete('/fileUpload/destroy/{id}', 'App\\Http\\Controllers\\FileUploadController@destroy');
        Route::get('/fileUpload/index/{id_cu}/{id_user}', 'App\\Http\\Controllers\\FileUploadController@index');

        //import csv
        Route::get('/anggotaCuImportEscete/index/{id_cu}', 'App\\Http\\Controllers\\AnggotaCuEsceteController@index');
        Route::post('/anggotaCuImportEscete/draft/{id_cu}/{id_user}', 'App\\Http\\Controllers\\AnggotaCuEsceteController@uploadDraft');
        Route::post('/anggotaCuImportEscete/simpandraft/{id_cu}', 'App\\Http\\Controllers\\AnggotaCuEsceteController@store');
    });
});
