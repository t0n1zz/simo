<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AktivisController;
use App\Http\Controllers\AnggotaCuController;
use App\Http\Controllers\AnggotaCuDraftController;
use App\Http\Controllers\AnggotaCuEsceteController;
use App\Http\Controllers\AnggotaProdukCuController;
use App\Http\Controllers\AnggotaProdukCuDraftController;
use App\Http\Controllers\ArtikelController;
use App\Http\Controllers\ArtikelKategoriController;
use App\Http\Controllers\ArtikelPenulisController;
use App\Http\Controllers\ArtikelSimoController;
use App\Http\Controllers\AsetTetapController;
use App\Http\Controllers\AsetTetapGolonganController;
use App\Http\Controllers\AsetTetapJenisController;
use App\Http\Controllers\AsetTetapKelompokController;
use App\Http\Controllers\AsetTetapLokasiController;
use App\Http\Controllers\AssesmentAccessController;
use App\Http\Controllers\AssesmentCulegController;
use App\Http\Controllers\CoaController;
use App\Http\Controllers\CuController;
use App\Http\Controllers\DistrictsController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\DokumenKategoriController;
use App\Http\Controllers\EditorController;
use App\Http\Controllers\EnterpreneurController;
use App\Http\Controllers\ErrorLogController;
use App\Http\Controllers\FasilitatorController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\JalinanIuranController;
use App\Http\Controllers\JalinanKlaimController;
use App\Http\Controllers\JenisDiklatController;
use App\Http\Controllers\KeahlianController;
use App\Http\Controllers\KegiatanBKCUController;
use App\Http\Controllers\KegiatanRekomController;
use App\Http\Controllers\KodeKegiatanController;
use App\Http\Controllers\KombasController;
use App\Http\Controllers\KubnController;
use App\Http\Controllers\KubnUsahaController;
use App\Http\Controllers\LaporanCuController;
use App\Http\Controllers\LaporanCuDiskusiController;
use App\Http\Controllers\LaporanCuDraftController;
use App\Http\Controllers\LaporanGerakanController;
use App\Http\Controllers\LaporanTpController;
use App\Http\Controllers\LaporanTpDiskusiController;
use App\Http\Controllers\LaporanTpDraftController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\MentorController;
use App\Http\Controllers\MitraLembagaController;
use App\Http\Controllers\MitraOrangController;
use App\Http\Controllers\MonitoringController;
use App\Http\Controllers\MonitoringCuController;
use App\Http\Controllers\MonitoringPencapaianController;
use App\Http\Controllers\MonitoringPencapaianCuController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PekerjaanController;
use App\Http\Controllers\PemilihanController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\ProdukCuController;
use App\Http\Controllers\ProvincesController;
use App\Http\Controllers\PusController;
use App\Http\Controllers\RegenciesController;
use App\Http\Controllers\SaranController;
use App\Http\Controllers\SertifikatController;
use App\Http\Controllers\SukuController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\SuratKategoriController;
use App\Http\Controllers\SuratKodeController;
use App\Http\Controllers\SuratMasukController;
use App\Http\Controllers\SystemController;
use App\Http\Controllers\TempatController;
use App\Http\Controllers\TpController;
use App\Http\Controllers\UmkmController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VillagesController;
use App\Http\Controllers\VotingController;

Route::group(['middleware' => 'throttle:1000,1', 'withoutMiddleware' => 'throttle:api'], function () {
    // pemilihan
    Route::get('/pemilihan/indexCalon/{name}', [PemilihanController::class, 'indexCalon']);
    Route::get('/pemilihan/indexCalonTerpilih/{id}', [PemilihanController::class, 'indexCalonTerpilih']);
    Route::post('/pemilihan/storePilihan', [PemilihanController::class, 'storePilihan']);
    Route::post('/pemilihan/storeMultiPilihan', [PemilihanController::class, 'storeMultiPilihan']);

    // voting
    Route::get('/voting/indexPilihan/{name}', [VotingController::class, 'indexPilihan']);
    Route::get('/voting/indexSuara/{id}', [VotingController::class, 'indexSuara']);
    Route::post('/voting/storePilihan', [VotingController::class, 'storePilihan']);

    // aset tetap
    Route::get('/asetTetap/get/{kode}', [AsetTetapController::class, 'get']);
});

Route::group(['middleware' => 'throttle:200,1'], function () {

    Route::group(['prefix' => 'auth'], function ($router) {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/refresh', [AuthController::class, 'refresh'])->middleware('auth:sanctum');
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::get('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
    });

    Route::group(['middleware' => 'auth:sanctum'], function () {

        // Route::group(['prefix'=>'v1'],function(){

        // auth
        // Route::get('/userId', [AuthController::class, 'userId']);
        // Route::get('/profile', [AuthController::class, 'profile']);

        // editor (centralized image upload for all rich text editors)
        Route::post('/editor/upload-image', [EditorController::class, 'uploadImage']);
        Route::post('/editor/cleanup-images', [EditorController::class, 'cleanupImages']);

        // system
        Route::get('/system/version', [SystemController::class, 'version']);

        // user
        Route::get('/user/indexActivity', [UserController::class, 'indexActivity']);
        Route::get('/user/getActivity/{id}', [UserController::class, 'getActivity']);
        Route::post('/user/updatePassword/{id}', [UserController::class, 'updatePassword']);
        Route::post('/user/updateFoto/{id}', [UserController::class, 'updateFoto']);
        Route::post('/user/updateIdentitas/{id}', [UserController::class, 'updateIdentitas']);
        Route::get('/user/indexCuPermission/{id}', [UserController::class, 'indexCuPermission']);

        Route::group(['middleware' => ['permission:index_user']], function () {
            Route::get('/user', [UserController::class, 'index']);
            Route::get('/user/indexCu/{id}', [UserController::class, 'indexCu']);
            Route::get('/user/count', [UserController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_user']], function () {
            Route::get('/user/create', [UserController::class, 'create']);
            Route::post('/user/store', [UserController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_user']], function () {
            Route::get('/user/edit/{id}', [UserController::class, 'edit']);
            Route::get('/user/editHakAkses/{id}', [UserController::class, 'editHakAkses']);
            Route::post('/user/update/{id}', [UserController::class, 'update']);
            Route::post('/user/updateStatus/{id}', [UserController::class, 'updateStatus']);
            Route::post('/user/updateHakAkses/{id}', [UserController::class, 'updateHakAkses']);
            Route::post('/user/updateResetPassword/{id}', [UserController::class, 'updateResetPassword']);
        });
        Route::group(['middleware' => ['permission:destroy_user']], function () {
            Route::delete('/user/{id}', [UserController::class, 'destroy']);
        });

        // media
        Route::get('/media/count', [MediaController::class, 'count']);
        Route::get('/media/history', [MediaController::class, 'history']);
        Route::group(['middleware' => ['permission:index_media']], function () {
            Route::get('/media', [MediaController::class, 'index']);
            Route::get('/media/indexCu/{id}', [MediaController::class, 'indexCu']);
        });
        Route::group(['middleware' => ['permission:create_media']], function () {
            Route::get('/media/create', [MediaController::class, 'create']);
            Route::post('/media/store', [MediaController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_media']], function () {
            Route::get('/media/edit/{id}', [MediaController::class, 'edit']);
            Route::post('/media/update/{id}', [MediaController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_media']], function () {
            Route::delete('/media/{id}', [MediaController::class, 'destroy']);
        });

        // artikel
        Route::get('/artikel/count', [ArtikelController::class, 'count']);
        Route::get('/artikel/history', [ArtikelController::class, 'history']);
        Route::group(['middleware' => ['permission:index_artikel']], function () {
            Route::get('/artikel', [ArtikelController::class, 'index']);
            Route::get('/artikel/indexCu/{id}', [ArtikelController::class, 'indexCu']);
            Route::post('/artikel/upload', [ArtikelController::class, 'upload']);
        });
        Route::group(['middleware' => ['permission:create_artikel']], function () {
            Route::get('/artikel/create', [ArtikelController::class, 'create']);
            Route::post('/artikel/store', [ArtikelController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_artikel']], function () {
            Route::get('/artikel/edit/{id}', [ArtikelController::class, 'edit']);
            Route::post('/artikel/update/{id}', [ArtikelController::class, 'update']);
            Route::post('/artikel/updateTerbitkan/{id}', [ArtikelController::class, 'updateTerbitkan']);
            Route::post('/artikel/updateUtamakan/{id}', [ArtikelController::class, 'updateUtamakan']);
        });
        Route::group(['middleware' => ['permission:destroy_artikel']], function () {
            Route::delete('/artikel/{id}', [ArtikelController::class, 'destroy']);
        });

        // artikel kategori
        Route::get('/artikelKategori/history', [ArtikelKategoriController::class, 'history']);
        Route::group(['middleware' => ['permission:index_artikel_kategori']], function () {
            Route::get('/artikelKategori', [ArtikelKategoriController::class, 'index']);
            Route::get('/artikelKategori/get', [ArtikelKategoriController::class, 'get']);
            Route::get('/artikelKategori/indexCu/{id}', [ArtikelKategoriController::class, 'indexCu']);
            Route::get('/artikelKategori/getCu/{id}', [ArtikelKategoriController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_artikel_kategori']], function () {
            Route::get('/artikelKategori/create', [ArtikelKategoriController::class, 'create']);
            Route::post('/artikelKategori/store', [ArtikelKategoriController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_artikel_kategori']], function () {
            Route::get('/artikelKategori/edit/{id}', [ArtikelKategoriController::class, 'edit']);
            Route::post('/artikelKategori/update/{id}', [ArtikelKategoriController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_artikel_kategori']], function () {
            Route::delete('/artikelKategori/{id}', [ArtikelKategoriController::class, 'destroy']);
        });

        // artikel penulis
        Route::get('/artikelPenulis/count', [ArtikelPenulisController::class, 'count']);
        Route::get('/artikelPenulis/history', [ArtikelPenulisController::class, 'history']);
        Route::get('/artikelPenulis', [ArtikelPenulisController::class, 'index']);
        Route::get('/artikelPenulis/get', [ArtikelPenulisController::class, 'get']);
        Route::group(['middleware' => ['permission:index_artikel_penulis']], function () {
            Route::get('/artikelPenulis/indexCu/{id}', [ArtikelPenulisController::class, 'indexCu']);
            Route::get('/artikelPenulis/getCu/{id}', [ArtikelPenulisController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_artikel_penulis']], function () {
            Route::get('/artikelPenulis/create', [ArtikelPenulisController::class, 'create']);
            Route::post('/artikelPenulis/store', [ArtikelPenulisController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_artikel_penulis']], function () {
            Route::get('/artikelPenulis/edit/{id}', [ArtikelPenulisController::class, 'edit']);
            Route::post('/artikelPenulis/update/{id}', [ArtikelPenulisController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_artikel_penulis']], function () {
            Route::delete('/artikelPenulis/{id}', [ArtikelPenulisController::class, 'destroy']);
        });

        // artikel simo
        Route::get('/artikelSimo', [ArtikelSimoController::class, 'index']);
        Route::get('/artikelSimo/get', [ArtikelSimoController::class, 'get']);
        Route::post('/artikelSimo/upload', [ArtikelSimoController::class, 'upload']);
        Route::get('/artikelSimo/count', [ArtikelSimoController::class, 'count']);
        Route::get('/artikelSimo/history', [ArtikelSimoController::class, 'history']);
        Route::group(['middleware' => ['permission:create_artikel']], function () {
            Route::get('/artikelSimo/create', [ArtikelSimoController::class, 'create']);
            Route::post('/artikelSimo/store', [ArtikelSimoController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_artikel']], function () {
            Route::get('/artikelSimo/edit/{id}', [ArtikelSimoController::class, 'edit']);
            Route::post('/artikelSimo/update/{id}', [ArtikelSimoController::class, 'update']);
            Route::post('/artikelSimo/updateUtamakan/{id}', [ArtikelSimoController::class, 'updateUtamakan']);
        });
        Route::group(['middleware' => ['permission:destroy_artikel']], function () {
            Route::delete('/artikelSimo/{id}', [ArtikelSimoController::class, 'destroy']);
        });

        // cu
        Route::get('/cu/count', [CuController::class, 'count']);
        Route::get('/cu/history', [CuController::class, 'history']);
        Route::get('/cu/getHeader', [CuController::class, 'getHeader']);
        Route::get('/cu/escete/{id}', [CuController::class, 'escete']);
        Route::get('/cu/getUpdateESCETE', [CuController::class, 'getUpdateESCETE']);
        Route::group(['middleware' => ['permission:index_cu']], function () {
            Route::get('/cu', [CuController::class, 'index']);
            Route::get('/cu/deleted', [CuController::class, 'indexDeleted']);
            Route::get('/cu/get', [CuController::class, 'get']);
            Route::get('/cu/getPus/{id}', [CuController::class, 'getPus']);
            Route::get('/cu/edit/{id}', [CuController::class, 'edit']);
        });
        Route::group(['middleware' => ['permission:create_cu']], function () {
            Route::get('/cu/create', [CuController::class, 'create']);
            Route::post('/cu/store', [CuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_cu']], function () {
            Route::post('/cu/update/{id}', [CuController::class, 'update']);
            Route::post('/cu/restore/{id}', [CuController::class, 'restore']);
        });
        Route::group(['middleware' => ['permission:destroy_cu']], function () {
            Route::delete('/cu/{id}', [CuController::class, 'destroy']);
        });
        Route::get('/cu/getBirthday', [CuController::class, 'getBirthday']);

        // tp
        Route::get('/tp/count', [TpController::class, 'count']);
        Route::get('/tp/history', [TpController::class, 'history']);
        Route::get('/tp/getCu/{id}', [TpController::class, 'getCu']);
        Route::group(['middleware' => ['permission:index_tp']], function () {
            Route::get('/tp', [TpController::class, 'index']);
            Route::get('/tp/get', [TpController::class, 'get']);
            Route::get('/tp/indexCu/{id}', [TpController::class, 'indexCu']);
        });
        Route::group(['middleware' => ['permission:create_tp']], function () {
            Route::get('/tp/create', [TpController::class, 'create']);
            Route::post('/tp/store', [TpController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_tp']], function () {
            Route::get('/tp/edit/{id}', [TpController::class, 'edit']);
            Route::post('/tp/update/{id}', [TpController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_tp']], function () {
            Route::delete('/tp/{id}', [TpController::class, 'destroy']);
        });

        // produk
        Route::get('/produkcu/getCu/{id}', [ProdukCuController::class, 'getCu']);
        Route::get('/produkcu/getCuJalinan/{id}', [ProdukCuController::class, 'getCuJalinan']);
        Route::get('/produkcu/getSimpananCu/{id}', [ProdukCuController::class, 'getSimpananCu']);
        Route::get('/produkcu/getPinjamanCu/{id}', [ProdukCuController::class, 'getPinjamanCu']);
        Route::get('/produkcu/count', [ProdukCuController::class, 'count']);
        Route::get('/produkcu/history', [ProdukCuController::class, 'history']);
        Route::group(['middleware' => ['permission:index_produk_cu']], function () {
            Route::get('/produkcu', [ProdukCuController::class, 'index']);
            Route::get('/produkcu/get', [ProdukCuController::class, 'get']);
            Route::get('/produkcu/indexCu/{id}', [ProdukCuController::class, 'indexCu']);
        });
        Route::group(['middleware' => ['permission:create_produk_cu']], function () {
            Route::get('/produkcu/create', [ProdukCuController::class, 'create']);
            Route::post('/produkcu/store', [ProdukCuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_produk_cu']], function () {
            Route::get('/produkcu/edit/{id}', [ProdukCuController::class, 'edit']);
            Route::post('/produkcu/update/{id}', [ProdukCuController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_produk_cu']], function () {
            Route::delete('/produkcu/{id}', [ProdukCuController::class, 'destroy']);
        });

        // booking nomor sertifikat
        Route::post('/sertifikatKegiatan/uploadExcelPeserta', [SertifikatController::class, 'uploadExcelPeserta']);
        Route::post('/sertifikatKegiatan/storeNomorSertifikatKegiatan/{id}', [SertifikatController::class, 'storeNomorSertifikatKegiatan']);
        Route::get('/sertifikatKegiatan/index', [SertifikatController::class, 'indexNomorSertifikat']);
        Route::post('/sertifikatKegiatan/updateNomorSertifikatKegiatan/{id}', [SertifikatController::class, 'updateNomorSertifikatKegiatan']);
        Route::delete('/sertifikatKegiatan/destroyNomorSertifikatKegiatan/{id}', [SertifikatController::class, 'destroyNomorSertifikatKegiatan']);

        // sertifikat kegiatan
        Route::get('/sertifikatKegiatan', [SertifikatController::class, 'index']);
        Route::get('/sertifikatKegiatan/create', [SertifikatController::class, 'create']);
        Route::post('/sertifikatKegiatan/store', [SertifikatController::class, 'store']);
        Route::get('/sertifikatKegiatan/edit/{id}', [SertifikatController::class, 'edit']);
        Route::get('/sertifikatKegiatan/editFormNomor/{id}', [SertifikatController::class, 'editFormNomor']);
        Route::post('/sertifikatKegiatan/update/{id}', [SertifikatController::class, 'update']);
        Route::delete('/sertifikatKegiatan/{id}', [SertifikatController::class, 'destroy']);

        // generate sertifikat
        Route::post('/generateSertifikat', [SertifikatController::class, 'generateSertifikat']);

        // kode kegiatan
        Route::get('/kodeKegiatan', [KodeKegiatanController::class, 'index']);
        Route::get('/kodeKegiatan/get', [KodeKegiatanController::class, 'get']);
        Route::get('/kodeKegiatan/create', [KodeKegiatanController::class, 'create']);
        Route::post('/kodeKegiatan/store', [KodeKegiatanController::class, 'store']);
        Route::get('/kodeKegiatan/edit/{id}', [KodeKegiatanController::class, 'edit']);
        Route::post('/kodeKegiatan/update/{id}', [KodeKegiatanController::class, 'update']);
        Route::delete('/kodeKegiatan/{id}', [KodeKegiatanController::class, 'destroy']);

        // kegiatan bkcu
        Route::get('/kegiatanBKCU/index/{kegiatan_tipe}', [KegiatanBKCUController::class, 'index']);
        Route::get('/kegiatanBKCU/baru', [KegiatanBKCUController::class, 'indexBaru']);
        Route::get('/kegiatanBKCU/mulai', [KegiatanBKCUController::class, 'indexMulai']);
        Route::get('/kegiatanBKCU/buka', [KegiatanBKCUController::class, 'indexBuka']);
        Route::get('/kegiatanBKCU/jalan', [KegiatanBKCUController::class, 'indexJalan']);
        Route::get('/kegiatanBKCU/diikuti', [KegiatanBKCUController::class, 'indexDiikuti']);
        Route::get('/kegiatanBKCU/kegiatan', [KegiatanBKCUController::class, 'indexKegiatan']);
        Route::get('/kegiatanBKCU/periode/{kegiatan_tipe}/{periode}', [KegiatanBKCUController::class, 'indexPeriode']);
        Route::get('/kegiatanBKCU/indexPisah/{kegiatan_tipe}/{periode}/{status}', [KegiatanBKCUController::class, 'indexPisah']);
        Route::get('/kegiatanBKCU/indexSemuaPeserta/{tipe_kegiatan}', [KegiatanBKCUController::class, 'indexSemuaPeserta']);
        Route::get('/kegiatanBKCU/indexSemuaPesertaMitra/{tipe_kegiatan}', [KegiatanBKCUController::class, 'indexSemuaPesertaMitra']);
        Route::get('/kegiatanBKCU/indexSemuaPesertaCu/{tipe_kegiatan}/cu/{id}', [KegiatanBKCUController::class, 'indexSemuaPesertaCu']);
        Route::get('/kegiatanBKCU/indexSemuaPanitia', [KegiatanBKCUController::class, 'indexSemuaPanitia']);
        Route::get('/kegiatanBKCU/indexSemuaPanitiaCu/{id}', [KegiatanBKCUController::class, 'indexSemuaPanitiaCu']);
        Route::get('/kegiatanBKCU/indexSemuaFasilitator', [KegiatanBKCUController::class, 'indexSemuaFasilitator']);
        Route::get('/kegiatanBKCU/indexSemuaFasilitatorCu/{id}', [KegiatanBKCUController::class, 'indexSemuaFasilitatorCu']);
        Route::get('/kegiatanBKCU/indexPeserta/{id}', [KegiatanBKCUController::class, 'indexPeserta']);
        Route::get('/kegiatanBKCU/indexMateri/{id}', [KegiatanBKCUController::class, 'indexMateri']);
        Route::get('/kegiatanBKCU/indexListMateri/{id}', [KegiatanBKCUController::class, 'indexListMateri']);
        Route::get('/kegiatanBKCU/indexPanitia/{id}', [KegiatanBKCUController::class, 'indexPanitia']);
        Route::get('/kegiatanBKCU/indexNilaiListMateri/{id}', [KegiatanBKCUController::class, 'indexNilaiListMateri']);
        Route::get('/kegiatanBKCU/indexKeputusan/{id}', [KegiatanBKCUController::class, 'indexKeputusan']);
        Route::get('/kegiatanBKCU/indexKeputusanKomentar/{id}', [KegiatanBKCUController::class, 'indexKeputusanKomentar']);
        Route::get('/kegiatanBKCU/indexPertanyaan/{id}', [KegiatanBKCUController::class, 'indexPertanyaan']);
        Route::get('/kegiatanBKCU/indexPertanyaanKomentar/{id}', [KegiatanBKCUController::class, 'indexPertanyaanKomentar']);
        Route::get('/kegiatanBKCU/indexTugas/{id}', [KegiatanBKCUController::class, 'indexTugas']);
        Route::get('/kegiatanBKCU/indexTugasJawaban/{id}', [KegiatanBKCUController::class, 'indexTugasJawaban']);
        Route::get('/kegiatanBKCU/indexPesertaHadir/{id}', [KegiatanBKCUController::class, 'indexPesertahadir']);
        Route::get('/kegiatanBKCU/indexPesertaCu/{id}/cu/{cu}', [KegiatanBKCUController::class, 'indexPesertaCu']);
        Route::get('/kegiatanBKCU/indexPesertaCountCu/{id}', [KegiatanBKCUController::class, 'indexPesertaCountCu']);
        Route::get('/kegiatanBKCU/indexPesertaHadirCountCu/{id}', [KegiatanBKCUController::class, 'indexPesertaHadirCountCu']);
        Route::get('/kegiatanBKCU/indexKeputusanCount/{id}', [KegiatanBKCUController::class, 'indexKeputusanCount']);
        Route::get('/kegiatanBKCU/indexPertanyaanCount/{id}', [KegiatanBKCUController::class, 'indexPertanyaanCount']);
        Route::get('/kegiatanBKCU/getPeriode/{kegiatan_tipe}', [KegiatanBKCUController::class, 'getPeriode']);
        Route::get('/kegiatanBKCU/edit/{id}', [KegiatanBKCUController::class, 'edit']);
        Route::get('/kegiatanBKCU/checkPeserta/{kegiatan_id}/{aktivis_id}', [KegiatanBKCUController::class, 'checkPeserta']);
        Route::get('/kegiatanBKCU/checkPanitia/{kegiatan_id}/{aktivis_id}', [KegiatanBKCUController::class, 'checkPanitia']);
        Route::post('/kegiatanBKCU/getNomorSertifikat/{id}', [KegiatanBKCUController::class, 'getNomorSertifikat']);
        Route::post('/kegiatanBKCU/updatePesertaHadir/{kegiatan_id}/{aktivis_id}', [KegiatanBKCUController::class, 'updatePesertaHadir']);
        Route::post('/kegiatanBKCU/updatePanitiaHadir/{kegiatan_id}/{aktivis_id}', [KegiatanBKCUController::class, 'updatePanitiaHadir']);
        Route::get('/kegiatanBKCU/countJalan', [KegiatanBKCUController::class, 'countJalan']);
        Route::get('/kegiatanBKCU/countDiikuti', [KegiatanBKCUController::class, 'countDiikuti']);
        Route::get('/kegiatanBKCU/countPeserta/{id}', [KegiatanBKCUController::class, 'countPeserta']);
        Route::get('/kegiatanBKCU/countPesertaHadir/{id}', [KegiatanBKCUController::class, 'countPesertaHadir']);
        Route::get('/kegiatanBKCU/countKeputusan/{id}/{cu}/{user}', [KegiatanBKCUController::class, 'countKeputusan']);
        Route::post('/kegiatanBKCU/storeKeputusan/{id}', [KegiatanBKCUController::class, 'storeKeputusan']);
        Route::post('/kegiatanBKCU/updateKeputusan/{id}', [KegiatanBKCUController::class, 'updateKeputusan']);
        Route::delete('/kegiatanBKCU/destroyKeputusan/{id}', [KegiatanBKCUController::class, 'destroyKeputusan']);
        Route::post('/kegiatanBKCU/storeKeputusanKomentar/{id}', [KegiatanBKCUController::class, 'storeKeputusanKomentar']);
        Route::post('/kegiatanBKCU/updateKeputusanKomentar/{id}', [KegiatanBKCUController::class, 'updateKeputusanKomentar']);
        Route::delete('/kegiatanBKCU/destroyKeputusanKomentar/{id}', [KegiatanBKCUController::class, 'destroyKeputusanKomentar']);
        Route::get('/kegiatanBKCU/countPertanyaan/{id}/{cu}/{user}', [KegiatanBKCUController::class, 'countPertanyaan']);
        Route::post('/kegiatanBKCU/storePertanyaan/{id}', [KegiatanBKCUController::class, 'storePertanyaan']);
        Route::post('/kegiatanBKCU/updatePertanyaan/{id}', [KegiatanBKCUController::class, 'updatePertanyaan']);
        Route::delete('/kegiatanBKCU/destroyPertanyaan/{id}', [KegiatanBKCUController::class, 'destroyPertanyaan']);
        Route::post('/kegiatanBKCU/storePertanyaanKomentar/{id}', [KegiatanBKCUController::class, 'storePertanyaanKomentar']);
        Route::post('/kegiatanBKCU/updatePertanyaanKomentar/{id}', [KegiatanBKCUController::class, 'updatePertanyaanKomentar']);
        Route::post('/kegiatanBKCU/jawabanPertanyaan/{id}/{tipe}', [KegiatanBKCUController::class, 'jawabanPertanyaan']);
        Route::delete('/kegiatanBKCU/destroyPertanyaanKomentar/{id}', [KegiatanBKCUController::class, 'destroyPertanyaanKomentar']);
        Route::post('/kegiatanBKCU/storePeserta/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'storePeserta']);
        Route::post('/kegiatanBKCU/updatePeserta/{id}', [KegiatanBKCUController::class, 'updatePeserta']);
        Route::delete('/kegiatanBKCU/destroyPeserta/{id}', [KegiatanBKCUController::class, 'destroyPeserta']);
        Route::post('/kegiatanBKCU/batalPeserta/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'batalPeserta']);
        Route::get('/kegiatanBKCU/create', [KegiatanBKCUController::class, 'create']);
        Route::post('/kegiatanBKCU/store/{kegiatan_tipe}', [KegiatanBKCUController::class, 'store']);
        Route::post('/kegiatanBKCU/update/{id}', [KegiatanBKCUController::class, 'update']);
        Route::post('/kegiatanBKCU/updateStatus/{id}', [KegiatanBKCUController::class, 'updateStatus']);
        Route::post('/kegiatanBKCU/storeMateri/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'storeMateri']);
        Route::post('/kegiatanBKCU/updateMateri/{id}', [KegiatanBKCUController::class, 'updateMateri']);
        Route::delete('/kegiatanBKCU/destroyMateri/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'destroyMateri']);
        Route::delete('/kegiatanBKCU/{id}', [KegiatanBKCUController::class, 'destroy']);
        Route::post('/kegiatanBKCU/storeTugas/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'storeTugas']);
        Route::post('/kegiatanBKCU/storeTugasJawaban/{kegiatan_tipe}', [KegiatanBKCUController::class, 'storeTugasJawaban']);
        Route::get('/kegiatanBKCU/editTugasJawaban/{id}', [KegiatanBKCUController::class, 'editTugasJawaban']);
        Route::post('/kegiatanBKCU/updateTugas/{id}', [KegiatanBKCUController::class, 'updateTugas']);
        Route::post('/kegiatanBKCU/updateTugasJawaban/{id}', [KegiatanBKCUController::class, 'updateTugasJawaban']);
        Route::delete('/kegiatanBKCU/destroyTugas/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'destroyTugas']);
        Route::delete('/kegiatanBKCU/destroyTugasJawaban/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'destroyTugasJawaban']);
        Route::post('/kegiatanBKCU/penerimaSertifikat', [KegiatanBKCUController::class, 'PenerimaSertifikat']);

        Route::post('/kegiatanBKCU/storeListMateri/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'storeListMateri']);
        Route::get('/kegiatanBKCU/editNilai/{id}/{kegiatan_id}', [KegiatanBKCUController::class, 'editNilai']);
        Route::post('/kegiatanBKCU/saveNilai/{id}', [KegiatanBKCUController::class, 'saveNilai']);
        Route::post('/kegiatanBKCU/updateListMateri/{id}', [KegiatanBKCUController::class, 'updateListMateri']);
        Route::delete('/kegiatanBKCU/destroyListMateri/{kegiatan_tipe}/{id}', [KegiatanBKCUController::class, 'destroyListMateri']);

        // kegiatan rekom
        Route::get('/kegiatanRekom/history', [KegiatanRekomController::class, 'history']);
        Route::get('/kegiatanRekom', [KegiatanRekomController::class, 'index']);
        Route::get('/kegiatanRekom/get', [KegiatanRekomController::class, 'get']);
        Route::get('/kegiatanRekom/indexKegiatan/{id}', [KegiatanRekomController::class, 'indexKegiatan']);
        Route::get('/kegiatanRekom/indexHasil/{id}', [KegiatanRekomController::class, 'indexHasil']);
        Route::get('/kegiatanRekom/create', [KegiatanRekomController::class, 'create']);
        Route::post('/kegiatanRekom/store', [KegiatanRekomController::class, 'store']);
        Route::get('/kegiatanRekom/edit/{id}', [KegiatanRekomController::class, 'edit']);
        Route::post('/kegiatanRekom/update/{id}', [KegiatanRekomController::class, 'update']);
        Route::delete('/kegiatanRekom/{id}', [KegiatanRekomController::class, 'destroy']);

        // kegiatan rekom hasil
        Route::post('/kegiatanRekom/storeHasil', [KegiatanRekomController::class, 'storeHasil']);
        Route::post('/kegiatanRekom/updateHasil/{id}', [KegiatanRekomController::class, 'updateHasil']);
        Route::delete('/kegiatanRekom/destroyHasil/{id}', [KegiatanRekomController::class, 'destroyHasil']);

        // aktivis
        Route::get('/aktivis/get/{id}', [AktivisController::class, 'get']);
        Route::get('/aktivis/get_monitoring_cu/{id}', [AktivisController::class, 'get_monitoring_cu']);
        Route::get('/aktivis/history', [AktivisController::class, 'history']);
        Route::get('/aktivis/cariData/{nik}', [AktivisController::class, 'cariData']);
        Route::get('/aktivis/count', [AktivisController::class, 'count']);
        Route::get('/aktivis/edit/{id}', [AktivisController::class, 'edit']);
        Route::post('/aktivis/update/{id}', [AktivisController::class, 'update']);
        Route::get('/aktivis/indexPekerjaan/{id}', [AktivisController::class, 'indexPekerjaan']);
        Route::get('/aktivis/indexPendidikan/{id}', [AktivisController::class, 'indexPendidikan']);
        Route::get('/aktivis/indexAnggotaCu/{id}', [AktivisController::class, 'indexAnggotaCu']);
        Route::get('/aktivis/indexKeluarga/{id}', [AktivisController::class, 'indexKeluarga']);
        Route::get('/aktivis/indexOrganisasi/{id}', [AktivisController::class, 'indexOrganisasi']);
        Route::get('/aktivis/indexDiklat/{id}', [AktivisController::class, 'indexDiklat']);
        Route::get('/aktivis/indexPertemuan/{id}', [AktivisController::class, 'indexPertemuan']);
        Route::get('/aktivis/indexKeterangan/{id}', [AktivisController::class, 'indexKeterangan']);
        Route::get('/aktivis/createPekerjaan', [AktivisController::class, 'createPekerjaan']);
        Route::get('/aktivis/createPendidikan', [AktivisController::class, 'createPendidikan']);
        Route::get('/aktivis/createOrganisasi', [AktivisController::class, 'createOrganisasi']);
        Route::get('/aktivis/createDiklat', [AktivisController::class, 'createDiklat']);
        Route::get('/aktivis/createKeluarga', [AktivisController::class, 'createKeluarga']);
        Route::get('/aktivis/createAnggotaCu', [AktivisController::class, 'createAnggotaCu']);
        Route::post('/aktivis/savePekerjaan/{id}', [AktivisController::class, 'savePekerjaan']);
        Route::post('/aktivis/savePendidikan/{id}', [AktivisController::class, 'savePendidikan']);
        Route::post('/aktivis/saveOrganisasi/{id}', [AktivisController::class, 'saveOrganisasi']);
        Route::post('/aktivis/saveDiklat/{id}', [AktivisController::class, 'saveDiklat']);
        Route::post('/aktivis/saveKeluarga/{id}', [AktivisController::class, 'saveKeluarga']);
        Route::post('/aktivis/saveAnggotaCu/{id}', [AktivisController::class, 'saveAnggotaCu']);
        Route::delete('/aktivis/pekerjaan/{id}', [AktivisController::class, 'destroyPekerjaan']);
        Route::delete('/aktivis/pendidikan/{id}', [AktivisController::class, 'destroyPendidikan']);
        Route::delete('/aktivis/organisasi/{id}', [AktivisController::class, 'destroyOrganisasi']);
        Route::delete('/aktivis/diklat/{id}', [AktivisController::class, 'destroyDiklat']);
        Route::delete('/aktivis/keterangan/{id}', [AktivisController::class, 'destroyKeterangan']);
        Route::post('/aktivis/saveKeterangan/{id}', [AktivisController::class, 'saveKeterangan']);
        Route::delete('/aktivis/keluarga/{id}', [AktivisController::class, 'destroyKeluarga']);
        Route::delete('/aktivis/anggotaCu/{id}', [AktivisController::class, 'destroyAnggotaCu']);
        Route::get('/aktivis/index/{tingkat}/{status}', [AktivisController::class, 'index']);
        Route::post('/aktivis/indexTingkat/', [AktivisController::class, 'indexTingkat']);
        Route::get('/aktivis/indexLembaga', [AktivisController::class, 'indexLembaga']);
        Route::get('/aktivis/indexCu/{id}/{tingkat}/{status}', [AktivisController::class, 'indexCu']);
        Route::get('/aktivis/indexTingkatArr/{kegiatan_id}/{tingkat}', [AktivisController::class, 'indexTingkatArr']);
        Route::get('/aktivis/indexCuTingkatArr/{kegiatan_id}/{id}/{tingkat}', [AktivisController::class, 'indexCuTingkatArr']);
        // Route::group(['middleware' => ['permission:index_aktivis']], function () {
        // });
        Route::group(['middleware' => ['permission:create_aktivis']], function () {
            Route::get('/aktivis/create', [AktivisController::class, 'create']);
            Route::post('/aktivis/store', [AktivisController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_aktivis']], function () {
            // nothing
        });
        Route::group(['middleware' => ['permission:destroy_aktivis']], function () {
            Route::delete('/aktivis/{id}', [AktivisController::class, 'destroy']);
        });

        // aset tetap
        Route::get('/asetTetap/generate/{id}', [AsetTetapController::class, 'generate']);
        Route::get('/asetTetap', [AsetTetapController::class, 'index']);
        Route::get('/asetTetap/indexSelesai', [AsetTetapController::class, 'indexSelesai']);
        Route::get('/asetTetap/indexHapus', [AsetTetapController::class, 'indexHapus']);
        Route::get('/asetTetap/history', [AsetTetapController::class, 'history']);
        Route::get('/asetTetap/indexSub/{id}', [AsetTetapController::class, 'indexSub']);
        Route::group(['middleware' => ['permission:index_aset_tetap']], function () {});
        Route::group(['middleware' => ['permission:create_aset_tetap']], function () {
            Route::get('/asetTetap/create', [AsetTetapController::class, 'create']);
            Route::post('/asetTetap/store', [AsetTetapController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_aset_tetap']], function () {
            Route::get('/asetTetap/edit/{id}', [AsetTetapController::class, 'edit']);
            Route::post('/asetTetap/update/{id}', [AsetTetapController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap']], function () {
            Route::delete('/asetTetap/{id}', [AsetTetapController::class, 'destroy']);
            Route::delete('/asetTetap/hapusDariLaporan/{id}', [AsetTetapController::class, 'hapusDariLaporan']);
        });

        // aset tetap jenis
        Route::get('/asetTetapGolongan/get', [AsetTetapGolonganController::class, 'get']);
        Route::get('/asetTetapKelompok/get/{id}', [AsetTetapKelompokController::class, 'get']);
        Route::get('/asetTetapJenis/get/{id}', [AsetTetapJenisController::class, 'get']);
        Route::group(['middleware' => ['permission:index_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan', [AsetTetapGolonganController::class, 'index']);
            Route::get('/asetTetapKelompok', [AsetTetapKelompokController::class, 'index']);
            Route::get('/asetTetapJenis', [AsetTetapJenisController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:create_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan/create', [AsetTetapGolonganController::class, 'create']);
            Route::get('/asetTetapKelompok/create', [AsetTetapKelompokController::class, 'create']);
            Route::get('/asetTetapJenis/create', [AsetTetapJenisController::class, 'create']);
            Route::post('/asetTetapGolongan/store', [AsetTetapGolonganController::class, 'store']);
            Route::post('/asetTetapKelompok/store', [AsetTetapKelompokController::class, 'store']);
            Route::post('/asetTetapJenis/store', [AsetTetapJenisController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_aset_tetap_jenis']], function () {
            Route::get('/asetTetapGolongan/edit/{id}', [AsetTetapGolonganController::class, 'edit']);
            Route::get('/asetTetapKelompok/edit/{id}', [AsetTetapKelompokController::class, 'edit']);
            Route::get('/asetTetapJenis/edit/{id}', [AsetTetapJenisController::class, 'edit']);
            Route::post('/asetTetapGolongan/update/{id}', [AsetTetapGolonganController::class, 'update']);
            Route::post('/asetTetapKelompok/update/{id}', [AsetTetapKelompokController::class, 'update']);
            Route::post('/asetTetapJenis/update/{id}', [AsetTetapJenisController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap_jenis']], function () {
            Route::delete('/asetTetapGolongan/{id}', [AsetTetapGolonganController::class, 'destroy']);
            Route::delete('/asetTetapKelompok/{id}', [AsetTetapKelompokController::class, 'destroy']);
            Route::delete('/asetTetapJenis/{id}', [AsetTetapJenisController::class, 'destroy']);
        });

        // aset tetap lokasi
        Route::get('/asetTetapLokasi/get', [AsetTetapLokasiController::class, 'get']);
        Route::group(['middleware' => ['permission:index_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi', [AsetTetapLokasiController::class, 'index']);
        });
        Route::group(['middleware' => ['permission:create_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi/create', [AsetTetapLokasiController::class, 'create']);
            Route::post('/asetTetapLokasi/store', [AsetTetapLokasiController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_aset_tetap_lokasi']], function () {
            Route::get('/asetTetapLokasi/edit/{id}', [AsetTetapLokasiController::class, 'edit']);
            Route::post('/asetTetapLokasi/update/{id}', [AsetTetapLokasiController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_aset_tetap_lokasi']], function () {
            Route::delete('/asetTetapLokasi/{id}', [AsetTetapLokasiController::class, 'destroy']);
        });

        // surat
        Route::get('/surat/getPeriode/{cu}', [SuratController::class, 'getPeriode']);
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/surat/indexCu/{cu}/tipe/{tipe}/periode/{periode}', [SuratController::class, 'indexCu']);
            Route::get('/surat/getKode/{id}', [SuratController::class, 'getKode']);
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/surat/create', [SuratController::class, 'create']);
            Route::post('/surat/store', [SuratController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/surat/edit/{id}', [SuratController::class, 'edit']);
            Route::post('/surat/update/{id}', [SuratController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/surat/{id}', [SuratController::class, 'destroy']);
        });

        // surat kategori
        Route::get('/suratKategori/history', [SuratKategoriController::class, 'history']);
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratKategori', [SuratKategoriController::class, 'index']);
            Route::get('/suratKategori/get', [SuratKategoriController::class, 'get']);
            Route::get('/suratKategori/indexCu/{id}', [SuratKategoriController::class, 'indexCu']);
            Route::get('/suratKategori/getCu/{id}', [SuratKategoriController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratKategori/create', [SuratKategoriController::class, 'create']);
            Route::post('/suratKategori/store', [SuratKategoriController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratKategori/edit/{id}', [SuratKategoriController::class, 'edit']);
            Route::post('/suratKategori/update/{id}', [SuratKategoriController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratKategori/{id}', [SuratKategoriController::class, 'destroy']);
        });

        // surat kode
        Route::get('/suratKode/history', [SuratKodeController::class, 'history']);
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratKode', [SuratKodeController::class, 'index']);
            Route::get('/suratKode/get', [SuratKodeController::class, 'get']);
            Route::get('/suratKode/indexCu/{id}', [SuratKodeController::class, 'indexCu']);
            Route::get('/suratKode/getCu/{id}', [SuratKodeController::class, 'getCu']);
            Route::get('/suratKode/getTipe/{periode}', [SuratKodeController::class, 'getTipe']);
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratKode/create', [SuratKodeController::class, 'create']);
            Route::post('/suratKode/store', [SuratKodeController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratKode/edit/{id}', [SuratKodeController::class, 'edit']);
            Route::post('/suratKode/update/{id}', [SuratKodeController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratKode/{id}', [SuratKodeController::class, 'destroy']);
        });

        // surat masuk
        Route::get('/suratMasuk/getPeriode/{cu}', [SuratMasukController::class, 'getPeriode']);
        Route::group(['middleware' => ['permission:index_surat']], function () {
            Route::get('/suratMasuk/indexCu/{cu}/{periode}', [SuratMasukController::class, 'indexCu']);
            Route::get('/suratMasuk/getKode/{id}', [SuratMasukController::class, 'getKode']);
        });
        Route::group(['middleware' => ['permission:create_surat']], function () {
            Route::get('/suratMasuk/create', [SuratMasukController::class, 'create']);
            Route::post('/suratMasuk/store', [SuratMasukController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_surat']], function () {
            Route::get('/suratMasuk/edit/{id}', [SuratMasukController::class, 'edit']);
            Route::post('/suratMasuk/update/{id}', [SuratMasukController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_surat']], function () {
            Route::delete('/suratMasuk/{id}', [SuratMasukController::class, 'destroy']);
        });

        // dokumen
        Route::get('/dokumen/count', [DokumenController::class, 'count']);
        Route::get('/dokumen/history', [DokumenController::class, 'history']);
        Route::get('/dokumen/indexGerakanPublik', [DokumenController::class, 'indexGerakanPublik']);
        Route::get('/dokumen/indexGerakanPublikCu/{id}', [DokumenController::class, 'indexGerakanPublikCu']);
        Route::get('/dokumen/', [DokumenController::class, 'index']);
        Route::get('/dokumen/indexCu/{id}', [DokumenController::class, 'indexCu']);
        Route::group(['middleware' => ['permission:index_dokumen']], function () {});
        Route::group(['middleware' => ['permission:create_dokumen']], function () {
            Route::get('/dokumen/create', [DokumenController::class, 'create']);
            Route::post('/dokumen/store', [DokumenController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_dokumen']], function () {
            Route::get('/dokumen/edit/{id}', [DokumenController::class, 'edit']);
            Route::post('/dokumen/update/{id}', [DokumenController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_dokumen']], function () {
            Route::delete('/dokumen/{id}', [DokumenController::class, 'destroy']);
        });

        // dokumen kategori
        Route::get('/dokumenKategori/history', [DokumenKategoriController::class, 'history']);
        Route::group(['middleware' => ['permission:index_dokumen_kategori']], function () {
            Route::get('/dokumenKategori', [DokumenKategoriController::class, 'index']);
            Route::get('/dokumenKategori/get', [DokumenKategoriController::class, 'get']);
            Route::get('/dokumenKategori/indexCu/{id}', [DokumenKategoriController::class, 'indexCu']);
            Route::get('/dokumenKategori/getCu/{id}', [DokumenKategoriController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_dokumen_kategori']], function () {
            Route::get('/dokumenKategori/create', [DokumenKategoriController::class, 'create']);
            Route::post('/dokumenKategori/store', [DokumenKategoriController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_dokumen_kategori']], function () {
            Route::get('/dokumenKategori/edit/{id}', [DokumenKategoriController::class, 'edit']);
            Route::post('/dokumenKategori/update/{id}', [DokumenKategoriController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_dokumen_kategori']], function () {
            Route::delete('/dokumenKategori/{id}', [DokumenKategoriController::class, 'destroy']);
        });

        // assesment Access
        Route::get('/assesmentAccess/history', [AssesmentAccessController::class, 'history']);
        Route::get(
            '/assesmentAccess/cariData/{cu}/{periode}',
            [AssesmentAccessController::class, 'cariData']
        );
        Route::get('/assesmentAccess/edit/{id}', [AssesmentAccessController::class, 'edit']);
        Route::get('/assesmentAccess/editPenilaian/{id}', [AssesmentAccessController::class, 'editPenilaian']);
        Route::group(['middleware' => ['permission:index_assesment_access']], function () {
            Route::get('/assesmentAccess', [AssesmentAccessController::class, 'index']);
            Route::get('/assesmentAccess/indexCu/{id}', [AssesmentAccessController::class, 'indexCu']);
            Route::get('/assesmentAccess/count', [AssesmentAccessController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_assesment_access']], function () {
            Route::get('/assesmentAccess/create', [AssesmentAccessController::class, 'create']);
            Route::post('/assesmentAccess/store', [AssesmentAccessController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_assesment_access']], function () {
            Route::post('/assesmentAccess/update/{id}', [AssesmentAccessController::class, 'update']);
            Route::post('/assesmentAccess/updateSingle/{id}/{perspektif}', [AssesmentAccessController::class, 'updateSingle']);
        });
        Route::group(['middleware' => ['permission:destroy_assesment_access']], function () {
            Route::delete('/assesmentAccess/{id}', [AssesmentAccessController::class, 'destroy']);
        });

        // assesment Culeg
        Route::get('/assesmentCuleg/history', [AssesmentCulegController::class, 'history']);
        Route::get(
            '/assesmentCuleg/cariData/{cu}/{periode}',
            [AssesmentAccessController::class, 'cariData']
        );
        Route::get('/assesmentCuleg/edit/{id}', [AssesmentCulegController::class, 'edit']);
        Route::get('/assesmentCuleg/editPenilaian/{id}', [AssesmentCulegController::class, 'editPenilaian']);
        Route::group(['middleware' => ['permission:index_assesment_culeg']], function () {
            Route::get('/assesmentCuleg', [AssesmentCulegController::class, 'index']);
            Route::get('/assesmentCuleg/indexCu/{id}', [AssesmentCulegController::class, 'indexCu']);
            Route::get('/assesmentCuleg/count', [AssesmentCulegController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_assesment_culeg']], function () {
            Route::get('/assesmentCuleg/create', [AssesmentCulegController::class, 'create']);
            Route::post('/assesmentCuleg/store', [AssesmentCulegController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_assesment_culeg']], function () {
            Route::post('/assesmentCuleg/update/{id}', [AssesmentCulegController::class, 'update']);
            Route::post('/assesmentCuleg/updateSingle/{id}/{perspektif}', [AssesmentCulegController::class, 'updateSingle']);
        });
        Route::group(['middleware' => ['permission:destroy_assesment_culeg']], function () {
            Route::delete('/assesmentCuleg/{id}', [AssesmentCulegController::class, 'destroy']);
        });

        // monitoring
        Route::get('/monitoring/history', [MonitoringController::class, 'history']);
        Route::post('monitoring/laporan', [MonitoringController::class, 'downloadLaporan']);
        Route::post('monitoring/laporanKonsolidasi', [MonitoringController::class, 'downloadLaporanKonsolidasi']);
        Route::get('/monitoring/getPeriode/{cu}', [MonitoringController::class, 'getPeriode']);
        Route::group(['middleware' => ['permission:index_monitoring']], function () {
            Route::get('/monitoring/status/{status}', [MonitoringController::class, 'index']);
            Route::get('/monitoring/summary/{cu}', [MonitoringController::class, 'summary']);
            Route::get('/monitoring/indexCu/{cu}/{tp}/{status}', [MonitoringController::class, 'indexCu']);
            Route::get('/monitoring/get/{id}', [MonitoringController::class, 'get']);
            Route::get('/monitoring/count', [MonitoringController::class, 'count']);
            Route::get('/monitoring/indexKonsolidasi/{tahun}/{bulan}', [MonitoringController::class, 'indexKonsolidasi']);
        });
        Route::group(['middleware' => ['permission:create_monitoring']], function () {
            Route::get('/monitoring/create', [MonitoringController::class, 'create']);
            Route::post('/monitoring/store', [MonitoringController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_monitoring']], function () {
            Route::get('/monitoring/edit/{id}', [MonitoringController::class, 'edit']);
            Route::post('/monitoring/update/{id}', [MonitoringController::class, 'update']);
            Route::post('/monitoring/updateRekom/{id}', [MonitoringController::class, 'updateRekom']);
        });
        Route::group(['middleware' => ['permission:destroy_monitoring']], function () {
            Route::delete('/monitoring/{id}', [MonitoringController::class, 'destroy']);
        });

        // monitoring pencapaian
        Route::get('/monitoringPencapaian/history', [MonitoringPencapaianController::class, 'history']);
        Route::group(['middleware' => ['permission:index_monitoring']], function () {
            Route::get('/monitoringPencapaian/get/{id}', [MonitoringPencapaianController::class, 'get']);
            Route::get('/monitoringPencapaian/count', [MonitoringPencapaianController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_monitoring']], function () {
            Route::post('/monitoringPencapaian/store', [MonitoringPencapaianController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_monitoring']], function () {
            Route::post('/monitoringPencapaian/update/{id}', [MonitoringPencapaianController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_monitoring']], function () {
            Route::delete('/monitoringPencapaian/{id}', [MonitoringPencapaianController::class, 'destroy']);
        });

        // monitoring cu
        Route::get('/monitoringCu/history', [MonitoringCuController::class, 'history']);
        Route::post('monitoringCu/laporan', [MonitoringCuController::class, 'downloadLaporan']);
        Route::post('monitoringCu/laporanKonsolidasi', [MonitoringCuController::class, 'downloadLaporanKonsolidasi']);
        Route::get('/monitoringCu/getPeriode/{cu}', [MonitoringCuController::class, 'getPeriode']);
        Route::group(['middleware' => ['permission:index_monitoring_cu']], function () {
            Route::get('/monitoringCu/status/{status}', [MonitoringCuController::class, 'index']);
            Route::get('/monitoringCu/summary/{cu}', [MonitoringCuController::class, 'summary']);
            Route::get('/monitoringCu/indexCu/{cu}/{tp}/{status}', [MonitoringCuController::class, 'indexCu']);
            Route::get('/monitoringCu/get/{id}', [MonitoringCuController::class, 'get']);
            Route::get('/monitoringCu/count', [MonitoringCuController::class, 'count']);
            Route::get('/monitoringCu/indexKonsolidasi/{tahun}/{bulan}', [MonitoringCuController::class, 'indexKonsolidasi']);
        });
        Route::group(['middleware' => ['permission:create_monitoring_cu']], function () {
            Route::get('/monitoringCu/create', [MonitoringCuController::class, 'create']);
            Route::post('/monitoringCu/store', [MonitoringCuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::get('/monitoringCu/edit/{id}', [MonitoringCuController::class, 'edit']);
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu']], function () {
            Route::post('/monitoringCu/update/{id}', [MonitoringCuController::class, 'update']);
            Route::post('/monitoringCu/updateRekom/{id}', [MonitoringCuController::class, 'updateRekom']);
        });
        Route::group(['middleware' => ['permission:destroy_monitoring_cu']], function () {
            Route::delete('/monitoringCu/{id}', [MonitoringCuController::class, 'destroy']);
        });

        // monitoring pencapaian cu
        Route::get('/monitoringPencapaianCu/history', [MonitoringPencapaianCuController::class, 'history']);
        Route::group(['middleware' => ['permission:index_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::get('/monitoringPencapaianCu/get/{id}', [MonitoringPencapaianCuController::class, 'get']);
            Route::get('/monitoringPencapaianCu/count', [MonitoringPencapaianCuController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::post('/monitoringPencapaianCu/store', [MonitoringPencapaianCuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::post('/monitoringPencapaianCu/update/{id}', [MonitoringPencapaianCuController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_monitoring_cu|create_monitoring_cu_keputusan']], function () {
            Route::delete('/monitoringPencapaianCu/{id}', [MonitoringPencapaianCuController::class, 'destroy']);
        });

        // mitra perserorangan
        Route::get('/mitraOrang/history', [MitraOrangController::class, 'history']);
        Route::get('/mitraOrang', [MitraOrangController::class, 'index']);
        Route::get('/mitraOrang/indexPeserta/{kegiatan_id}', [MitraOrangController::class, 'indexPeserta']);
        Route::get('/mitraOrang/indexCu/{id}', [MitraOrangController::class, 'indexCu']);
        Route::group(['middleware' => ['permission:index_mitra_orang']], function () {
            Route::get('/mitraOrang/count', [MitraOrangController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_mitra_orang']], function () {
            Route::get('/mitraOrang/create', [MitraOrangController::class, 'create']);
            Route::post('/mitraOrang/store', [MitraOrangController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_mitra_orang']], function () {
            Route::get('/mitraOrang/edit/{id}', [MitraOrangController::class, 'edit']);
            Route::post('/mitraOrang/update/{id}', [MitraOrangController::class, 'update']);
            Route::post('/mitraOrang/restore/{id}', [MitraOrangController::class, 'restore']);
        });
        Route::group(['middleware' => ['permission:destroy_mitra_orang']], function () {
            Route::delete('/mitraOrang/{id}', [MitraOrangController::class, 'destroy']);
        });

        // mitra lembaga
        Route::get('/mitraLembaga/history', [MitraLembagaController::class, 'history']);
        Route::get('/mitraLembaga', [MitraLembagaController::class, 'index']);
        Route::get('/mitraLembaga/indexCu/{id}', [MitraLembagaController::class, 'indexCu']);
        Route::group(['middleware' => ['permission:index_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/count', [MitraLembagaController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/create', [MitraLembagaController::class, 'create']);
            Route::post('/mitraLembaga/store', [MitraLembagaController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_mitra_lembaga']], function () {
            Route::get('/mitraLembaga/edit/{id}', [MitraLembagaController::class, 'edit']);
            Route::post('/mitraLembaga/update/{id}', [MitraLembagaController::class, 'update']);
            Route::post('/mitraLembaga/restore/{id}', [MitraLembagaController::class, 'restore']);
        });
        Route::group(['middleware' => ['permission:destroy_mitra_lembaga']], function () {
            Route::delete('/mitraLembaga/{id}', [MitraLembagaController::class, 'destroy']);
        });

        // anggota cu
        Route::get('/anggotaCu/systemNIK', [AnggotaCuController::class, 'systemNIK']);
        Route::get('/anggotaCu/history', [AnggotaCuController::class, 'history']);
        Route::get('/anggotaCu/count', [AnggotaCuController::class, 'count']);
        Route::get('/anggotaCu/cariDataInformasi/{nik}', [AnggotaCuController::class, 'cariDataInformasi']);
        Route::get('/anggotaCu/cariDataKTP/{nik}', [AnggotaCuController::class, 'cariDataKTP']);
        Route::get('/anggotaCu/cariDataBA/{cu}/{noba}', [AnggotaCuController::class, 'cariDataBA']);
        Route::get('/anggotaCu/indexProduk/{id}/cu/{cu}', [AnggotaProdukCuController::class, 'index']);
        Route::get('/anggotaCu/indexProdukSaldo/{id}', [AnggotaProdukCuController::class, 'indexSaldo']);
        Route::get('/anggotaCu', [AnggotaCuController::class, 'index']);
        Route::get('/anggotaCu/indexCu/{cu}/{tp}', [AnggotaCuController::class, 'indexCu']);
        Route::get('/anggotaCu/indexCuFasilitator/{cu}/{tp}', [AnggotaCuController::class, 'indexCuFasilitator']);
        Route::get('/anggotaCu/indexCuMentor/{cu}/{tp}', [AnggotaCuController::class, 'indexCuMentor']);
        Route::get('/anggotaCu/keluar', [AnggotaCuController::class, 'indexKeluar']);
        Route::get('/anggotaCu/indexMeninggal', [AnggotaCuController::class, 'indexMeninggal']);
        Route::get('/anggotaCu/indexCuKeluar/{cu}/{tp}', [AnggotaCuController::class, 'indexCuKeluar']);
        Route::get('/anggotaCu/indexCuMeninggal/{cu}/{tp}', [AnggotaCuController::class, 'indexCuMeninggal']);
        Route::get('/anggotaCu/getCu/{cu}', [AnggotaCuController::class, 'getCu']);
        Route::get('/anggotaCu/getCuJalinan/{cu}/{bulan}/{tahun}', [AnggotaCuController::class, 'getCuJalinan']);
        Route::get('/anggotaCu/getCuKeluar/{cu}', [AnggotaCuController::class, 'getCuKeluar']);
        Route::group(['middleware' => ['permission:create_anggota_cu']], function () {
            Route::get('/anggotaCu/create', [AnggotaCuController::class, 'create']);
            Route::post('/anggotaCu/store', [AnggotaCuController::class, 'store']);
            Route::post('/anggotaCu/storeCu/{id}', [AnggotaCuController::class, 'storeCu']);
            Route::post('/anggotaCu/storeProduk/{id}', [AnggotaProdukCuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_anggota_cu']], function () {
            Route::get('/anggotaCu/edit/{id}', [AnggotaCuController::class, 'edit']);
            Route::post('/anggotaCu/update/{id}', [AnggotaCuController::class, 'update']);
            Route::post('/anggotaCu/updateCu/{id}', [AnggotaCuController::class, 'updateCu']);
            Route::post('/anggotaCu/updatePindahTp/{id}', [AnggotaCuController::class, 'updatePindahTp']);
            Route::post('/anggotaCu/updateKeluar/{id}', [AnggotaCuController::class, 'updateKeluar']);
            Route::post('/anggotaCu/updateBatalKeluar/{id}', [AnggotaCuController::class, 'updateBatalKeluar']);
            Route::post('/anggotaCu/updateNik/{id}', [AnggotaCuController::class, 'updateNik']);
            Route::post('/anggotaCu/restore/{id}', [AnggotaCuController::class, 'restore']);
            Route::post('/anggotaCu/updateProduk/{id}', [AnggotaProdukCuController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_anggota_cu']], function () {
            Route::delete('/anggotaCu/{id}/cu/{cu}', [AnggotaCuController::class, 'destroy']);
            Route::delete('/anggotaCuCu/{id}', [AnggotaCuController::class, 'destroyCu']);
            Route::delete('/anggotaProdukCu/{id}', [AnggotaProdukCuController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:upload_anggota_cu']], function () {
            Route::post('/anggotaCu/uploadExcel', [AnggotaCuController::class, 'uploadExcel']);
            Route::post('/anggotaCu/uploadExcelProduk', [AnggotaCuController::class, 'uploadExcelProduk']);
            Route::get('/anggotaCuDraft/index/{cu}/{tp}', [AnggotaCuDraftController::class, 'index']);
            Route::post('/anggotaCuDraft/store/{id}', [AnggotaCuDraftController::class, 'store']);
            Route::post('/anggotaCuDraft/storeAll/{cu}', [AnggotaCuDraftController::class, 'storeAll']);
            Route::get('/anggotaCuDraft/edit/{id}', [AnggotaCuDraftController::class, 'edit']);
            Route::post('/anggotaCuDraft/update/{id}', [AnggotaCuDraftController::class, 'update']);
            Route::delete('/anggotaCuDraft/destroy/{id}', [AnggotaCuDraftController::class, 'destroy']);
            Route::delete('/anggotaCuDraft/destroyAll/{cu}', [AnggotaCuDraftController::class, 'destroyAll']);
            Route::get('/anggotaCuDraft/count/{cu}/{tp}', [AnggotaCuDraftController::class, 'count']);
            Route::get('/anggotaProdukCuDraft/index/{cu}', [AnggotaProdukCuDraftController::class, 'index']);
            Route::post('/anggotaProdukCuDraft/store/{id}', [AnggotaProdukCuDraftController::class, 'store']);
            Route::post('/anggotaProdukCuDraft/storeAll/{cu}', [AnggotaProdukCuDraftController::class, 'storeAll']);
            Route::get('/anggotaProdukCuDraft/edit/{id}', [AnggotaProdukCuDraftController::class, 'edit']);
            Route::post('/anggotaProdukCuDraft/update/{id}', [AnggotaProdukCuDraftController::class, 'update']);
            Route::delete('/anggotaProdukCuDraft/destroy/{id}', [AnggotaProdukCuDraftController::class, 'destroy']);
            Route::delete('/anggotaProdukCuDraft/destroyAll/{cu}', [AnggotaProdukCuDraftController::class, 'destroyAll']);
            Route::get('/anggotaProdukCuDraft/count/{cu}', [AnggotaProdukCuDraftController::class, 'count']);
        });

        // jalinan klaim
        Route::get('/jalinanKlaim/count', [JalinanKlaimController::class, 'count']);
        Route::get('/jalinanKlaim/history', [JalinanKlaimController::class, 'history']);
        Route::get('/jalinanKlaim/cekData/{id}', [JalinanKlaimController::class, 'cekData']);
        Route::get('/jalinanKlaim/getKlaim/{id}', [JalinanKlaimController::class, 'getKlaim']);
        Route::get('/jalinanKlaim/getVerifikator/{verifikator_pengurus}/{verifikator_pengawas}/{verifikator_manajemen}', [JalinanKlaimController::class, 'getVerifikator']);
        Route::post('/jalinanKlaim/updateVerifikasi/{id}', [JalinanKlaimController::class, 'updateVerifikasi']);
        Route::get('/jalinanKlaim/getPencairan', [JalinanKlaimController::class, 'getPencairan']);
        Route::get('/jalinanKlaim/getStatus/{status_klaim}', [JalinanKlaimController::class, 'getStatus']);
        Route::get('/jalinanKlaim/getHistory/{id}', [JalinanKlaimController::class, 'getHistory']);
        Route::get('/jalinanKlaim/getDuplicate/{name}/tanggal/{tanggal_lahir}/tipe/{tipe}', [JalinanKlaimController::class, 'getDuplicate']);
        Route::get('/jalinanKlaim/getKlaimLama/{nik}/cu/{cu}', [JalinanKlaimController::class, 'getKlaimLama']);
        Route::get('/jalinanKlaim/edit/{nik}/cu/{cu}/tipe/{tipe}', [JalinanKlaimController::class, 'edit']);
        Route::group(['middleware' => ['permission:index_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/status/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'index']);
            Route::get('/jalinanKlaim/indexCu/{cu}/tp/{tp}/status/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexCu']);
            Route::get('/jalinanKlaim/cariData/{nik}', [JalinanKlaimController::class, 'cariData']);
            Route::get('/jalinanKlaim/cariDataId/{id}', [JalinanKlaimController::class, 'cariDataId']);
        });
        Route::group(['middleware' => ['permission:create_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/create', [JalinanKlaimController::class, 'create']);
            Route::post('/jalinanKlaim/store', [JalinanKlaimController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_jalinan_klaim']], function () {
            Route::post('/jalinanKlaim/update/{id}', [JalinanKlaimController::class, 'update']);
            Route::post('/jalinanKlaim/updateStatus/{id}', [JalinanKlaimController::class, 'updateStatus']);
            Route::post('/jalinanKlaim/updateNoSurat/{id}', [JalinanKlaimController::class, 'updateNoSurat']);
            Route::post('/jalinanKlaim/periksaKoreksi/{id}', [JalinanKlaimController::class, 'periksaKoreksi']);
            Route::post('/jalinanKlaim/updateSelesai/{id}', [JalinanKlaimController::class, 'updateSelesai']);
        });
        Route::group(['middleware' => ['permission:destroy_jalinan_klaim']], function () {
            Route::delete('/jalinanKlaim/{id}', [JalinanKlaimController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:pencairan_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/indexCair/{tanggal_pencairan}', [JalinanKlaimController::class, 'indexCair']);
            Route::post('/jalinanKlaim/updateCair/{id}/{awal}/{akhir}', [JalinanKlaimController::class, 'updateCair']);
            Route::post('/jalinanKlaim/updateCairBatal/{id}/{awal}/{akhir}', [JalinanKlaimController::class, 'updateCairBatal']);
            Route::post('/jalinanKlaim/updateCairAll/{awal}/{akhir}', [JalinanKlaimController::class, 'updateCairAll']);
        });
        Route::group(['middleware' => ['permission:laporan_jalinan_klaim']], function () {
            Route::get('/jalinanKlaim/indexLaporanCu/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanCu']);
            Route::get('/jalinanKlaim/indexLaporanCuDetail/{cu}/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanCuDetail']);
            Route::get('/jalinanKlaim/indexLaporanPenyebab/{cu}/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanPenyebab']);
            Route::get('/jalinanKlaim/indexLaporanPenyebabDetail/{cu}/{status}/{kategori}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanPenyebabDetail']);
            Route::get('/jalinanKlaim/indexLaporanUsia/{cu}/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanUsia']);
            Route::get('/jalinanKlaim/indexLaporanUsiaDetail/{cu}/{status}/{dari}/{ke}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanUsiaDetail']);
            Route::get('/jalinanKlaim/indexLaporanLama/{cu}/{status}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanLama']);
            Route::get('/jalinanKlaim/indexLaporanLamaDetail/{cu}/{status}/{dari}/{ke}/{awal}/{akhir}', [JalinanKlaimController::class, 'indexLaporanLamaDetail']);
        });

        // jalinan iuran
        Route::get('/jalinanIuran', [JalinanIuranController::class, 'index']);
        Route::get('/jalinanIuran/indexCu/{id}', [JalinanIuranController::class, 'indexCu']);
        Route::get('/jalinanIuran/indexAnggota/{id}/{cu}/{lokasi}', [JalinanIuranController::class, 'indexAnggota']);
        Route::get('/jalinanIuran/edit/{id}', [JalinanIuranController::class, 'edit']);
        Route::get('/jalinanIuran/create/{cu}/{bulan}/{tahun}', [JalinanIuranController::class, 'create']);
        Route::post('/jalinanIuran/store', [JalinanIuranController::class, 'store']);
        Route::post('/jalinanIuran/update/{id}', [JalinanIuranController::class, 'update']);
        Route::delete('/jalinanIuran/{id}', [JalinanIuranController::class, 'destroy']);

        // Route::group(['middleware' => ['permission:index_jalinan_iuran']], function () {
        //     Route::get('/jalinanIuran', [JalinanIuranController::class, 'index']);
        //     Route::get('/jalinanIuran/indexCu/{id}', [JalinanIuranController::class, 'indexCu']);
        //     Route::get('/jalinanIuran/indexAnggota/{id}/{cu}/{lokasi}', [JalinanIuranController::class, 'indexAnggota']);
        //     Route::get('/jalinanIuran/edit/{id}', [JalinanIuranController::class, 'edit']);
        // });
        // Route::group(['middleware' => ['permission:create_jalinan_iuran']], function () {
        //     Route::get('/jalinanIuran/create/{cu}/{bulan}/{tahun}', [JalinanIuranController::class, 'create']);
        //     Route::post('/jalinanIuran/store', [JalinanIuranController::class, 'store']);
        // });
        // Route::group(['middleware' => ['permission:update_jalinan_iuran']], function () {
        //     Route::post('/jalinanIuran/update/{id}', [JalinanIuranController::class, 'update']);
        // });
        // Route::group(['middleware' => ['permission:destroy_jalinan_iuran']], function () {
        //     Route::delete('/jalinanIuran/{id}', [JalinanIuranController::class, 'destroy']);
        // });

        // laporan gerakan
        Route::get('/laporanGerakan', [LaporanGerakanController::class, 'index']);
        Route::group(['middleware' => ['permission:create_laporan_cu']], function () {
            Route::get('/laporanGerakan/create', [LaporanGerakanController::class, 'create']);
            Route::post('/laporanGerakan/store', [LaporanGerakanController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_laporan_cu']], function () {
            Route::get('/laporanGerakan/edit/{id}', [LaporanGerakanController::class, 'edit']);
            Route::post('/laporanGerakan/update/{id}', [LaporanGerakanController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_laporan_cu']], function () {
            Route::delete('/laporanGerakan/{id}', [LaporanGerakanController::class, 'destroy']);
        });

        // laporan cu
        Route::get('/laporanCu/history', [LaporanCuController::class, 'history']);
        Route::group(['middleware' => ['permission:index_laporan_cu']], function () {
            Route::get('/laporanCu', [LaporanCuController::class, 'index']);
            Route::get('/laporanCu/indexTotal', [LaporanCuController::class, 'indexTotal']);
            Route::get('/laporanCu/indexGerakan', [LaporanCuController::class, 'indexGerakan']);
            Route::get('/laporanCu/indexCu/{id}', [LaporanCuController::class, 'indexCu']);
            Route::get('/laporanCu/indexPeriode/{periode}', [LaporanCuController::class, 'indexPeriode']);
            Route::get('/laporanCu/indexPearls', [LaporanCuController::class, 'indexPearls']);
            Route::get('/laporanCu/indexPearlsCu/{id}', [LaporanCuController::class, 'indexPearlsCu']);
            Route::get('/laporanCu/indexPearlsPeriode/{periode}', [LaporanCuController::class, 'indexPearlsPeriode']);
            Route::get('/laporanCu/getPeriode', [LaporanCuController::class, 'getPeriode']);
            Route::get('/laporanCu/getPeriodeCu/{id}', [LaporanCuController::class, 'getPeriodeCu']);
            Route::get('/laporanCu/detail/{id}', [LaporanCuController::class, 'detail']);
            Route::get('/laporanCu/detailPearls/{id}', [LaporanCuController::class, 'detailPearls']);
        });
        Route::group(['middleware' => ['permission:create_laporan_cu']], function () {
            Route::get('/laporanCu/create', [LaporanCuController::class, 'create']);
            Route::post('/laporanCu/store', [LaporanCuController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_laporan_cu']], function () {
            Route::get('/laporanCu/edit/{id}', [LaporanCuController::class, 'edit']);
            Route::post('/laporanCu/update/{id}', [LaporanCuController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_laporan_cu']], function () {
            Route::delete('/laporanCu/{id}', [LaporanCuController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:diskusi_laporan_cu']], function () {
            Route::get('/laporanCuDiskusi/get/{id}', [LaporanCuDiskusiController::class, 'get']);
            Route::post('/laporanCuDiskusi/store', [LaporanCuDiskusiController::class, 'store']);
            Route::post('/laporanCuDiskusi/update/{id}', [LaporanCuDiskusiController::class, 'update']);
            Route::delete('/laporanCuDiskusi/{id}', [LaporanCuDiskusiController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:upload_laporan_cu']], function () {
            Route::post('/laporanCu/uploadExcel', [LaporanCuController::class, 'uploadExcel']);
            Route::post('/laporanCu/uploadExcelAll', [LaporanCuController::class, 'uploadExcelAll']);

            Route::get('/laporanCuDraft', [LaporanCuDraftController::class, 'index']);
            Route::post('/laporanCuDraft/store/{id}', [LaporanCuDraftController::class, 'store']);
            Route::post('/laporanCuDraft/storeAll', [LaporanCuDraftController::class, 'storeAll']);
            Route::get('/laporanCuDraft/edit/{id}', [LaporanCuDraftController::class, 'edit']);
            Route::post('/laporanCuDraft/update/{id}', [LaporanCuDraftController::class, 'update']);
            Route::delete('/laporanCuDraft/destroy/{id}', [LaporanCuDraftController::class, 'destroy']);
            Route::delete('/laporanCuDraft/destroyAll', [LaporanCuDraftController::class, 'destroyAll']);
            Route::get('/laporanCuDraft/count', [LaporanCuDraftController::class, 'count']);
        });

        // laporan tp
        Route::get('/laporanTp/history', [LaporanTpController::class, 'history']);
        Route::group(['middleware' => ['permission:index_laporan_tp']], function () {
            Route::get('/laporanTp/cu/{id}', [LaporanTpController::class, 'index']);
            Route::get('/laporanTp/indexTp/{id}', [LaporanTpController::class, 'indexTp']);
            Route::get('/laporanTp/indexPeriode/{id}/{periode}', [LaporanTpController::class, 'indexPeriode']);
            Route::get('/laporanTp/indexPearls', [LaporanTpController::class, 'indexPearls']);
            Route::get('/laporanTp/indexPearlsTp/{id}', [LaporanTpController::class, 'indexPearlsTp']);
            Route::get('/laporanTp/indexPearlsPeriode/{id}/{periode}', [LaporanTpController::class, 'indexPearlsPeriode']);
            Route::get('/laporanTp/getPeriode', [LaporanTpController::class, 'getPeriode']);
            Route::get('/laporanTp/getPeriodeTp/{id}/{periode}', [LaporanTpController::class, 'getPeriodeTp']);
            Route::get('/laporanTp/listLaporanTp/{cu}/{periode}', [LaporanTpController::class, 'listLaporanTp']);
            Route::get('/laporanTp/detail/{id}', [LaporanTpController::class, 'detail']);
            Route::get('/laporanTp/detailPearls/{id}', [LaporanTpController::class, 'detailPearls']);
        });
        Route::group(['middleware' => ['permission:create_laporan_tp']], function () {
            Route::get('/laporanTp/create', [LaporanTpController::class, 'create']);
            Route::post('/laporanTp/store', [LaporanTpController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_laporan_tp']], function () {
            Route::get('/laporanTp/edit/{id}', [LaporanTpController::class, 'edit']);
            Route::post('/laporanTp/update/{id}', [LaporanTpController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_laporan_tp']], function () {
            Route::delete('/laporanTp/{id}', [LaporanTpController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:diskusi_laporan_tp']], function () {
            Route::get('/laporanTpDiskusi/get/{id}', [LaporanTpDiskusiController::class, 'get']);
            Route::post('/laporanTpDiskusi/store', [LaporanTpDiskusiController::class, 'store']);
            Route::post('/laporanTpDiskusi/update/{id}', [LaporanTpDiskusiController::class, 'update']);
            Route::delete('/laporanTpDiskusi/{id}', [LaporanTpDiskusiController::class, 'destroy']);
        });
        Route::group(['middleware' => ['permission:upload_laporan_tp']], function () {
            Route::post('/laporanTp/uploadExcel', [LaporanTpController::class, 'uploadExcel']);
            Route::post('/laporanTp/uploadExcelAll', [LaporanTpController::class, 'uploadExcelAll']);

            Route::get('/laporanTpDraft', [LaporanTpDraftController::class, 'index']);
            Route::post('/laporanTpDraft/store/{id}', [LaporanTpDraftController::class, 'store']);
            Route::post('/laporanTpDraft/storeAll', [LaporanTpDraftController::class, 'storeAll']);
            Route::get('/laporanTpDraft/edit/{id}', [LaporanTpDraftController::class, 'edit']);
            Route::post('/laporanTpDraft/update/{id}', [LaporanTpDraftController::class, 'update']);
            Route::delete('/laporanTpDraft/destroy/{id}', [LaporanTpDraftController::class, 'destroy']);
            Route::delete('/laporanTpDraft/destroyAll', [LaporanTpDraftController::class, 'destroyAll']);
            Route::get('/laporanTpDraft/count', [LaporanTpDraftController::class, 'count']);
        });

        // coa
        Route::get('/coa/history', [CoaController::class, 'history']);
        Route::group(['middleware' => ['permission:index_coa']], function () {
            Route::get('/coa', [CoaController::class, 'index']);
            Route::get('/coa/get', [CoaController::class, 'get']);
        });
        Route::group(['middleware' => ['permission:create_coa']], function () {
            Route::get('/coa/create', [CoaController::class, 'create']);
            Route::post('/coa/store', [CoaController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_coa']], function () {
            Route::get('/coa/edit/{id}', [CoaController::class, 'edit']);
            Route::post('/coa/update/{id}', [CoaController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_coa']], function () {
            Route::delete('/coa/{id}', [CoaController::class, 'destroy']);
        });

        // saran
        Route::group(['middleware' => ['permission:index_saran']], function () {
            Route::get('/saran', [SaranController::class, 'index']);
            Route::get('/saran/count', [SaranController::class, 'count']);
        });
        Route::get('/saran/create', [SaranController::class, 'create']);
        Route::post('/saran/store', [SaranController::class, 'store']);
        Route::group(['middleware' => ['permission:destroy_saran']], function () {
            Route::delete('/saran/{id}', [SaranController::class, 'destroy']);
        });

        // error log
        Route::group(['middleware' => ['permission:index_saran']], function () {
            Route::get('/errorLog', [ErrorLogController::class, 'index']);
            Route::get('/errorLog/count', [ErrorLogController::class, 'count']);
        });
        Route::get('/errorLog/create', [ErrorLogController::class, 'create']);
        Route::post('/errorLog/store', [ErrorLogController::class, 'store']);
        Route::group(['middleware' => ['permission:destroy_saran']], function () {
            Route::delete('/errorLog/{id}', [ErrorLogController::class, 'destroy']);
        });

        // pengumuman
        Route::group(['middleware' => ['permission:index_pengumuman']], function () {
            Route::get('/pengumuman', [PengumumanController::class, 'index']);
            Route::get('/pengumuman/indexCu/{id}', [PengumumanController::class, 'indexCu']);
            Route::get('/pengumuman/count', [PengumumanController::class, 'count']);
        });
        Route::group(['middleware' => ['permission:create_pengumuman']], function () {
            Route::get('/pengumuman/create', [PengumumanController::class, 'create']);
            Route::post('/pengumuman/store', [PengumumanController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_pengumuman']], function () {
            Route::get('/pengumuman/edit/{id}', [PengumumanController::class, 'edit']);
            Route::post('/pengumuman/update/{id}', [PengumumanController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_pengumuman']], function () {
            Route::delete('/pengumuman/{id}', [PengumumanController::class, 'destroy']);
        });

        // pemilihan
        Route::group(['middleware' => ['permission:index_pemilihan']], function () {
            Route::get('/pemilihan', [PemilihanController::class, 'index']);
            Route::get('/pemilihan/indexCu/{id}', [PemilihanController::class, 'indexCu']);
            Route::get('/pemilihan/indexPemilihan', [PemilihanController::class, 'indexPemilihan']);
            Route::get('/pemilihan/indexPemilihanCu/{id}', [PemilihanController::class, 'indexPemilihanCu']);
            Route::get('/pemilihan/indexDataSuara/{id}', [PemilihanController::class, 'indexDataSuara']);
            Route::get('/pemilihan/indexUser/{id}', [PemilihanController::class, 'indexUser']);
            Route::get('/pemilihan/checkUser/{pemilihan_id}', [PemilihanController::class, 'checkUser']);
            Route::get('/pemilihan/edit/{id}', [PemilihanController::class, 'edit']);
            Route::post('/pemilihan/storeSuara', [PemilihanController::class, 'storeSuara']);
            Route::post('/pemilihan/updateSuara/{id}', [PemilihanController::class, 'updateSuara']);
            Route::delete('/pemilihan/destroySuara/{id}', [PemilihanController::class, 'destroySuara']);
            Route::post('/pemilihan/uploadSuara/{id}', [PemilihanController::class, 'uploadSuara']);
        });
        Route::group(['middleware' => ['permission:create_pemilihan']], function () {
            Route::get('/pemilihan/create', [PemilihanController::class, 'create']);
            Route::post('/pemilihan/store', [PemilihanController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_pemilihan']], function () {
            Route::get('/pemilihan/updateStatus/{id}/{cu}', [PemilihanController::class, 'updateStatus']);
        });
        Route::group(['middleware' => ['permission:destroy_pemilihan']], function () {
            Route::delete('/pemilihan/{id}', [PemilihanController::class, 'destroy']);
        });

        // voting
        Route::group(['middleware' => ['permission:index_voting']], function () {
            Route::get('/voting', [VotingController::class, 'index']);
            Route::get('/voting/indexCu/{id}', [VotingController::class, 'indexCu']);
            Route::get('/voting/indexVoting', [VotingController::class, 'indexVoting']);
            Route::get('/voting/indexVotingCu/{id}', [VotingController::class, 'indexVotingCu']);
            Route::get('/voting/indexDataSuara/{id}', [VotingController::class, 'indexDataSuara']);
            Route::get('/voting/indexDataTanggapan/{id}', [VotingController::class, 'indexDataTanggapan']);
            Route::get('/voting/indexUser/{id}', [VotingController::class, 'indexUser']);
            Route::get('/voting/checkUser/{voting_id}', [VotingController::class, 'checkUser']);
            Route::get('/voting/edit/{id}', [VotingController::class, 'edit']);
            Route::post('/voting/storeSuara', [VotingController::class, 'storeSuara']);
            Route::post('/voting/updateSuara/{id}', [VotingController::class, 'updateSuara']);
            Route::delete('/voting/destroySuara/{id}', [VotingController::class, 'destroySuara']);
            Route::post('/voting/uploadSuara/{id}', [VotingController::class, 'uploadSuara']);
        });
        Route::group(['middleware' => ['permission:create_voting']], function () {
            Route::get('/voting/create', [VotingController::class, 'create']);
            Route::post('/voting/store', [VotingController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_voting']], function () {
            Route::get('/voting/updateStatus/{id}/{cu}', [VotingController::class, 'updateStatus']);
            Route::post('/voting/updateSuaraCu', [VotingController::class, 'updateSuaraCu']);
        });
        Route::group(['middleware' => ['permission:destroy_voting']], function () {
            Route::delete('/voting/{id}', [VotingController::class, 'destroy']);
        });

        // kubn
        Route::get('/kubn/history', [KubnController::class, 'history']);
        Route::get('/kubn/indexAnggota/{id}', [KubnController::class, 'indexAnggota']);
        Route::get('/kubn/indexDiklat/{id}', [KubnController::class, 'indexDiklat']);
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kubn', [KubnController::class, 'index']);
            Route::get('/kubn/get', [KubnController::class, 'get']);
            Route::get('/kubn/indexCu/{id}', [KubnController::class, 'indexCu']);
            Route::get('/kubn/getCu/{id}', [KubnController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kubn/create', [KubnController::class, 'create']);
            Route::post('/kubn/store', [KubnController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kubn/edit/{id}', [KubnController::class, 'edit']);
            Route::post('/kubn/update/{id}', [KubnController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kubn/{id}', [KubnController::class, 'destroy']);
        });

        // Kubn Usaha
        Route::get('/kubnUsaha/history', [KubnUsahaController::class, 'history']);
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kubnUsaha', [KubnUsahaController::class, 'index']);
            Route::get('/kubnUsaha/get', [KubnUsahaController::class, 'get']);
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kubnUsaha/create', [KubnUsahaController::class, 'create']);
            Route::post('/kubnUsaha/store', [KubnUsahaController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kubnUsaha/edit/{id}', [KubnUsahaController::class, 'edit']);
            Route::post('/kubnUsaha/update/{id}', [KubnUsahaController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kubnUsaha/{id}', [KubnUsahaController::class, 'destroy']);
        });

        // Kombas
        Route::get('/kombas/history', [KombasController::class, 'history']);
        Route::group(['middleware' => ['permission:index_kubn']], function () {
            Route::get('/kombas/index/{tipe}', [KombasController::class, 'index']);
            Route::get('/kombas/indexCu/{id}/{tipe}', [KombasController::class, 'indexCu']);
            Route::get('/kombas/get', [KombasController::class, 'get']);
        });
        Route::group(['middleware' => ['permission:create_kubn']], function () {
            Route::get('/kombas/create', [KombasController::class, 'create']);
            Route::post('/kombas/store', [KombasController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_kubn']], function () {
            Route::get('/kombas/edit/{id}', [KombasController::class, 'edit']);
            Route::post('/kombas/update/{id}', [KombasController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_kubn']], function () {
            Route::delete('/kombas/{id}', [KombasController::class, 'destroy']);
        });

        // enterpreneur
        Route::get('/enterpreneur/history', [EnterpreneurController::class, 'history']);
        Route::get('/enterpreneur/indexDiklat/{id}', [EnterpreneurController::class, 'indexDiklat']);
        Route::group(['middleware' => ['permission:index_enterpreneur']], function () {
            Route::get('/enterpreneur', [EnterpreneurController::class, 'index']);
            Route::get('/enterpreneur/get', [EnterpreneurController::class, 'get']);
            Route::get('/enterpreneur/indexCu/{id}', [EnterpreneurController::class, 'indexCu']);
            Route::get('/enterpreneur/getCu/{id}', [EnterpreneurController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_enterpreneur']], function () {
            Route::get('/enterpreneur/create', [EnterpreneurController::class, 'create']);
            Route::post('/enterpreneur/store', [EnterpreneurController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_enterpreneur']], function () {
            Route::get('/enterpreneur/edit/{id}', [EnterpreneurController::class, 'edit']);
            Route::post('/enterpreneur/update/{id}', [EnterpreneurController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_enterpreneur']], function () {
            Route::delete('/enterpreneur/{id}', [EnterpreneurController::class, 'destroy']);
        });

        // umkm
        Route::get('/umkm/history', [UmkmController::class, 'history']);
        Route::get('/umkm/indexDiklat/{id}', [UmkmController::class, 'indexDiklat']);
        Route::group(['middleware' => ['permission:index_umkm']], function () {
            Route::get('/umkm', [UmkmController::class, 'index']);
            Route::get('/umkm/get', [UmkmController::class, 'get']);
            Route::get('/umkm/indexCu/{id}', [UmkmController::class, 'indexCu']);
            Route::get('/umkm/getCu/{id}', [UmkmController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_umkm']], function () {
            Route::get('/umkm/create', [UmkmController::class, 'create']);
            Route::post('/umkm/store', [UmkmController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_umkm']], function () {
            Route::get('/umkm/edit/{id}', [UmkmController::class, 'edit']);
            Route::post('/umkm/update/{id}', [UmkmController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_umkm']], function () {
            Route::delete('/umkm/{id}', [UmkmController::class, 'destroy']);
        });

        // mentor
        Route::get('/mentor/history', [MentorController::class, 'history']);
        Route::get('/mentor/indexDiklat/{id}', [MentorController::class, 'indexDiklat']);
        Route::group(['middleware' => ['permission:index_mentor']], function () {
            Route::get('/mentor', [MentorController::class, 'index']);
            Route::get('/mentor/get', [MentorController::class, 'get']);
            Route::get('/mentor/indexCu/{id}', [MentorController::class, 'indexCu']);
            Route::get('/mentor/getCu/{id}', [MentorController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_mentor']], function () {
            Route::get('/mentor/create', [MentorController::class, 'create']);
            Route::post('/mentor/store', [MentorController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_mentor']], function () {
            Route::get('/mentor/edit/{id}', [MentorController::class, 'edit']);
            Route::post('/mentor/update/{id}', [MentorController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_mentor']], function () {
            Route::delete('/mentor/{id}', [MentorController::class, 'destroy']);
        });

        // fasilitator
        Route::get('/fasilitator/history', [FasilitatorController::class, 'history']);
        Route::get('/fasilitator/indexDiklat/{id}', [FasilitatorController::class, 'indexDiklat']);
        Route::group(['middleware' => ['permission:index_fasilitator']], function () {
            Route::get('/fasilitator', [FasilitatorController::class, 'index']);
            Route::get('/fasilitator/get', [FasilitatorController::class, 'get']);
            Route::get('/fasilitator/indexCu/{id}', [FasilitatorController::class, 'indexCu']);
            Route::get('/fasilitator/getCu/{id}', [FasilitatorController::class, 'getCu']);
        });
        Route::group(['middleware' => ['permission:create_fasilitator']], function () {
            Route::get('/fasilitator/create', [FasilitatorController::class, 'create']);
            Route::post('/fasilitator/store', [FasilitatorController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_fasilitator']], function () {
            Route::get('/fasilitator/edit/{id}', [FasilitatorController::class, 'edit']);
            Route::post('/fasilitator/update/{id}', [FasilitatorController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_fasilitator']], function () {
            Route::delete('/fasilitator/{id}', [FasilitatorController::class, 'destroy']);
        });

        // Keahlian
        Route::get('/keahlian/history', [KeahlianController::class, 'history']);
        Route::get('/keahlian', [KeahlianController::class, 'index']);
        Route::get('/keahlian/get', [KeahlianController::class, 'get']);
        Route::group(['middleware' => ['permission:create_keahlian']], function () {
            Route::get('/keahlian/create', [KeahlianController::class, 'create']);
            Route::post('/keahlian/store', [KeahlianController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_keahlian']], function () {
            Route::get('/keahlian/edit/{id}', [KeahlianController::class, 'edit']);
            Route::post('/keahlian/update/{id}', [KeahlianController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_keahlian']], function () {
            Route::delete('/keahlian/{id}', [KeahlianController::class, 'destroy']);
        });

        // Jenis Diklat
        Route::get('/jenisDiklat/history', [JenisDiklatController::class, 'history']);
        Route::get('/jenisDiklat', [JenisDiklatController::class, 'index']);
        Route::get('/jenisDiklat/get', [JenisDiklatController::class, 'get']);
        Route::group(['middleware' => ['permission:create_jenis_diklat']], function () {
            Route::get('/jenisDiklat/create', [JenisDiklatController::class, 'create']);
            Route::post('/jenisDiklat/store', [JenisDiklatController::class, 'store']);
        });
        Route::group(['middleware' => ['permission:update_jenis_diklat']], function () {
            Route::get('/jenisDiklat/edit/{id}s', [JenisDiklatController::class, 'edit']);
            Route::post('/jenisDiklat/update/{id}', [JenisDiklatController::class, 'update']);
        });
        Route::group(['middleware' => ['permission:destroy_jenis_diklat']], function () {
            Route::delete('/jenisDiklat/{id}', [JenisDiklatController::class, 'destroy']);
        });

        // puskopdit
        Route::get('/pus', [PusController::class, 'index']);
        Route::get('/pus_all', [PusController::class, 'indexAll']);
        Route::post('/pus/store', [PusController::class, 'store']);

        // tempat
        Route::get('/tempat', [TempatController::class, 'index']);
        Route::get('/tempat/get/{id}', [TempatController::class, 'get']);
        Route::get('/tempat/create', [TempatController::class, 'create']);
        Route::get('/tempat/edit/{id}', [TempatController::class, 'edit']);
        Route::post('/tempat/store', [TempatController::class, 'store']);
        Route::post('/tempat/update/{id}', [TempatController::class, 'update']);
        Route::delete('/tempat/{id}', [TempatController::class, 'destroy']);

        // pekerjaan
        Route::get('/pekerjaan', [PekerjaanController::class, 'index']);
        Route::get('/pekerjaan/get', [PekerjaanController::class, 'get']);
        Route::get('/pekerjaan/create', [PekerjaanController::class, 'create']);
        Route::get('/pekerjaan/edit/{id}', [PekerjaanController::class, 'edit']);
        Route::post('/pekerjaan/store', [PekerjaanController::class, 'store']);
        Route::post('/pekerjaan/update/{id}', [PekerjaanController::class, 'update']);
        Route::delete('/pekerjaan/{id}', [PekerjaanController::class, 'destroy']);

        // suku
        Route::get('/suku', [SukuController::class, 'index']);
        Route::get('/suku/get', [SukuController::class, 'get']);
        Route::get('/suku/create', [SukuController::class, 'create']);
        Route::get('/suku/edit/{id}', [SukuController::class, 'edit']);
        Route::post('/suku/store', [SukuController::class, 'store']);
        Route::post('/suku/update/{id}', [SukuController::class, 'update']);
        Route::delete('/suku/{id}', [SukuController::class, 'destroy']);

        // provinces
        Route::get('/provinces', [ProvincesController::class, 'index']);
        Route::get('/provinces/get', [ProvincesController::class, 'get']);
        Route::get('/provinces/create', [ProvincesController::class, 'create']);
        Route::get('/provinces/edit/{id}', [ProvincesController::class, 'edit']);
        Route::post('/provinces/store', [ProvincesController::class, 'store']);
        Route::post('/provinces/update/{id}', [ProvincesController::class, 'update']);
        Route::delete('/provinces/{id}', [ProvincesController::class, 'destroy']);

        // regencies
        Route::get('/regencies', [RegenciesController::class, 'index']);
        Route::get('/regencies/get', [RegenciesController::class, 'get']);
        Route::get('/regencies/indexProvinces/{id}', [RegenciesController::class, 'indexProvinces']);
        Route::get('/regencies/getProvinces/{id}', [RegenciesController::class, 'getProvinces']);
        Route::get('/regencies/create', [RegenciesController::class, 'create']);
        Route::get('/regencies/edit/{id}', [RegenciesController::class, 'edit']);
        Route::post('/regencies/store', [RegenciesController::class, 'store']);
        Route::post('/regencies/update/{id}', [RegenciesController::class, 'update']);
        Route::delete('/regencies/{id}', [RegenciesController::class, 'destroy']);

        // districts
        Route::get('/districts', [DistrictsController::class, 'index']);
        Route::get('/districts/get', [DistrictsController::class, 'get']);
        Route::get('/districts/indexRegencies/{id}', [DistrictsController::class, 'indexRegencies']);
        Route::get('/districts/getRegencies/{id}', [DistrictsController::class, 'getRegencies']);
        Route::get('/districts/create', [DistrictsController::class, 'create']);
        Route::get('/districts/edit/{id}', [DistrictsController::class, 'edit']);
        Route::post('/districts/store', [DistrictsController::class, 'store']);
        Route::post('/districts/update/{id}', [DistrictsController::class, 'update']);
        Route::delete('/districts/{id}', [DistrictsController::class, 'destroy']);

        // villages
        Route::get('/villages', [VillagesController::class, 'index']);
        Route::get('/villages/get', [VillagesController::class, 'get']);
        Route::get('/villages/indexDistricts/{id}', [VillagesController::class, 'indexDistricts']);
        Route::get('/villages/getDistricts/{id}', [VillagesController::class, 'getDistricts']);
        Route::get('/villages/create', [VillagesController::class, 'create']);
        Route::get('/villages/edit/{id}', [VillagesController::class, 'edit']);
        Route::post('/villages/store', [VillagesController::class, 'store']);
        Route::post('/villages/update/{id}', [VillagesController::class, 'update']);
        Route::delete('/villages/{id}', [VillagesController::class, 'destroy']);

        // file
        Route::get('download/{filename}', [SystemController::class, 'download_file']);
        Route::get('download_folder/{filename}/{foldername}', [SystemController::class, 'download_file_folder']);
        Route::get('countOrganisasi', [SystemController::class, 'countOrganisasi']);

        // notification
        Route::get('/notification/get', [NotificationController::class, 'get']);
        Route::get('/notification/getAll', [NotificationController::class, 'getAll']);
        Route::get('/notification/markRead/{id}', [NotificationController::class, 'markRead']);
        Route::get('/notification/markAllRead', [NotificationController::class, 'markAllRead']);

        // file upload
        Route::post('/fileUpload/store', [FileUploadController::class, 'store']);
        Route::delete('/fileUpload/destroy/{id}', [FileUploadController::class, 'destroy']);
        Route::get('/fileUpload/index/{id_cu}/{id_user}', [FileUploadController::class, 'index']);

        // import csv
        Route::get('/anggotaCuImportEscete/index/{id_cu}', [AnggotaCuEsceteController::class, 'index']);
        Route::post('/anggotaCuImportEscete/draft/{id_cu}/{id_user}', [AnggotaCuEsceteController::class, 'uploadDraft']);
        Route::post('/anggotaCuImportEscete/simpandraft/{id_cu}', [AnggotaCuEsceteController::class, 'store']);
    });
});
