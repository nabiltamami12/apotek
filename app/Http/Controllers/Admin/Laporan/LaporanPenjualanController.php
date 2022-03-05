<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use App\Models\Penjualan;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

class LaporanPenjualanController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.transaksi.penjualan.index');
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
        $member = $input['member'];
        $data = [];
        $cacah = 0;

        if ($start == '' || $end == '') {
            if ($member == null || trim($member) == '') {
                
                    $penjualan = Penjualan::all();

            } else {
                $penjualan = Penjualan::where('member_id', $member)->get();
            }
        } else {
            $arr_tgl_dari = explode ("/", $start, 3);
            $arr_tgl_sampai= explode ("/", $end, 3);

            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
            $to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';

            if ($member == null || trim($member) == '') {

                $penjualan = Penjualan::whereBetween('tgl',[$from, $to], 'and')->get();
            } else {
                $penjualan = Penjualan::where('member_id', $member)->whereBetween('tgl',[$from, $to], 'and')->get();
            }
        }     

        foreach ($penjualan as $i => $d) {
            $data[$cacah] = [
                $d->tgl->format('d-m-Y H:i:s'), 
                $d->kode, 
                ($d->member_id != null ? $d->member->nama : '-'),
                $d->total(),
                $d->keuntungan(),
                0,
                $d->user->fullname,
                $d->catatan
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
                return redirect('/laporan/penjualan');
            } else {
            	if (!isset($input['lap'])) {
            		return redirect('/laporan/penjualan');
            	} 

            	if ($input['lap'] != 'semua' && $input['lap'] != 'detail') {
            		return redirect('/laporan/penjualan');
            	}

            	$start = $input['start'];
		        $end = $input['end'];
		        $inmember = $input['member'];

                $member = null;
                if ($inmember != null && trim($inmember) != '') {
                    $member = Member::find($inmember);
                }

		        $data = [];
		        $cacah = 0;

		        $periode = null;
		        if ($start == '' || $end == '') {
		            if ($member == null || trim($member) == '') {
		                $penjualan = Penjualan::all();
		            } else {
		            	$periode = 'Member : '.$member->kode.'  -  '.$member->nama;
		                $penjualan = Penjualan::where('member_id', $inmember)->get();
		            }
		        } else {
		        	$periode = 'Periode : '.$start.' s/d '.$end;
		            $arr_tgl_dari = explode ("/", $start, 3);
		            $arr_tgl_sampai= explode ("/", $end, 3);

		            $from = $arr_tgl_dari[2].'/'.$arr_tgl_dari[1].'/'.$arr_tgl_dari[0].' 00:00:00';
            		$to = $arr_tgl_sampai[2].'/'.$arr_tgl_sampai[1].'/'.$arr_tgl_sampai[0].' 23:59:59';

		            if ($member == null || trim($member) == '') {
		                $penjualan = Penjualan::whereBetween('tgl',[$from, $to], 'and')->get();
		            } else {
		                $penjualan = Penjualan::where('member_id', $inmember)->whereBetween('tgl',[$from, $to], 'and')->get();

		                 $periode .= ', Member : '.$member->kode.'  -  '.$member->nama;
		            }
		        } 

		    	if (!$penjualan->isEmpty()) {
		    		$total = 0;
		    		$keuntungan = 0;
                    $keuntunganrata = 0;
		    		foreach ($penjualan as $key => $value) {
		    			$total += $value->total();
		    			$keuntungan += $value->keuntungan();
                        $keuntunganrata += $value->keuntunganrata();
		    		}

		            $pdf = App::make('dompdf.wrapper');
		            if ($input['lap'] == 'semua') {
		            	$pdf->loadView('laporan.transaksi.penjualan.print', 
			                [
			                    'penjualan' => $penjualan,
			                    'periode' => $periode,
			                    'total'=>$total,
			                    'keuntungan'=>$keuntungan,
                                'keuntunganrata'=>$keuntunganrata,
			                ]
			            );
			            // $pdf->setPaper('a4')->setWarnings(false);
		            } else {
		            	$pdf->loadView('laporan.transaksi.penjualan.printdetail', 
			                [
			                    'penjualan' => $penjualan,
			                    'periode' => $periode,
			                    'total'=>$total,
			                    'keuntungan'=>$keuntungan,
                                'keuntunganrata'=>$keuntunganrata,
			                ]
			            );
			            
		            }
		            $pdf->setPaper('a4', 'landscape')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/penjualan');
		    	}
            }
        
    }
}
