<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use App\Models\Barang;
use App\Models\Jenis;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

class LaporanBarangController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.master.barang.index');
    }

    public function barangs(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$jenis = $request->all()['jenis'];

    	if ($jenis == null || trim($jenis) == '') {
    		$barang = Barang::all();
    	} else {
    		$barang = Barang::where('jenis_id', $jenis)->get();
    	}

    	$data = [];
        $cacah = 0;

        foreach ($barang as $i => $d) {
        	$data[$cacah] = [
        		$d->kode, 
        		$d->barcode, 
        		$d->nama, 
        		$d->jenis->nama,
        		$d->stok
        	];

        	$cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function preview(Request $request) {
    	
            $input = $request->all();

            if (!isset($input['_token'])) {
                return redirect('/laporan/barang');
            } else {
            	$jenis = null;
            	if ($input['jenis'] == null || trim($input['jenis']) == '') {
		    		$barang = Barang::all();
		    	} else {
		    		$jenis = Jenis::find($input['jenis']);
		    		$barang = $jenis->barang;
		    	}

		    	if (!$barang->isEmpty()) {

		    		$total = 0;
                    $totalbeli = 0;
                    $totaljual1 = 0;
                    $totaljual2 = 0;
                    $totaljual3 = 0;

		    		foreach ($barang as $key => $value) {
		    			$total += $value->stok;

                        $totalbeli += $value->harga_beli * $value->stok;
                        $totaljual1 += $value->harga_jual_1 * $value->stok;
                        $totaljual2 += $value->harga_jual_2 * $value->stok;
                        $totaljual3 += $value->harga_jual_3 * $value->stok;
		    		}

		            $pdf = App::make('dompdf.wrapper');
		            $pdf->loadView('laporan.master.barang.print', 
		                [
		                    'barang' => $barang,
		                    'jenis' => ($jenis != null ? ', Jenis Barang : '.$jenis->nama : ''),
		                    'total' => $total,
                            'totalbeli' => $totalbeli,
                            'totaljual1' => $totaljual1,
                            'totaljual2' => $totaljual2,
                            'totaljual3' => $totaljual3,
		                ]
		            );
		            $pdf->setPaper('a4', 'landscape')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/barang');
		    	}
            }
        
    }
}
