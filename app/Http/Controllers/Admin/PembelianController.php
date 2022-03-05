<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\PembelianCreateRequest;
use App\Http\Requests\PembelianUpdateRequest;
use App\Models\Utility;
use App\Models\Barang;
use App\Models\Pembelian;
use App\Models\History;
use App\Models\PembelianDetail;
use App\Models\Sementara;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PembelianController extends HomeController
{

    public function __construct() {
    	parent::__construct();
    }

    public function index() {
        return view('transaksi.pembelian.index');
    }

    public function create() {
        DB::table('sementara')->truncate();
        return view('transaksi.pembelian.create');
    }

    public function getpembelianautocode() {
        $pembelian = DB::table('pembelian')
                ->where('kode', 'like', 'PE-%')
                ->select('kode')
                ->orderBy('kode', 'desc')
                ->first();

        if ($pembelian == null) {
            return response()->json('PE-00000001'); 
        } else {
            $kembali = str_replace('PE-', '', $pembelian->kode);
            $kembali = (int)$kembali;

            $kembali = Utility::sisipkanNol(++$kembali, 8);

            return response()->json('PE-'.$kembali); 
        }
    }

    public function barangpembelian() {
        $barang = Barang::all();
        $cacah = 0;
        $data = [];

        foreach ($barang as $i => $d) {
            $data[$cacah] = [
                $d->kode, 
                $d->nama, 
                $d->jenis->nama,
                $d->harga_beli,
                $d->stok,
                $d->id
            ];

            $cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function pembelians(Request $request) {
        if (!$request->ajax()) {
            return response()->json([
                'data' => []
            ]);
        }

        $input = $request->all();

        $start = $input['start'];
        $end = $input['end'];

        $data = [];
        $cacah = 0;

        if ($start == '' || $end == '') {
            $pembelian = Pembelian::all();
        } else {
            $arr_tgl_dari = explode ("/", $start, 3);
            $arr_tgl_sampai= explode ("/", $end, 3);

            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0];
            $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0];

            $pembelian = Pembelian::whereBetween('tgl',[$from, $to], 'and')->get();
        } 

        foreach ($pembelian as $i => $d) {
            $data[$cacah] = [
                $d->kode, 
                $d->tgl->format('d-m-Y'), 
                $d->total(),
                $d->user->fullname,
                $d->id
            ];

            $cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(PembelianCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $sementara = Sementara::where('kode', $input['kode'])->get();

                if ($sementara != null) {
                    $hasil = $this->simpanTransaksiCreate($input, $sementara);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses menyimpan pembelian barang'
                            ]);
                    } else {
                            return response()->json([
                                'data' => ['Gagal menyimpan! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan! Data transaksi tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiCreate($input, $sementara) {
        DB::beginTransaction();
        try {
            // dd($input);

            $pembelian = new Pembelian;
            $pembelian->kode = $input['kode'];
            $pembelian->user_id = Auth::user()->id;

            $arr_tgl = explode ("/", $input['tgl'], 3);
            $datatgl = Carbon::now();
            $datatgl = $datatgl->setDate((int)$arr_tgl[2],(int)$arr_tgl[0],(int)$arr_tgl[1]);
            $pembelian->tgl = $datatgl;

            $pembelian->save();

            foreach ($sementara as $key => $value) {
                $pembeliandetail = new PembelianDetail;
                $pembeliandetail->pembelian_id = $pembelian->id;
                $pembeliandetail->barang_id = $value->barang_id;
                $pembeliandetail->suplier_id = $value->suplier_id;
                $pembeliandetail->harga = $value->harga;
                $pembeliandetail->jumlah = $value->jumlah;
                $pembeliandetail->save();

                $barang = $pembeliandetail->barang;

                $stok_sebelumnya = $barang->stok;

                $hargabeliupdate = $value->harga;

                $pembulatan = $barang->pembulatan;

                $markup1 = $barang->markup_1;
                $hargamarkup1 = $markup1 * $hargabeliupdate / 100;
                $hargajual1 = $hargamarkup1 + $hargabeliupdate;

                //$hargajual1update = Utility::getHargaPembulatan($hargajual1, $pembulatan);
                $hargajual1update = $hargajual1;

                $markup2 = $barang->markup_2;
                $hargamarkup2 = $markup2 * $hargabeliupdate / 100;
                $hargajual2 = $hargamarkup2 + $hargabeliupdate;

                //$hargajual2update = Utility::getHargaPembulatan($hargajual2, $pembulatan);
                $hargajual2update = $hargajual2;

                $dataubah = [
                    'harga_beli' => $hargabeliupdate,
                    'harga_jual_1' => $hargajual1update,
                    'harga_jual_2' => $hargajual2update,
                    'stok' => $barang->stok + $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $history = new History;
                $history->nama = 'pembelian';
                $history->kode = $pembelian->kode;
                $history->tgl = $pembelian->tgl;
                $history->barang_id = $barang->id;
                $history->stok = $stok_sebelumnya;
                $history->masuk = $value->jumlah;
                $history->keluar = 0;
                $history->saldo = $stok_sebelumnya + $value->jumlah;
                $history->user_id = $pembelian->user_id;
                $history->keterangan = 'Pembelian Barang, No. Bukti : '.$pembelian->kode;
                $history->save();
            }

            DB::table('sementara')->truncate();
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

    public function show($id) {
        $pembelian = Pembelian::find($id);
        if ($pembelian == null) {
            return redirect('/pembelian');
        }

        return view('transaksi.pembelian.show', compact('pembelian'));
    }

    public function getdetailbeli(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $input = $request->all();

        $kode = $input['kode'];
        // dd($kode);
        $pembelian = Pembelian::where('kode', $kode)->first();
        
        $cacah = 0;
        $data = [];

        if ($pembelian != null) {
            $pembeliandetail = $pembelian->pembeliandetail;
            foreach ($pembeliandetail as $i => $d) {
                $barang = $d->barang;
                $data[$cacah] = [$barang->kode, $barang->nama, $barang->jenis->nama, $d->harga, $d->jumlah, $d->jumlah * $d->harga];
                $cacah++;

            }

        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function siapkanKoreksi(Request $request) {

        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $pembelian = Pembelian::find($input['id']);

                if ($pembelian != null) {
                    $hasil = $this->memprosesKoreksi($pembelian);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses menyiapkan data koreksi'
                            ]);
                    } else {
                            return response()->json([
                                'data' => ['Gagal menyiapkan data koreksi! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal menyiapkan data koreksi! Transaksi tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function memprosesKoreksi($pembelian) {
        DB::beginTransaction();

        try {
            DB::table('sementara')->truncate();
            $pembeliandetail = $pembelian->pembeliandetail;

            foreach ($pembeliandetail as $key => $value) {
                $sementara = new Sementara;
                $sementara->kode = $pembelian->kode;
                $sementara->barang_id = $value->barang_id;
                $sementara->harga = $value->harga;
                $sementara->jumlah = $value->jumlah;

                $sementara->save();
            }
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
        $pembelian = Pembelian::find($id);
        if ($pembelian == null) {
            return redirect('/pembelian');
        }

        return view('transaksi.pembelian.edit', compact('pembelian'));
    }

    public function update(PembelianUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $sementara = Sementara::where('kode', $input['kode'])->get();
                $pembelian = Pembelian::where('kode', $input['kode'])->first();

                if ($sementara != null && $pembelian != null) {
                    $hasil = $this->simpanTransaksiUpdate($input, $sementara, $pembelian);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses koreksi pembelian barang'
                            ]);
                    } else {
                            return response()->json([
                                'data' => ['Gagal koreksi transaksi pembelian! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal  koreksi transaksi pembelian! Data transaksi tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $sementara, $pembelian) {
        DB::beginTransaction();
try {

            $pembeliandetail = $pembelian->pembeliandetail;
            foreach ($pembeliandetail as $key => $value) {
                $barang = $value->barang;
                $dataubah = [
                    'stok' => $barang->stok - $value->jumlah
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $value->delete();

                $historylama = History::where(['barang_id' => $barang->id, 'kode' => $pembelian->kode, 'nama' => 'pembelian'])->first();

                if ($historylama != null) {
                    $historylama->delete();
                }
            }

            foreach ($sementara as $key => $value) {
                $pembeliandetail = new PembelianDetail;
                $pembeliandetail->pembelian_id = $pembelian->id;
                $pembeliandetail->barang_id = $value->barang_id;
                $pembeliandetail->harga = $value->harga;
                $pembeliandetail->jumlah = $value->jumlah;
                $pembeliandetail->save();

                $barang = $pembeliandetail->barang;

                $stok_sebelumnya = $barang->stok;

                $hargabeliupdate = $value->harga;

                $pembulatan = $barang->pembulatan;

                $markup1 = $barang->markup_1;
                $rp1 = $barang->rp_1;
                $hargamarkup1 = $markup1 * $hargabeliupdate / 100;
                $hargajual1 = $hargamarkup1 + $hargabeliupdate + $rp1;

                $hargajual1update = Utility::getHargaPembulatan($hargajual1, $pembulatan);

                $markup2 = $barang->markup_2;
                $rp2 = $barang->rp_2;
                $hargamarkup2 = $markup2 * $hargabeliupdate / 100;
                $hargajual2 = $hargamarkup2 + $hargabeliupdate + $rp2;

                $hargajual2update = Utility::getHargaPembulatan($hargajual2, $pembulatan);

                $markup3 = $barang->markup_3;
                $rp3 = $barang->rp_3;
                $hargamarkup3 = $markup3 * $hargabeliupdate / 100;
                $hargajual3 = $hargamarkup3 + $hargabeliupdate + $rp3;

                $hargajual3update = Utility::getHargaPembulatan($hargajual3, $pembulatan);

                $dataubah = [
                    'harga_beli' => $hargabeliupdate,
                    'harga_jual_1' => $hargajual1update,
                    'harga_jual_2' => $hargajual2update,
                    'harga_jual_3' => $hargajual3update,
                    'stok' => $barang->stok + $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $history = new History;
                $history->nama = 'pembelian';
                $history->kode = $pembelian->kode;
                $history->tgl = $pembelian->tgl;
                $history->barang_id = $barang->id;
                $history->stok = $stok_sebelumnya;
                $history->masuk = $value->jumlah;
                $history->keluar = 0;
                $history->saldo = $stok_sebelumnya + $value->jumlah;
                $history->user_id = $pembelian->user_id;
                $history->keterangan = 'Pembelian Barang, No. Bukti : '.$pembelian->kode;
                $history->save();
                
            }

            $arr_tgl = explode ("/", $input['tgl'], 3);
            $tgl = Carbon::createFromDate((int)$arr_tgl[2],(int)$arr_tgl[0],(int)$arr_tgl[1]);

            $ubahbeli = [
                'tgl' => $tgl->format('Y/m/d'),
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('pembelian')
                    ->where('id', $pembelian->id)
                    ->update($ubahbeli);

            DB::table('sementara')->truncate();
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
        $pembelian = Pembelian::find($id);

        // dd($pembelian);

        $hasil = $this->simpanTransaksiDelete($pembelian);
        if ($hasil == '') {
            return response()->json([
                'data' => 'Sukses Menghapus Transaksi'
            ]);
        } else {
            return response()->json([
                'data' => ['Gagal Menghapus transaksi! Mungkin data ini sedang digunakan oleh data di tabel lainnya!']
            ], 422);
        }
    }

    protected function simpanTransaksiDelete($pembelian)
    {
       // dd($pembelian);
        DB::beginTransaction();

        try {
            $pembeliandetail = $pembelian->pembeliandetail;

            foreach ($pembeliandetail as $key => $value) {
                $barang = $value->barang;

                $dataubah = [
                    'stok' => $barang->stok - $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $historylama = History::where(['barang_id' => $barang->id, 'kode' => $pembelian->kode, 'nama' => 'pembelian'])->first();

                if ($historylama != null) {
                    $historylama->delete();
                }
            }

            $pembelian->delete();
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
