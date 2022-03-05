<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use App\Models\Barang;
use App\Models\Opname;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

class LaporanOpnameController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.master.opname.index');
    }

    public function opnames(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

        $input = $request->all();

    	$barang = $input['barang'];
        $start = $input['start'];
        $end = $input['end'];

    	if ($start == '' || $end == '') {
            if ($barang == null || trim($barang) == '') {
                $opname = Opname::all();
            } else {
                $opname = Opname::where('barang_id', $barang)->get();
            }
    	} else {
    		$arr_tgl_dari = explode ("/", $start, 3);
            $arr_tgl_sampai= explode ("/", $end, 3);

            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0];
            $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0];

            if ($barang == null || trim($barang) == '') {

                $opname = Opname::whereBetween('tgl',[$from, $to], 'and')->get();
            } else {
                $opname = Opname::where('barang_id', $barang)->whereBetween('tgl',[$from, $to], 'and')->get();
            }
    	}

    	$data = [];
        $cacah = 0;

        foreach ($opname as $i => $d) {
        	$data[$cacah] = [
        		$d->kode, 
        		$d->tgl->format('d-m-Y'), 
        		$d->barang->kode.' | '. $d->barang->nama, 
        		$d->stok,
                $d->stok_nyata,
                $d->selisih,
        		$d->user->fullname,
                $d->keterangan
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
                return redirect('/laporan/opname');
            } else {
                $start = $input['start'];
                $end = $input['end'];
                $inbarang = $input['barang'];

                $barang = null;
                if ($inbarang != null || trim($inbarang) != '') {
                    $barang = Barang::find($inbarang);
                }

                $periode = null;
                if ($start == '' || $end == '') {
                    if ($barang == null) {
                        $opname = Opname::all();
                    } else {
                        $periode = 'Barang : '.$barang->kode.'  -  '.$barang->nama;
                        $opname = $barang->opname;
                    }
                } else {
                    $periode = 'Periode : '.$input['start'].' s/d '.$input['end'];

                    $arr_tgl_dari = explode ("/", $start, 3);
                    $arr_tgl_sampai= explode ("/", $end, 3);

                    $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0];
                    $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0];

                    if ($barang == null) {
                        $opname = Opname::whereBetween('tgl',[$from, $to], 'and')->get();
                    } else {
                        $opname = Opname::where('barang_id', $barang->id)->whereBetween('tgl',[$from, $to], 'and')->get();
                        $periode .= ', Barang : '.$barang->kode.'  -  '.$barang->nama;
                    }
                } 

                if (!$opname->isEmpty()) {
                    $pdf = App::make('dompdf.wrapper');
                    $pdf->loadView('laporan.master.opname.print', 
                        [
                            'opname' => $opname,
                            'periode' => $periode
                        ]
                    );
                    $pdf->setPaper('a4', 'landscape')->setWarnings(false);
                    return $pdf->stream();
                } else {
                    return redirect('/laporan/opname');
                }
            }
        
    }
}
