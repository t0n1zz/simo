<?php

namespace App\Http\Controllers;

use App\Models\Artikel;
use App\Support\CleansEditorImages;
use App\Support\Helper;
use App\Support\SanitizesContent;
use File;
use Illuminate\Http\Request;
use Image;

class ArtikelController extends Controller
{
    use CleansEditorImages, SanitizesContent;

    protected $imagepath = 'images/artikel/';

    protected $width = 300;

    protected $height = 200;

    protected $message = 'Artikel';

    public function index()
    {
        $table_data = Artikel::with('kategori', 'penulis', 'Cu')
            ->advancedFilter();

        return response()
            ->json([
                'model' => $table_data,
            ]);
    }

    public function indexCu($id)
    {
        $table_data = Artikel::with('kategori', 'penulis', 'Cu')
            ->where('id_cu', $id)
            ->advancedFilter();

        return response()
            ->json([
                'model' => $table_data,
            ]);
    }

    public function create()
    {
        return response()
            ->json([
                'form' => Artikel::initialize(),
                'rules' => Artikel::$rules,
                'option' => [],
            ]);
    }

    public function store(Request $request)
    {
        $request->validate(Artikel::$rules);
        $this->sanitizeRequestContent($request, ['content']);

        $name = $request->name;

        // processing single image upload
        if (! empty($request->gambar)) {
            $fileName = Helper::image_processing($this->imagepath, $this->width, $this->height, $request->gambar, '', $name);
        } else {
            $fileName = '';
        }

        $kelas = Artikel::create($request->except('gambar') + [
            'gambar' => $fileName,
        ]);

        return response()
            ->json([
                'saved' => true,
                'message' => $this->message.' '.$name.' berhasil ditambah',
            ]);
    }

    public function show($id)
    {
        $kelas = Artikel::with('kategori')->findOrFail($id);

        return response()
            ->json([
                'model' => $kelas,
            ]);
    }

    public function edit($id)
    {
        $kelas = Artikel::findOrFail($id);

        return response()
            ->json([
                'form' => $kelas,
                'option' => [],
            ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate(Artikel::$rules);
        $this->sanitizeRequestContent($request, ['content']);

        $name = $request->name;

        $kelas = Artikel::findOrFail($id);

        $this->cleanupRemovedEditorImages($kelas->content, $request->content, 'artikel');

        // processing single image upload
        if (! empty($request->gambar)) {
            $fileName = Helper::image_processing($this->imagepath, $this->width, $this->height, $request->gambar, $kelas->gambar, $name);
        } else {
            $fileName = '';
        }

        $kelas->update($request->except('gambar') + [
            'gambar' => $fileName,
        ]);

        return response()
            ->json([
                'saved' => true,
                'message' => $this->message.' '.$name.' berhasil diubah',
            ]);
    }

    public function updateTerbitkan($id)
    {
        $kelas = Artikel::findOrFail($id);

        if ($kelas->terbitkan == 1) {
            $kelas->terbitkan = 0;
            $message = $this->message.' berhasil tidak diterbitkan';
        } else {
            $kelas->terbitkan = 1;
            $message = $this->message.' berhasil diterbitkan';
        }

        $kelas->update();

        return response()
            ->json([
                'saved' => true,
                'message' => $message,
            ]);
    }

    public function updateUtamakan($id)
    {
        $kelas = Artikel::findOrFail($id);

        if ($kelas->utamakan == 1) {
            $kelas->utamakan = 0;
            $message = $this->message.' berhasil tidak diutamakan';
        } else {
            $kelas->utamakan = 1;
            $message = $this->message.' berhasil diutamakan';
        }

        $kelas->update();

        return response()
            ->json([
                'saved' => true,
                'message' => $message,
            ]);
    }

    public function destroy($id)
    {
        $kelas = Artikel::findOrFail($id);
        $name = $kelas->name;

        if (! empty($kelas->gambar)) {
            File::delete($this->imagepath.$kelas->gambar.'.jpg');
            File::delete($this->imagepath.$kelas->gambar.'n.jpg');
        }

        $this->deleteAllEditorImages($kelas->content, 'artikel');

        $kelas->delete();

        return response()
            ->json([
                'deleted' => true,
                'message' => $this->message.' '.$name.'berhasil dihapus',
            ]);
    }

    public function upload(Request $request)
    {
        if (! empty($request->gambar)) {
            $fileName = Helper::image_processing($this->imagepath, $this->width, $this->height, $request->gambar, '', $request->name);
        } else {
            $fileName = '';
        }

        return response()->json('/'.$this->imagepath.$fileName.'.jpg');
    }

    public function count()
    {
        $id = \Auth::user()->id_cu;

        if ($id == 0) {
            $table_data = Artikel::count();
        } else {
            $table_data = Artikel::where('id_cu', $id)->count();
        }

        return response()
            ->json([
                'model' => $table_data,
            ]);
    }
}
