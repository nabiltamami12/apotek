<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\BarangCreateRequest;
use App\Http\Requests\BarangUpdateRequest;
use App\Models\Utility;
use App\Models\Barang;
use App\Models\Jenis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class BarangController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('master.barang.index');
    }

    public function barangs() {
    	$barang = Barang::all();
        $cacah = 0;
        $data = [];

        foreach ($barang as $i => $d) {
        	$data[$cacah] = [
        		$d->kode, 
        		$d->barcode,
        		$d->nama, 
        		$d->jenis->nama,
        		$d->stok,
        		$d->id
        	];

        	$cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getAutoKode() {
        $barang = DB::table('barang')
                ->where('kode', 'like', 'BA%')
                ->select('kode')
                ->orderBy('kode', 'desc')
                ->first();

        if ($barang == null) {
            return response()->json('BA00001'); 
        } else {
            $kembali = str_replace('BA', '', $barang->kode);
            $kembali = (int)$kembali;

            $kembali = Utility::sisipkanNol(++$kembali, 5);

            return response()->json('BA'.$kembali); 
        }
    }

    public function store(BarangCreateRequest $request) { 
        if ($request->ajax()) {
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $hasil = $this->simpanTransaksiCreate($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
        DB::beginTransaction();

        // dd($input);

        try {

            $barang = new Barang();
            $barang->kode = $input['kode'];
            $barang->barcode = $input['barcode'];
            $barang->nama =  $input['nama'];
            $barang->jenis_id =  $input['jenis'];
            $barang->harga_beli =  $input['harga_beli'];
            $barang->stok =  0;
            $barang->pembulatan =  $input['pembulatan'];
            $barang->markup_1 =  $input['markup_1'];
            $barang->harga_jual_1 =  $input['harga_jual_1'];
            $barang->markup_2 =  $input['markup_2'];
            $barang->harga_jual_2 =  $input['harga_jual_2'];

            $barang->save();
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

    public function edit($id)
    {
        $barang = Barang::find($id);

        return response()->json([
            'id' => $barang->id,
            'kode' => $barang->kode,
            'barcode' => $barang->barcode,
            'nama' => $barang->nama,
            'jenis_id'=>$barang->jenis_id,
            'harga_beli' => $barang->harga_beli,
            'pembulatan' => $barang->pembulatan,
            'markup_1' => $barang->markup_1,
            'harga_jual_1' => $barang->harga_jual_1,
            'markup_2' => $barang->markup_2,
            'harga_jual_2' => $barang->harga_jual_2,
        ]);
    }

    public function update(BarangUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $barang = Barang::find($id);

                $caribarcode = Barang::where('barcode', $input['barcode'])->first();

                if ($caribarcode != null) {
                    if ($caribarcode->id != $barang->id) {
                        return response()->json([
                            'data' => ['Kode barcode barang ini sudah digunakan oleh data lainnya!']
                        ], 422);
                    }
                }

                $carinama = Barang::where('nama', $input['nama'])->first();

                if ($carinama != null) {
                    if ($carinama->id != $barang->id) {
                        return response()->json([
                            'data' => ['Nama barang ini sudah digunakan oleh data lainnya!']
                        ], 422);
                    }
                }

                if ($barang != null) {
                    $hasil = $this->simpanTransaksiUpdate($input, $barang);
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
                        'data' => ['Gagal mengubah data! Data barang tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $barang) {
        // dd($input);
        DB::beginTransaction();

        try {
            $dataubah = [
            	'barcode' => $input['barcode'],
                'nama' => $input['nama'],
                'jenis_id' => $input['jenis'],
                'harga_beli' => $input['harga_beli'],
                'pembulatan' => $input['pembulatan'],
                'markup_1' => $input['markup_1'],
                'harga_jual_1' => $input['harga_jual_1'],
                'markup_2' => $input['markup_2'],
                'harga_jual_2' => $input['harga_jual_2'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('barang')
                ->where('id', $barang->id)
                ->update($dataubah);
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

    public function show($id)
    {
        $barang = Barang::find($id);

        return response()->json([
            'kode' => $barang->kode,
            'barcode' => $barang->barcode,
            'nama' => $barang->nama,
            'jenis'=>$barang->jenis->nama,
            'harga_beli' => $barang->harga_beli,
            'harga_jual_1' => $barang->harga_jual_1,
            'harga_jual_2' => $barang->harga_jual_2
        ]);
    }


    public function destroy($id)
    {
        $barang = Barang::find($id);

        $hasil = $this->simpanTransaksiDelete($barang);
        if ($hasil == '') {
            return response()->json([
                'data' => 'Sukses Menghapus Data'
            ]);
        } else {
            return response()->json([
                'data' => ['Gagal Menghapus data! Mungkin data ini sedang digunakan oleh data di tabel lainnya!']
            ], 422);
        }
    }

    protected function simpanTransaksiDelete($barang)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $barang->delete();
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
