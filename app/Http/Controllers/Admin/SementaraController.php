<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\SementaraCreateRequest;
use App\Http\Requests\SementaraUpdateRequest;
use App\Models\Sementara;
use App\Models\Barang;
use App\Models\PenjualanDetail;
use App\Models\Penjualan;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class SementaraController extends HomeController
{
	public function __construct() {
    	parent::__construct();
    }

    public function getSementara(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$input = $request->all();

    	$kode = $input['kode'];
    	// dd($kode);
    	$sementaras = Sementara::with('suplier')->where('kode', $kode)->get();
    	
        $cacah = 0;
        $data = [];

        foreach ($sementaras as $d) {
        	$barang = $d->barang;
            $data[$cacah] = [$barang->kode, $d->suplier->nama, $barang->nama, $d->jumlah, $d->harga, $d->jumlah * $d->harga,  $d->id];
            $cacah++;

        }

        return response()->json([
            'data' => $data
        ]);
    }
	
	public function getSementarajual(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$input = $request->all();

    	$kode = $input['kode'];
    	// dd($kode);
    	$sementaras = Sementara::where('kode', $kode)->get();
    	
        $cacah = 0;
        $data = [];

        foreach ($sementaras as $d) {
        	$barang = $d->barang;
            $data[$cacah] = [$barang->kode,  $barang->nama, $d->jumlah, $d->harga, $d->jumlah * $d->harga,  $d->id];
            $cacah++;

        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(SementaraCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
            	$barang = Barang::where('kode', $input['barang'])->first();
            	$sementara = Sementara::where(['kode'=> $input['kode'], 'barang_id'=>$barang->id])->first();

            	if ($sementara != null) {
            		return response()->json([
                                'data' => ['Gagal! Barang dengan kode '.$input['barang'].' sudah ada di detail pembelian!']
                            ], 422);	
            	}

            	if ($barang != null) {
            		$hasil = $this->simpanTransaksiCreate($input);
	                if ($hasil == '') {
	                        return response()->json([
	                                'data' => 'Sukses Menambahkan Detail Pembelian'
	                            ]);
	                    } else {
	                            return response()->json([
	                                'data' => ['Gagal Menambahkan Detail Pembelian! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
	                            ], 422);
	                    }	
            	} else {
                            return response()->json([
                                'data' => ['Gagal Menambahkan Detail Pembelian! Barang tidak ditemukan']
                            ], 422);
                    }
            }
        }
    }

    protected function simpanTransaksiCreate($input) {
        DB::beginTransaction();

// "qty" => "2"
// "kode" => "PE-00000001"
// "barang" => "BA00001"
        try {
           // dd(Auth::user());
        	$barang = Barang::where('kode', $input['barang'])->first();

            $sementara = new Sementara;
            $sementara->barang_id = $barang->id;
            $sementara->suplier_id = $input['suplier_id'];
            $sementara->harga = $input['harga'];
            $sementara->jumlah = $input['qty'];
            $sementara->kode = $input['kode'];

            $sementara->save();
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

    public function storeJual(SementaraCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $barang = Barang::where('kode', $input['barang'])->first();
                $sementara = Sementara::where(['kode'=> $input['kode'], 'barang_id'=>$barang->id])->first();

                if ($sementara != null) {
                    return response()->json([
                                'data' => ['Gagal! Barang dengan kode '.$input['barang'].' sudah ada di detail penjualan!']
                            ], 422);    
                }

                if ($barang != null) {

                    if ($barang->stok < $input['qty']) {
                        return response()->json([
                                'data' => ['Gagal! Stok barang tidak mencukupi !']
                            ], 422);      
                    }

                    $hasil = $this->simpanTransaksiJualCreate($input);
                    if ($hasil == '') {
                            return response()->json([
                                    'data' => 'Sukses Menambahkan Detail Penjualan'
                                ]);
                        } else {
                                return response()->json([
                                    'data' => ['Gagal Menambahkan Detail Penjualan! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                                ], 422);
                        }   
                } else {
                            return response()->json([
                                'data' => ['Gagal Menambahkan Detail Penjualan! Barang tidak ditemukan']
                            ], 422);
                    }
            }
        }
    }

    protected function simpanTransaksiJualCreate($input) {
        DB::beginTransaction();

// "qty" => "2"
// "kode" => "PE-00000001"
// "barang" => "BA00001"
        try {
           // dd(Auth::user());
            $barang = Barang::where('kode', $input['barang'])->first();

            $sementara = new Sementara;
            $sementara->barang_id = $barang->id;
            $sementara->harga = $input['harga'];
            $sementara->jumlah = $input['qty'];
            $sementara->kode = $input['kode'];

            $sementara->save();
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

    public function storeJualKoreksi(SementaraCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $barang = Barang::where('kode', $input['barang'])->first();
                $sementara = Sementara::where(['kode'=> $input['kode'], 'barang_id'=>$barang->id])->first();

                if ($sementara != null) {
                    return response()->json([
                                'data' => ['Gagal! Barang dengan kode '.$input['barang'].' sudah ada di detail penjualan!']
                            ], 422);    
                }

                if ($barang != null) {
                    $penjualan = Penjualan::where('kode', $input['kode'])->first();
                    $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$barang->id])->first();

                    if ($penjualandetail != null) {
                        if (($barang->stok + $penjualandetail->jumlah) < $input['qty']) {
                            return response()->json([
                                'data' => ['Gagal! Stok barang tidak mencukupi !']
                            ], 422);      
                        }    
                    } else {
                        if ($barang->stok < $input['qty']) {
                            return response()->json([
                                    'data' => ['Gagal! Stok barang tidak mencukupi !']
                                ], 422);      
                        }
                    }

                    $hasil = $this->simpanTransaksiJualCreate($input);
                    if ($hasil == '') {
                            return response()->json([
                                    'data' => 'Sukses Menambahkan Detail Penjualan'
                                ]);
                        } else {
                                return response()->json([
                                    'data' => ['Gagal Menambahkan Detail Penjualan! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                                ], 422);
                        }   
                } else {
                            return response()->json([
                                'data' => ['Gagal Menambahkan Detail Penjualan! Barang tidak ditemukan']
                            ], 422);
                    }
            }
        }
    }

    public function edit($id)
    {
        $sementara = Sementara::find($id);
        $barang = $sementara->barang;

        return response()->json([
            'id' => $sementara->id,
            'barang' => $barang->kode,
            'nama' => $barang->nama,
            'jumlah'=>$sementara->jumlah,
            'stok'=>$barang->stok,
            'harga' => $sementara->harga,
            'total' => $sementara->jumlah * $sementara->harga,
        ]);
    }

    public function editkoreksi($id)
    {
        $sementara = Sementara::find($id);
        $barang = $sementara->barang;
        $penjualan = Penjualan::where('kode', $sementara->kode)->first();

        $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$barang->id])->first();

            if ($penjualandetail != null) {
                return response()->json([
            'id' => $sementara->id,
            'barang' => $barang->kode,
            'nama' => $barang->nama,
            'jumlah'=>$sementara->jumlah,
            'stok'=>$barang->stok + $penjualandetail->jumlah,
            'harga' => $sementara->harga,
            'total' => $sementara->jumlah * $sementara->harga,
        ]);
            } else {
                return response()->json([
            'id' => $sementara->id,
            'barang' => $barang->kode,
            'nama' => $barang->nama,
            'jumlah'=>$sementara->jumlah,
            'stok'=>$barang->stok,
            'harga' => $sementara->harga,
            'total' => $sementara->jumlah * $sementara->harga,
        ]);
            }

        
    }

    public function update(SementaraUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $sementara = Sementara::find($id);

                if ($sementara != null) {

                    $hasil = $this->simpanTransaksiUpdate($input, $sementara);
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
                        'data' => ['Gagal mengubah data! Data tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $sementara) {
        // dd($input);
        DB::beginTransaction();

        try {
            $dataubah = [
                'jumlah' => $input['qty'],
                'harga' => $input['harga'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('sementara')
                ->where('id', $sementara->id)
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

    public function destroy($id)
    {
        $sementara = Sementara::find($id);

        $hasil = $this->simpanTransaksiDelete($sementara);
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

    protected function simpanTransaksiDelete($sementara)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $sementara->delete();
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
