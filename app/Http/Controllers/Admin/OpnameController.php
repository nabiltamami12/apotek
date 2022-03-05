<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\OpnameCreateRequest;
use App\Models\Barang;
use App\Models\Opname;
use App\Models\Hilang;
use App\Models\History;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class OpnameController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('master.opname.index');
    }

    public function store(OpnameCreateRequest $request) {
    	if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $hasil = $this->simpanTransaksiCreate($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
        DB::beginTransaction();

        try {
        	$barang = Barang::where('kode', $input['barang'])->first();

        	// $table->string('kode', 14)->unique();
         //    $table->date('tgl');
         //    $table->integer('user_id')->unsigned();
         //    $table->foreign('user_id')->references('id')->on('users')->onUpdate('restrict')->onDelete('restrict');
         //    $table->integer('barang_id')->unsigned();
         //    $table->foreign('barang_id')->references('id')->on('barang')->onUpdate('restrict')->onDelete('restrict');
         //    $table->integer('stok')->unsigned()->default(0);
         //    $table->integer('stok_nyata')->unsigned()->default(0);
         //    $table->integer('selisih')->default(0);
         //    $table->string('keterangan', 200);
        	$opname = new Opname;
        	$opname->kode = $input['kode'];
        	$arr_tgl = explode ("/", $input['tgl'], 3);
            $dataTgl = Carbon::now();
            $dataTgl->setDate((int)$arr_tgl[2],(int)$arr_tgl[0],(int)$arr_tgl[1]);
            $opname->tgl = $dataTgl;
        	$opname->user_id = Auth::user()->id;
        	$opname->barang_id = $barang->id;
        	$opname->stok = $input['stok_komputer'];
        	$opname->stok_nyata = $input['stok_nyata'];
        	$opname->selisih = $input['selisih'];
        	$opname->keterangan = $input['keterangan'];

        	$opname->save();

        	$selisih = $input['selisih'];

        	$stok_sebelumnya = $barang->stok;

        	$dataubah = [
            	'stok' => $input['stok_nyata'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('barang')
                ->where('id', $barang->id)
                ->update($dataubah);

            $history = new History;
            $history->nama = 'opname';
            $history->kode = $opname->kode;
        	$history->tgl = $opname->tgl;
        	$history->barang_id = $barang->id;
        	$history->stok = $stok_sebelumnya;

        	if ($selisih < 0) {
        		$hilang = new Hilang;
        		$hilang->id = $opname->id;
        		$hilang->barang_id = $barang->id;
        		$hilang->jumlah = $selisih * -1;

        		$hilang->save();
                
        		$history->masuk = 0;
        		$history->keluar = $selisih * -1;
        	} else {
        		
        		$history->masuk = $selisih;
        		$history->keluar = 0;        		
        	}
        	

        	$history->saldo = $input['stok_nyata'];
        	$history->user_id = $opname->user_id;
        	$history->keterangan = 'Stok Opname, No. Bukti : '.$opname->kode;
        	$history->save();
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
}
