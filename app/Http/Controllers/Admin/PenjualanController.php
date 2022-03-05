<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\PenjualanCreateRequest;
use App\Http\Requests\PenjualanUpdateRequest;
use App\Models\Member;
use App\Models\History;
use App\Models\Barang;
use App\Models\Utility;
use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use Illuminate\Support\Facades\App;
use App\Models\Sementara;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class PenjualanController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('transaksi.penjualan.index');
    }

    public function create() {
    	DB::table('sementara')->truncate();
        return view('transaksi.penjualan.create');
    }

    public function barangpenjualan(Request $request) {
        $data = [];
        if (!$request->ajax()) {
            return response()->json([
                'data' => $data
            ]); 
        }

        $input = $request->all();

        $member = null;

        if (isset($input['member'])) {
            $member = Member::where(['id' => $input['member'], 'aktif'=>true])->first();
        }

        $barang = Barang::all();
        $cacah = 0;

        foreach ($barang as $i => $d) {
            $hargajual = 0;

            if ($member == null || $member->level == '1') {
                $hargajual = $d->harga_jual_1;
            } else if ($member->level == '2') {
                $hargajual = $d->harga_jual_2;
            } else if ($member->level == 3) {
                $hargajual = $d->harga_jual_3;
            }

            $data[$cacah] = [
                $d->kode, 
                $d->nama, 
                $d->jenis->nama,
                $hargajual,
                $d->stok,
                $d->id
            ];

            $cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getpenjualanautocode() {
        $penjualan = DB::table('penjualan')
                ->where('kode', 'like', 'PJ-%')
                ->select('kode')
                ->orderBy('kode', 'desc')
                ->first();

        if ($penjualan == null) {
            return response()->json('PJ-00000001'); 
        } else {
            $kembali = str_replace('PJ-', '', $penjualan->kode);
            $kembali = (int)$kembali;

            $kembali = Utility::sisipkanNol(++$kembali, 8);

            return response()->json('PJ-'.$kembali); 
        }
    }

    public function store(PenjualanCreateRequest $request) {
		
        if ($request->ajax()) {
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $sementara = Sementara::where('kode', $input['kode'])->get();

                if ($sementara != null) {

                    if ($input['catatan'] == null) {
                        $input['catatan'] = '';
                    }

                    $hasil = $this->simpanTransaksiCreate($input, $sementara);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses menyimpan penjualan barang'
                            ]);
                    } else {
                        dd($hasil);
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
            
           // dd(Auth::user());
            $penjualan = new Penjualan;
            $penjualan->kode = $input['kode'];
            $penjualan->bayar = $input['bayar'];
            $penjualan->member_id = $input['member'];
            $penjualan->tipe_bayar = $input['tipe_bayar'];
			//if($input['who_shop'] != null || $input['who_shop']!= ""){
			//	$penjualan->who_shop = $input['who_shop'];
			//}            
            $penjualan->catatan = $input['catatan'];
            $penjualan->user_id = Auth::user()->id;
            $penjualan->tgl = Carbon::now();
            $penjualan->save();

            foreach ($sementara as $key => $value) {
                $penjualandetail = new PenjualanDetail;
                $penjualandetail->penjualan_id = $penjualan->id;
                $barang = $value->barang;

                $penjualandetail->barang_id = $barang->id;
                $penjualandetail->harga_jual = $value->harga;
                $penjualandetail->harga_beli = $barang->harga_beli;
                $penjualandetail->jumlah = $value->jumlah;
                $penjualandetail->save();

                $stok_sebelumnya = $barang->stok;

                $dataubah = [
                    'stok' => $barang->stok - $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $history = new History;
                $history->nama = 'penjualan';
                $history->kode = $penjualan->kode;
                $history->tgl = $penjualan->tgl;
                $history->barang_id = $barang->id;
                $history->stok = $stok_sebelumnya;
                $history->masuk = 0;
                $history->keluar = $value->jumlah;
                $history->saldo = $stok_sebelumnya - $value->jumlah;
                $history->user_id = $penjualan->user_id;
                $history->keterangan = 'Penjualan Barang, No. Bukti : '.$penjualan->kode;
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

    public function penjualans(Request $request) {
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
            $penjualan = Penjualan::all();
        } else {
            $arr_tgl_dari = explode ("/", $start, 3);
            $arr_tgl_sampai= explode ("/", $end, 3);

            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
            $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0]. ' 23:59:59';

            $penjualan = Penjualan::whereBetween('tgl',[$from, $to], 'and')->get();

            // dd($from.', to : '.$to.', penjualan : '.$penjualan);
        }     

        foreach ($penjualan as $i => $d) {
            $data[$cacah] = [
                $d->kode, 
                $d->tgl->format('d-m-Y H:i:s'), 
                $d->total(),
                ($d->member != null ? $d->member->nama : ' - '),
                $d->user->fullname,
                $d->id
            ];

            $cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function show($id) {
        $penjualan = Penjualan::find($id);
        if ($penjualan == null) { 
            return redirect('/penjualan');
        }

        return view('transaksi.penjualan.show', compact('penjualan'));
    }

    public function getdetailjual(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $kode = $request->all()['kode'];
        // dd($kode);
        $penjualan = Penjualan::where('kode', $kode)->first();
        
        $cacah = 0;
        $data = [];

        if ($penjualan != null) {
            foreach ($penjualan->penjualandetail as $i => $d) {
                $barang = $d->barang;
                $data[$cacah] = [$barang->kode, $barang->nama, $barang->jenis->nama, $d->harga_jual, $d->jumlah, $d->jumlah * $d->harga_jual];
                $cacah++;

            }

        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function destroy($id)
    {
        $penjualan = Penjualan::find($id);

        // dd($pembelian);

        $hasil = $this->simpanTransaksiDelete($penjualan);
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

    protected function simpanTransaksiDelete($penjualan)
    {
       // dd($pembelian);
        DB::beginTransaction();

        try {

            foreach ($penjualan->penjualandetail as $key => $value) {
                $barang = $value->barang;

                $dataubah = [
                    'stok' => $barang->stok + $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $historylama = History::where(['barang_id' => $barang->id, 'kode' => $penjualan->kode, 'nama' => 'penjualan'])->first();

                if ($historylama != null) {
                    $historylama->delete();
                }
            }

            $penjualan->delete();
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

    public function siapkanKoreksi(Request $request) {

        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $penjualan = Penjualan::find($input['id']);

                if ($penjualan != null) {
                    $hasil = $this->memprosesKoreksi($penjualan);
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

    protected function memprosesKoreksi($penjualan) {
        DB::beginTransaction();

        try {
            DB::table('sementara')->truncate();

            foreach ($penjualan->penjualandetail as $key => $value) {
                $sementara = new Sementara;
                $sementara->kode = $penjualan->kode;
                $sementara->barang_id = $value->barang_id;
                $sementara->harga = $value->harga_jual;
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
        $penjualan = Penjualan::find($id);
        if ($penjualan == null) {
            return redirect('/penjualan');
        }

        return view('transaksi.penjualan.edit', compact('penjualan'));
    }

    public function update(PenjualanUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $sementara = Sementara::where('kode', $input['kode'])->get();
                $penjualan = Penjualan::where('kode', $input['kode'])->first();

                if ($sementara != null && $penjualan != null) {
                    if ($input['catatan'] == null) {
                        $input['catatan'] = '';
                    }
                    $hasil = $this->simpanTransaksiUpdate($input, $sementara, $penjualan);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses koreksi penjualan barang'
                            ]);
                    } else {
                        dd($hasil);
                            return response()->json([
                                'data' => ['Gagal koreksi transaksi penjualan! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal  koreksi transaksi penjualan! Data transaksi tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $sementara, $penjualan) {
        DB::beginTransaction();
    try {
            foreach ($penjualan->penjualandetail as $key => $value) {
                $barang = $value->barang;
                $dataubah = [
                    'stok' => $barang->stok + $value->jumlah
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $value->delete();

                $historylama = History::where(['barang_id' => $barang->id, 'kode' => $penjualan->kode, 'nama' => 'penjualan'])->first();

                if ($historylama != null) {
                    $historylama->delete();
                }
            }

            foreach ($sementara as $key => $value) {
                $penjualandetail = new PenjualanDetail;
                $penjualandetail->penjualan_id = $penjualan->id;
                $barang = $value->barang;

                $penjualandetail->barang_id = $barang->id;
                $penjualandetail->harga_jual = $value->harga;
                $penjualandetail->harga_jual_3 = $barang->harga_jual_3;
                $penjualandetail->harga_beli = $barang->harga_beli;
                $penjualandetail->jumlah = $value->jumlah;
                $penjualandetail->save();

                $stok_sebelumnya = $barang->stok;

                $dataubah = [
                    'stok' => $barang->stok - $value->jumlah,
                    'updated_at' => date('Y/m/d H:i:s')
                ];

                DB::table('barang')
                    ->where('id', $barang->id)
                    ->update($dataubah);

                $history = new History;
                $history->nama = 'penjualan';
                $history->kode = $penjualan->kode;
                $history->tgl = $penjualan->tgl;
                $history->barang_id = $barang->id;
                $history->stok = $stok_sebelumnya;
                $history->masuk = 0;
                $history->keluar = $value->jumlah;
                $history->saldo = $stok_sebelumnya - $value->jumlah;
                $history->user_id = $penjualan->user_id;
                $history->keterangan = 'Penjualan Barang, No. Bukti : '.$penjualan->kode;
                $history->save();
            }

            $ubahjual = [
                'bayar'=>$input['bayar'],
                'catatan'=>$input['catatan'],
                'member_id'=>$input['member'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('penjualan')
                    ->where('id', $penjualan->id)
                    ->update($ubahjual);

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

    public function barangpenjualankoreksi(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $input = $request->all();

        $kode = $input['kode'];
        $member = null;
        if($input['member'] != null) {
            $member = Member::find($input['member']);
        }

        $penjualan = Penjualan::where('kode', $kode)->first();

        $data = [];

        if ($penjualan != null) {
            $barang = Barang::all();
            $cacah = 0;

            foreach ($barang as $i => $d) {
                $stok = $d->stok;

                $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$d->id])->first();

                // dd($penjualandetail);

                if ($penjualandetail != null) {
                    $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$d->id])->first();
                    $stok += $penjualandetail->jumlah;
                }

                $hargajual = 0;

                if ($member == null || $member->level == '1') {
                    $hargajual = $d->harga_jual_1;
                } else if ($member->level == '2') {
                    $hargajual = $d->harga_jual_2;
                } else if ($member->level == 3) {
                    $hargajual = $d->harga_jual_3;
                }

                $data[$cacah] = [
                    $d->kode, 
                    $d->nama, 
                    $d->jenis->nama,
                    $hargajual,
                    $stok,
                    $d->id
                ];

                $cacah++;    
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function findBarangByKode($kodebarang, $kodetransaksi) {

        $barang = Barang::where('kode', $kodebarang)->first();
        $penjualan = Penjualan::where('kode', $kodetransaksi)->first();

        if ($barang != null) {
            $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$barang->id])->first();

            if ($penjualandetail != null) {
                return response()->json([
                    'nama' => $barang->nama,
                    'kode' => $barang->kode,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual_1' => $barang->harga_jual_1,
                    'harga_jual_2' => $barang->harga_jual_2,
                    'harga_jual_3' => $barang->harga_jual_3,
                    'stok' => $barang->stok + $penjualandetail->jumlah,
                ]);
            } else {
                return response()->json([
                    'nama' => $barang->nama,
                    'kode' => $barang->kode,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual_1' => $barang->harga_jual_1,
                    'harga_jual_2' => $barang->harga_jual_2,
                    'harga_jual_3' => $barang->harga_jual_3,
                    'stok' => $barang->stok,
                ]);
            }
        } 

        return null;
    }

    public function barangfindkoreksi($kodebarang, $kodetransaksi) {
        $barang = Barang::find($kodebarang);
        $penjualan = Penjualan::where('kode', $kodetransaksi)->first();

        if ($barang != null) {
            $penjualandetail = PenjualanDetail::where(['penjualan_id'=>$penjualan->id, 'barang_id'=>$barang->id])->first();

            if ($penjualandetail != null) {
                return response()->json([
                    'nama' => $barang->nama,
                    'kode' => $barang->kode,
                    'harga_beli' => $barang->harga_beli,
                   'harga_jual_1' => $barang->harga_jual_1,
                    'harga_jual_2' => $barang->harga_jual_2,
                    'harga_jual_3' => $barang->harga_jual_3,
                    'stok' => $barang->stok + $penjualandetail->jumlah,
                ]);
            } else {
                return response()->json([
                    'nama' => $barang->nama,
                    'kode' => $barang->kode,
                    'harga_beli' => $barang->harga_beli,
                    'harga_jual_1' => $barang->harga_jual_1,
                    'harga_jual_2' => $barang->harga_jual_2,
                    'harga_jual_3' => $barang->harga_jual_3,
                    'stok' => $barang->stok,
                ]);


            }
        } 

        return null;
    }

     public function strukjual_list(Request $request) {
       $kode = $request->input('kode');
       $penjualan = Penjualan::where('kode', $kode)->first();
        return view('transaksi.penjualan.struk', ['penjualan' => $penjualan]);
    }
    public function strukjual_list2(Request $request) {
        $kode = $request->input('kode');
        $penjualan = Penjualan::where('kode', $kode)->first();
         return view('penjualan.struk', ['penjualan' => $penjualan]);
     }
    function strukcetak($kode){

        $penjualan = Penjualan::where('id', $kode)->first();

       if($penjualan->member != null){
            $kode_member = $penjualan->member->kode;
            $nama_member = $penjualan->member->nama;
        }else{
            $kode_member = '';
            $nama_member = '';
        }

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('transaksi.penjualan.struk_cetak', 
            [
                'penjualan'     => $penjualan,
                'no_faktur'     => $penjualan->kode,
                'tgl'           => $penjualan->tgl,
                // 'kode_member'   => $kode_member,
                // 'nama_member'   => $nama_member,
                // 'gsm_member'    => $penjualan->gsm_member,
                // 'catatan'       => $penjualan->catatan,
                'kasir'         => $penjualan->user->fullname,
                'detail'        => $penjualan->penjualandetail,
                'total'         => $penjualan->total(),
                'bayar'         => $penjualan->bayar,
                'kembalian'     => $penjualan->bayar-$penjualan->total(),
            ]
            );
        $customPaper = array(0,0,150,350);
        $pdf->setPaper($customPaper);
        return $pdf->stream($penjualan->kode.'.pdf');
    }

    // public function strukjual($kode) {
    //     Utility::printStruk($kode);
    // }


}
