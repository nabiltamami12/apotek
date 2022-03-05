<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use Exception;
use Illuminate\Http\Request;
use App\Models\Jenis;
use App\Models\PembelianDetail;
use App\Models\PenjualanDetail;
use App\Models\Barang;
use App\Models\Suplier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;
use App\Models\Identitas;

class RekapKonsinyasiController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.master.suplier.index');
    }
	
	public function konsinyasis(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$suplier = Suplier::all();

    	$data = [];
        $cacah = 0;

        foreach ($suplier as $i => $d) {
        	
        		$data[$cacah] = [
	        		$d->kode, 
	        		$d->nama, 
	        		$d->alamat,
	        		$d->telp,
	                //$d->bank+"  |  "+$d->bank_pemilik,
	                $d->bank,
	                $d->norek,
	                $d->email,
	                $d->aktif,
	                $d->id,
	        	];

	        	$cacah++;    
        	
        }

        return response()->json([
            'data' => $data
        ]);
    }
	
	public function cetak_data(Request $request) {
    	
            $input = $request->all();

            if (!isset($input['_token'])) {
                return redirect('/laporan/konsinyasi');
            } else {
            	$konsinyasi = Suplier::orderBy('aktif', 'DESC')->get();

		    	if (!$konsinyasi->isEmpty()) {

		            $pdf = App::make('dompdf.wrapper');
		            $pdf->loadView('laporan.master.suplier.print', 
		                [
		                    'konsinyasi' => $konsinyasi
		                ]
		            );
		            $pdf->setPaper('ltter', 'landscape')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/konsinyasi');
		    	}
            }
        
    }
	
	public function rekapkonsinyasi($id_suplier) {
		
		$suplier=Suplier::findOrFail($id_suplier); //return $suplier->id;
    	return view('laporan.master.suplier.rekap', compact('suplier'));
    }
	
	
	
	public function cetakrekapkonsinyasi(Request $request) {
    	
		$input = $request->all(); 
		
        if (!isset($request->id_suplier)) {
                return redirect('/laporan/konsinyasi');
		} else { 
			$start = $input['start'];
			$end = $input['end'];
			
			$periode = 'Periode : '.$start.' s/d '.$end;
			$arr_tgl_dari = explode ("/", $start, 3);
			$arr_tgl_sampai= explode ("/", $end, 3);
			
			$from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
			$to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';
						
			$suplier=Suplier::findOrFail($request->id_suplier);
			
			$konsinyasi = Barang::leftjoin('pembelian_detail', 'pembelian_detail.barang_id', '=', 'barang.id')
						->leftjoin('suplier', 'suplier.id', '=', 'pembelian_detail.suplier_id')
						->select('barang.id', 'barang.barcode', 'barang.nama',  'barang.harga_beli AS hpp', 'barang.harga_jual_1')
							->with(['pembeliandetail' => function($query) use ($from, $to) {
								 $query->select('pembelian_detail.barang_id', DB::raw('SUM(pembelian_detail.jumlah) as qty_in'), 'pembelian_detail.created_at')
									   ->whereBetween('pembelian_detail.created_at',[$from, $to])
									   ->groupBy('pembelian_detail.barang_id');
								}])								
							->with(['penjualandetail' => function($query) use ($from, $to) {
								 $query->select('penjualan_detail.barang_id', DB::raw('SUM(penjualan_detail.jumlah) as qty_out'), 'penjualan_detail.created_at')
									    ->whereBetween('penjualan_detail.created_at',[$from, $to])
										->groupBy('penjualan_detail.barang_id');
								}])
							->with(['history' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.saldo as stok')
									    ->whereBetween('history.created_at',[$from, $to])
										->orderBy('history.tgl', 'desc');
								}])
							
							->with(['stok_awal' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.stok as awal')
									    ->where('history.created_at', '>=', $from)
										->orderBy('history.tgl', 'asc');
								}])
								
							->with(['stok_awal_tdk_transaksi' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.stok as awal', 'history.saldo as stok')
										->orderBy('history.tgl', 'desc');
								}])
						->groupBy('barang.barcode')
						->where('suplier.id', '=', $request->id_suplier)
						->get(); 
						//return $konsinyasi;

		    	if (!$konsinyasi->isEmpty()) {

		            $pdf = App::make('dompdf.wrapper');
		            $pdf->loadView('laporan.master.suplier.print_konsinyasi', 
		                [
		                    'konsinyasi' => $konsinyasi, 
							'from' => $from, 
							'to' => $to, 
							'suplier' => $suplier
		                ]
		            );
		            $pdf->setPaper('legal', 'landscape')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/konsinyasi');
		    	}
		}
        
    }
	
	public function cetakrekapkonsinyasiForSuplier(Request $request) {
    	
		$input = $request->all(); 
		
        if (!isset($request->id_suplier)) {
                return redirect('/laporan/konsinyasi');
		} else { 
			$start = $input['start'];
			$end = $input['end'];
			
			$periode = 'Periode : '.$start.' s/d '.$end;
			$arr_tgl_dari = explode ("/", $start, 3);
			$arr_tgl_sampai= explode ("/", $end, 3);
			
			$from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
			$to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';
			
			$suplier=Suplier::findOrFail($request->id_suplier);
			
			$konsinyasi = Barang::leftjoin('pembelian_detail', 'pembelian_detail.barang_id', '=', 'barang.id')
						->leftjoin('suplier', 'suplier.id', '=', 'pembelian_detail.suplier_id')
						->select('barang.id', 'barang.barcode', 'barang.nama',  'barang.harga_beli AS hpp', 'barang.harga_jual_1')
							->with(['pembeliandetail' => function($query) use ($from, $to) {
								 $query->select('pembelian_detail.barang_id', DB::raw('SUM(pembelian_detail.jumlah) as qty_in'), 'pembelian_detail.created_at')
									   ->whereBetween('pembelian_detail.created_at',[$from, $to])
									   ->groupBy('pembelian_detail.barang_id');
								}])								
							->with(['penjualandetail' => function($query) use ($from, $to) {
								 $query->select('penjualan_detail.barang_id', DB::raw('SUM(penjualan_detail.jumlah) as qty_out'), 'penjualan_detail.created_at')
									    ->whereBetween('penjualan_detail.created_at',[$from, $to])
										->groupBy('penjualan_detail.barang_id');
								}])
							
							->with(['history' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.saldo as stok')
									    ->whereBetween('history.created_at',[$from, $to])
										->orderBy('history.tgl', 'desc');
								}])
								->with(['stok_awal' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.stok as awal')
									    ->where('history.created_at', '>=', $from)
										->orderBy('history.tgl', 'asc');
								}])
							
							->with(['stok_awal' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.stok as awal')
									    ->where('history.created_at', '>=', $from)
										->orderBy('history.tgl', 'asc');
								}])
								
							->with(['stok_awal_tdk_transaksi' => function($query) use ($from, $to) {
								 $query->select('history.barang_id', 'history.stok as awal', 'history.saldo as stok')
										->orderBy('history.tgl', 'desc');
								}])
								
						->groupBy('barang.barcode')
						->where('suplier.id', '=', $request->id_suplier)
						->get(); 
						//return $konsinyasi;

		    	if (!$konsinyasi->isEmpty()) {

		            $pdf = App::make('dompdf.wrapper');
		            $pdf->loadView('laporan.master.suplier.print_for_suplier', 
		                [
		                    'konsinyasi' => $konsinyasi, 
							'from' => $from, 
							'to' => $to, 
							'suplier' => $suplier
		                ]
		            );
		            $pdf->setPaper('legal', 'landscape')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/konsinyasi');
		    	}
		}
        
    }

}

