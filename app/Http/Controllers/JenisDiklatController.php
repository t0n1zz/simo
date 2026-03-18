<?php
namespace App\Http\Controllers;

use DB;
use App\Models\JenisDiklat;
use Illuminate\Http\Request;

class JenisDiklatController extends Controller{


	public function index()
	{
    	$table_data = JenisDiklat::withCount('hasFasilitator')->advancedFilter();

    	return response()
			->json([
				'model' => $table_data
			]);
	}

	public function get()
	{
		$table_data = JenisDiklat::select('id','name','deskripsi')->orderby('name','asc')->get();

		return response()
			->json([
				'model' => $table_data
			]);
  }
  
	public function create()
	{
		return response()
			->json([
					'form' => JenisDiklat::initialize(),
					'rules' => JenisDiklat::$rules,
					'option' => []
			]);
	}

	public function store(Request $request)
	{
		$request->validate(JenisDiklat::$rules);

		$name = $request->name;

		$kelas = JenisDiklat::create($request->all());
		
		return response()
			->json([
				'saved' => true,
				'message' => 'JenisDiklat ' .$name. ' berhasil ditambah',
				'id' => $kelas->id
			]);	
	}

	public function edit($id)
	{
		$kelas = JenisDiklat::findOrFail($id);

		return response()
				->json([
						'form' => $kelas,
						'option' => []
				]);
	}

	public function update(Request $request, $id)
	{
		$request->validate(JenisDiklat::$rules);

		$name = $request->name;

		$kelas = JenisDiklat::findOrFail($id);

		$kelas->update($request->all());
		
		return response()
			->json([
				'saved' => true,
				'message' => 'JenisDiklat ' .$name. ' berhasil diubah',
				'id' => $kelas->id
			]);	
	}

	public function destroy($id)
	{
		$kelas = JenisDiklat::findOrFail($id);
		$name = $kelas->name;

		$kelas->delete();

		return response()
			->json([
				'deleted' => true,
				'message' => 'JenisDiklat ' .$name. 'berhasil dihapus'
			]);
	}
}