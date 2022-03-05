<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\SuplierCreateRequest;
use App\Http\Requests\SuplierUpdateRequest;
use App\Models\Suplier;
use App\Models\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class SuplierController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('master.suplier.index');
    }

    public function supliers() {
    	$users = Suplier::all();
        $cacah = 0;
        $data = [];

        foreach ($users as $i => $d) {
        	$data[$cacah] = [$d->kode, $d->nama, $d->alamat,$d->telp, $d->bank, $d->norek,  $d->email, $d->aktif, $d->id];			
        	$cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getAutoCode() {
    	$suplier = DB::table('suplier')
                ->where('kode', 'like', 'SUP-%')
                ->select('kode')
                ->orderBy('kode', 'desc')
                ->first();

        if ($suplier == null) {
        	return response()->json('SUP-000001'); 
        } else {
        	$kembali = str_replace('SUP-', '', $suplier->kode);
        	$kembali = (int)$kembali;

        	$kembali = Utility::sisipkanNol(++$kembali, 6);

        	return response()->json('SUP-'.$kembali); 
        }
    }

    public function store(SuplierCreateRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                if ($input['alamat'] == null) {
                    $input['alamat'] = '';
                }
                if ($input['telp'] == null) {
                    $input['telp'] = '';
                }

                $hasil = $this->simpanTransaksiCreate($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data Suplier! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
        DB::beginTransaction();

        try {

            $Suplier = new Suplier();
            $Suplier->kode = $input['kode'];
            $Suplier->nama = $input['nama'];
            $Suplier->alamat = $input['alamat'];
            $Suplier->telp = $input['telp'];
            $Suplier->bank = $input['bank'];
            $Suplier->norek = $input['norek'];
            $Suplier->bank_pemilik = $input['bank_pemilik'];
            $Suplier->email = $input['email'];
            $Suplier->aktif = false;
            $Suplier->save();
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
        $Suplier = Suplier::find($id);

        return response()->json([
            'id' => $Suplier->id,
            'kode' => $Suplier->kode,
            'nama' => $Suplier->nama,
            'alamat' => $Suplier->alamat,
            'telp' => $Suplier->telp,
            'bank' => $Suplier->bank,
            'norek' => $Suplier->norek,
            'bank_pemilik'=>$Suplier->bank_pemilik,
            'email'=>$Suplier->email,
            'aktif'=>$Suplier->aktif
        ]);
    }

    public function update(SuplierUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $Suplier = Suplier::find($id);

                if ($Suplier != null) {
                    if ($input['alamat'] == null) {
                        $input['alamat'] = '';
                    }
                    if ($input['telp'] == null) {
                        $input['telp'] = '';
                    }
                    $hasil = $this->simpanTransaksiUpdate($input, $Suplier);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses Mengubah Data'
                            ]);
                    } else {
                            return response()->json([
                                'data' => ['Gagal mengubah data Suplier! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah data Suplier! Data Suplier tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $suplier) {
        DB::beginTransaction();

        try {
            $dataubahsuplier = [
                'nama' => $input['nama'],
                'alamat' => $input['alamat'],
                'telp' => $input['telp'],
                'bank' => $input['bank'],
                'norek' => $input['norek'],
                'bank_pemilik' => $input['bank_pemilik'],
                'email' => $input['email'],
                'aktif' => $input['aktif'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('suplier')
                ->where('id', $suplier->id)
                ->update($dataubahsuplier);
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
        $suplier = Suplier::find($id);

        $hasil = $this->simpanTransaksiDelete($suplier);
        if ($hasil == '') {
            return response()->json([
                'data' => 'Sukses Menghapus Data'
            ]);
        } else {
            return response()->json([
                'data' => ['Gagal Menghapus data! Mungkin data ini sedang digunakan oleh data di tabel lainnya!']
            ], 422);
        }
    }

    protected function simpanTransaksiDelete($suplier)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $suplier->delete();
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

    public function idCard($id) {
        $suplier = Suplier::find($id);

        $identitas = Identitas::first();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('backend.pengaturan.suplier.kartusuplier', 
            [
                'suplier' => $suplier,
                'identitas' => $identitas
            ]
        );
        $pdf->setPaper('id_card')->setWarnings(false);
        return $pdf->stream();
    }
}
