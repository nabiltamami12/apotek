<?php

namespace App\Http\Controllers\Admin\Laporan;

use App\Http\Controllers\HomeController;
use App\Models\Member;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\App;

class LaporanMemberController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('laporan.master.member.index');
    }

    public function members(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$member = Member::where('aktif', true)->get();

    	$data = [];
        $cacah = 0;

        foreach ($member as $i => $d) {
        	
        		$data[$cacah] = [
	        		$d->kode, 
	        		$d->nama, 
	        		$d->level,
	        		$d->gsm,
	                $d->alamat,
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
                return redirect('/laporan/member');
            } else {
            	$member = Member::where('aktif', true)->get();

		    	if (!$member->isEmpty()) {

		            $pdf = App::make('dompdf.wrapper');
		            $pdf->loadView('laporan.master.member.print', 
		                [
		                    'member' => $member
		                ]
		            );
		            $pdf->setPaper('a4')->setWarnings(false);
		            return $pdf->stream();
		    	} else {
		    		return redirect('/laporan/member');
		    	}
            }
        
    }
}
