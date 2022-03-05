<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\MemberCreateRequest;
use App\Http\Requests\MemberUpdateRequest;
use App\Models\Member;
use App\Models\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class MemberController extends HomeController
{
    public function __construct() {
    	parent::__construct();
    }

    public function index() {
    	return view('master.member.index');
    }

    public function members() {
    	$users = Member::all();

        $cacah = 0;
        $data = [];

        foreach ($users as $i => $d) {
        	$data[$cacah] = [$d->kode, $d->nama,$d->gsm, $d->alamat, $d->level, $d->aktif, $d->id];
        	$cacah++;    
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getAutoCode() {
    	$member = DB::table('member')
                ->where('kode', 'like', 'CUS-%')
                ->select('kode')
                ->orderBy('kode', 'desc')
                ->first();

        if ($member == null) {
        	return response()->json('CUS-000001'); 
        } else {
        	$kembali = str_replace('CUS-', '', $member->kode);
        	$kembali = (int)$kembali;

        	$kembali = Utility::sisipkanNol(++$kembali, 6);

        	return response()->json('CUS-'.$kembali); 
        }
    }

    public function store(MemberCreateRequest $request) {
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
                if ($input['gsm'] == null) {
                    $input['gsm'] = '';
                }

                $hasil = $this->simpanTransaksiCreate($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data member! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
        DB::beginTransaction();

        try {

            $member = new Member();
            $member->gsm = $input['gsm'];
            $member->alamat = $input['alamat'];
            $member->nama = $input['nama'];
            $member->kode = $input['kode'];
            $member->level = $input['level'];
            $member->aktif = true;

            $member->save();
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
        $member = Member::find($id);

        return response()->json([
            'id' => $member->id,
            'nama' => $member->nama,
            'alamat' => $member->alamat,
            'gsm' => $member->gsm,
            'level' => $member->level,
            'aktif' => $member->aktif,
            'kode'=>$member->kode
        ]);
    }

    public function update(MemberUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            // dd($input);

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $member = Member::find($id);

                if ($member != null) {
                    if ($input['alamat'] == null) {
                        $input['alamat'] = '';
                    }
                    if ($input['gsm'] == null) {
                        $input['gsm'] = '';
                    }
                    $hasil = $this->simpanTransaksiUpdate($input, $member);
                    if ($hasil == '') {
                        return response()->json([
                                'data' => 'Sukses Mengubah Data'
                            ]);
                    } else {
                            return response()->json([
                                'data' => ['Gagal mengubah data member! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                    }
                    
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah data member! Data member tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $member) {
        DB::beginTransaction();

        try {
            $dataubahmember = [
                'alamat' => $input['alamat'],
                'gsm' => $input['gsm'],
                'nama' => $input['nama'],
                'level' => $input['level'],
                'aktif' => $input['aktif'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            DB::table('member')
                ->where('id', $member->id)
                ->update($dataubahmember);
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
        $member = Member::find($id);

        $hasil = $this->simpanTransaksiDelete($member);
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

    protected function simpanTransaksiDelete($member)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $member->delete();
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
        $member = Member::find($id);

        $identitas = Identitas::first();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadView('backend.pengaturan.member.kartumember', 
            [
                'member' => $member,
                'identitas' => $identitas
            ]
        );
        $pdf->setPaper('id_card')->setWarnings(false);
        return $pdf->stream();
    }
}
