<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\JenisCreateRequest;
use App\Http\Requests\JenisUpdateRequest;
use App\Models\Utility;
use App\Models\Jenis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class JenisController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('master.jenis.index');
    }

    public function jenises() {
    	$jenis = Jenis::all();
        $cacah = 0;
        $data = [];

        foreach ($jenis as $i => $d) {
        	$data[$cacah] = [
        		$d->nama, 
        		$d->id
        	];

        	$cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(JenisCreateRequest $request) {
    	if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => ['Token invalid !!']
                ]);
            } else {

                $hasil = $this->simpanTransaksiCreate($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data ! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
    	DB::beginTransaction();

        try {
            $jenis = new Jenis();
            $jenis->nama = $input['nama'];
            
            $jenis->save();
        } catch (ValidationException $ex) {
            DB::rollback();
            return $ex->getMessage();;
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();;
        }

        DB::commit();

        return '';
    }

    public function edit($id) {
        $jenis = Jenis::find($id);

        return response()->json([
            'id'=>$jenis->id,
            'nama' => $jenis->nama,
        ]);
    }

    public function update(JenisUpdateRequest $request, $id) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $jenis = Jenis::find($id);

                $cari = Jenis::where('nama', $input['nama'])->first();
                if ($cari != null) {
                    if ($jenis->id != $cari->id) {
                        return response()->json([
                            'data' => ['Nama jenis barang sudah digunakan oleh data lainnya!']
                        ], 422);
                    }
                }

                if ($jenis != null) {
                    $hasil = $this->simpanTransaksiUpdate($input, $jenis);
                    if ($hasil == '') {
                        return response()->json([
                            'data' => 'Sukses Mengubah Data'
                        ]);
                    } else {
                        return response()->json([
                            'data' => ['Gagal mengubah data! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah data! Data jenis barang tidak ditemukan di database !']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $jenis) {
        DB::beginTransaction();

        try {

            DB::table('jenis')
                ->where('id', $jenis->id)
                ->update(
                    [
                        'nama' => $input['nama'],
                        'updated_at' => date('Y/m/d H:i:s')
                    ]);
        } catch (ValidationException $ex) {
            DB::rollback();
            return $ex->getMessage();
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }

        DB::commit();

        return '';
    }

    public function destroy($id) {
        $jenis = Jenis::find($id);

        $hasil = $this->simpanTransaksiDelete($jenis);

        if ($hasil === '') {
            return response()->json([
                'data' => 'Sukses Menghapus Data'
            ]);
        } else {
            return response()->json([
                'data' => ['Gagal Menghapus data! Mungkin data ini sedang digunakan oleh data di tabel lainnya!']
            ], 422);
        }
    }

    protected function simpanTransaksiDelete($jenis)
    {
        DB::beginTransaction();

        try {
            $jenis->delete();
        } catch (ValidationException $ex) {
            DB::rollback();
            return $ex->getMessage();
        } catch (Exception $ex) {
            DB::rollback();
            return $ex->getMessage();
        }

        DB::commit();

        return '';
    }
}
