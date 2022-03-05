<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\HomeController;
use App\Models\Utility;
use App\Models\Barang;
use App\Models\Member;
use App\Models\Suplier;
use Illuminate\Support\Facades\DB;

class SearchController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function cekHakAkses($hak)
    {
        return response()->json(Auth::user()->can($hak)); 
    }

    public function findBarang(Request $request, $kolom, $keyword) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	if ($kolom == 'kode') {
    		$barang = DB::table('barang')
                    ->select('kode', 'barcode', 'nama', 'harga_beli', 'harga_jual_1', 'harga_jual_2',  'stok')
                    ->where('kode', $keyword)->orWhere('barcode', $keyword)
                    ->first();

	        if ($barang !== null) {
	            return response()->json([
	                'nama' => $barang->nama,
	                'kode' => $barang->kode,
	                'barcode' => $barang->barcode,
	                'harga_beli' => $barang->harga_beli,
	                'harga_jual_1' => $barang->harga_jual_1,
	                'harga_jual_2' => $barang->harga_jual_2,
	                'stok' => $barang->stok,
	            ]);
	        }	
    	} elseif ($kolom == 'id') {
    		$barang = Barang::find($keyword);

	        if ($barang !== null) {
	            return response()->json([
	                'nama' => $barang->nama,
	                'kode' => $barang->kode,
	                'barcode' => $barang->barcode,
	                'harga_beli' => $barang->harga_beli,
	                'harga_jual_1' => $barang->harga_jual_1,
	                'harga_jual_2' => $barang->harga_jual_2,
	                'stok' => $barang->stok,
	            ]);
	        }	
    	}

    	return null;
    }

    public function getSelectMember(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$member = Member::select(['id', 'kode', 'nama'])->get();

    	$data = [];
    	$cacah = 0;
    	foreach ($member as $i => $d) {
                $data[$cacah] = [
                    $d->kode.'  |  '.$d->nama, 
                    $d->id
                ];

                $cacah++; 
               
        }

        return response()->json([
            'data' => $data
        ]);
    }
	
	public function get_select_suplier(Request $request) {
    	if (!$request->ajax()) {
    		return null;
    	}

    	$suplier = Suplier::select(['id', 'kode', 'nama'])->where('aktif', '=', 1)->get();

    	$data = [];
    	$cacah = 0;
    	foreach ($suplier as $i => $d) {
                $data[$cacah] = [
                    $d->kode.'  |  '.$d->nama, 
                    $d->id
                ];

                $cacah++; 
               
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getSelectBarang(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $barang = Barang::select(['id', 'kode', 'nama'])->get();

        $data = [];
        $cacah = 0;
        foreach ($barang as $i => $d) {
                $data[$cacah] = [
                    $d->kode.'  |  '.$d->nama, 
                    $d->id
                ];

                $cacah++; 
               
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getInfoMember(Request $request, $id) {
        if (!$request->ajax()) {
            return null;
        } 

        $member = Member::where(['id'=> $id, 'aktif'=>true])->first();

        if ($member != null) {
            return response()->json([
                'nama' => $member->nama,
                'alamat' => $member->alamat,
                'gsm' => $member->gsm,
                'level' => $member->level,
            ]);
        }

        return null;
    }

    public function getcountdashboard(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $penjualan = DB::table('penjualan_detail')->count(); 
        $pembelian = DB::table('pembelian')->count();
        $barang = DB::table('barang')->count();
        $member = DB::table('member')->where('aktif', true)->count();

        return response()->json([
                'penjualan' => $penjualan,
                'pembelian' => $pembelian,
                'barang' => $barang,
                'member' => $member,
            ]);
    }

    public function menguntungkan(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $barangPenjualan = DB::table('barang')
                    ->join('penjualan_detail', 'penjualan_detail.barang_id', '=', 'barang.id')
                    ->join('pembelian_detail', 'pembelian_detail.suplier_id', '=', 'barang.id')
                    ->select(DB::raw('count(barang.id) as jumlahjual, barang.id'))
                    ->groupBy('barang.id')
                    ->orderBy('jumlahjual', 'desc')
                    ->get();

        $cacah = 0;
        $data = [];

        foreach ($barangPenjualan as $i => $d) {
            $barang = Barang::find($d->id);
            $suplier = Suplier::find($d->id);
            $data[$cacah] = [
                $barang->kode, 
                $barang->barcode,
                $barang->nama, 
                $suplier->nama,
                $d->jumlahjual
            ];

            $cacah++;    
        }

        // $barangNotPenjualan = DB::table('barang')
        //             ->select('id')
        //             ->whereNotExists(function ($query) {
        //                 $query->select(DB::raw(1))
        //                   ->from('penjualan_detail')
        //                   ->whereRaw('barang.id = penjualan_detail.barang_id');
        //             })
        //             ->get();

        // foreach ($barangNotPenjualan as $i => $d) {
        //     $barang = Barang::find($d->id);
        //     $data[$cacah] = [
        //         $barang->kode, 
        //         $barang->barcode,
        //         $barang->nama, 
        //         0
        //     ];

        //     $cacah++;    
        // }

        return response()->json([
            'data' => $data
        ]);
    }

    public function daftarhabis(Request $request) {
        if (!$request->ajax()) {
            return null;
        }

        $barang = Barang::where('stok', '<=', 0)->get();

        $cacah = 0;
        $data = [];

        foreach ($barang as $i => $d) {
            $data[$cacah] = [
                $d->kode, 
                $d->barcode,
                $d->nama, 
                $d->jenis->nama
            ];

            $cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
