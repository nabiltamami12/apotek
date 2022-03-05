<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use Exception;
use Illuminate\Http\Request;
use App\Models\Jenis;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;
use App\Models\Identitas;

class RekapLabaController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.transaksi.laba.index');
    }

    public function preview(Request $request) {
    	
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return redirect('/laporan/laba');
            } else {
            	$start = $input['start'];
		        $end = $input['end'];
                $jenis = ($input['jenis'] != null && trim($input['jenis']) != '') ? Jenis::find($input['jenis']) : null;

		        $data = [];
		        $cacah = 0;

		        $periode = null;
		        if ($start == '' || $end == '') {
                    if ($jenis == null || trim($jenis) == '') {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                    $pembelian = DB::table('pembelian_detail')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    } else {
                        $periode = 'Jenis Barang : '.$jenis->nama;
                        $penjualan = DB::table('penjualan_detail')
                            ->join('barang', 'barang.id', '=', 'penjualan_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                            $pembelian = DB::table('pembelian_detail')
                            ->join('barang', 'barang.id', '=', 'pembelian_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    }
		            
		           
		        } else {
		        	$periode = 'Periode : '.$start.' s/d '.$end;
		            $arr_tgl_dari = explode ("/", $start, 3);
		            $arr_tgl_sampai= explode ("/", $end, 3);

		            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
                    $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';

                    if ($jenis == null || trim($jenis) == '') {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->whereBetween('penjualan.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                    

                    $pembelian = DB::table('pembelian_detail')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->whereBetween('pembelian.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    } else {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('barang', 'barang.id', '=', 'penjualan_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->where('jenis.id', $jenis->id)
                            ->whereBetween('penjualan.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                        $pembelian = DB::table('pembelian_detail')
                            ->join('barang', 'barang.id', '=', 'pembelian_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->where('jenis.id', $jenis->id)
                            ->whereBetween('pembelian.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();

                         $periode .= ', Jenis : '.$jenis->nama;
                    }

		            

		            
				} 

                $totpenjualan = 0;
                $totpenjualanrata = 0;
				if ($penjualan != null) {
                    $totpenjualan = $penjualan->total;
                }
				($pembelian != null) ? $totpembelian = $pembelian->total : $totpembelian = 0;

				$totpendapatan = $totpenjualan;
				$totpengeluaran = $totpembelian;
				$totgrandtotal = $totpendapatan - $totpengeluaran;

		            $pdf = App::make('dompdf.wrapper');
		            
		            	$pdf->loadView('laporan.transaksi.laba.print', 
			                [
			                    'penjualan' => $totpenjualan,
			                    'pembelian' => $totpembelian,
			                    'pendapatan' => $totpendapatan,
			                    'pengeluaran' => $totpengeluaran,
			                    'grandtotal' => $totgrandtotal,
			                    'periode' => $periode,
			                ]
			            );
		           
		            $pdf->setPaper('a4')->setWarnings(false);
		            return $pdf->stream();
		    	
            }
        
    }

    public function getRekapLaba(Request $request) {
    	if (!$request->ajax()) {
            return null;
        }

        $input = $request->all();

        $data = [];

        $start = $input['start'];
        $end = $input['end'];
        $jenis = ($input['jenis'] != null && trim($input['jenis']) != '') ? Jenis::find($input['jenis']) : null;

        // dd($input);

        // $users = DB::table('orders')
        //         ->select('department', DB::raw('SUM(price) as total_sales'))
        //         ->groupBy('department')
        //         ->havingRaw('SUM(price) > 2500')
        //         ->get();

        if ($start == '' || $end == '') {
            if ($jenis == null || trim($jenis) == '') {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total, SUM(penjualan_detail.harga_jual_2 * penjualan_detail.jumlah) as totalrata'))
                            ->first();

                    $pembelian = DB::table('pembelian_detail')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    } else {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total, SUM(penjualan_detail.harga_jual_2 * penjualan_detail.jumlah) as totalrata'))
                            ->first();

                            $pembelian = DB::table('pembelian_detail')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    }
            
        } else {
            $arr_tgl_dari = explode ("/", $start, 3);
                    $arr_tgl_sampai= explode ("/", $end, 3);

                    $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
                    $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';

                    if ($jenis == null || trim($jenis) == '') {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->whereBetween('penjualan.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                        $pembelian = DB::table('pembelian_detail')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->whereBetween('pembelian.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    } else {
                        $penjualan = DB::table('penjualan_detail')
                            ->join('barang', 'barang.id', '=', 'penjualan_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('penjualan', 'penjualan.id', '=', 'penjualan_detail.penjualan_id')
                            ->where('jenis.id', $jenis->id)
                            ->whereBetween('penjualan.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(penjualan_detail.harga_jual * penjualan_detail.jumlah) as total'))
                            ->first();

                        $pembelian = DB::table('pembelian_detail')
                            ->join('barang', 'barang.id', '=', 'pembelian_detail.barang_id')
                            ->join('jenis', 'jenis.id', '=', 'barang.jenis_id')
                            ->join('pembelian', 'pembelian.id', '=', 'pembelian_detail.pembelian_id')
                            ->where('jenis.id', $jenis->id)
                            ->whereBetween('pembelian.tgl',[$from, $to], 'and')
                            ->select(DB::raw('SUM(pembelian_detail.harga * pembelian_detail.jumlah) as total'))
                            ->first();
                    }
        } 

        if ($penjualan !== null) {
            $data['penjualan'] = $penjualan->total;
        }

        if ($pembelian !== null) {
            $data['pembelian'] = $pembelian->total;
        }

        // dd($data);

        return response()->json($data);

    }
}

