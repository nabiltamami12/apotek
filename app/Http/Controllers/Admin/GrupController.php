<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\GrupCreateRequest;
use App\Http\Requests\GrupUpdateRequest;
use App\Models\Permission;
use App\Models\Role;
use App\Models\Utility;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class GrupController extends HomeController
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {

        if (Auth::user()->can('lihat_owner')) {
            $permissions = Permission::all();
        } else {
            $permissions = Permission::where('name', '!=', 'lihat_owner')->get();
        }

        return view('pengaturan.grup.index',compact('permissions'));
    }

    public function grups() {
        $role = Role::all();
        $cacah = 0;
        $data = [];

        foreach ($role as $d) {
            $d->loadTambahan();

            if ($d->name == 'owner') {
                if (Auth::user()->can('lihat_owner')) {
                    $data[$cacah] = [$d->name, $d->display_name, $d->description, $d->id];
                    $cacah++;
                }
            } else {
                $data[$cacah] = [$d->name, $d->display_name, $d->description, $d->id];
                $cacah++;
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function create() {
        if (Auth::user()->can('lihat_owner')) {
            $permissions = Permission::all();
        } else {
            $permissions = Permission::where('name', '!=', 'lihat_owner')->get();
        }
        return view('pengaturan.grup.create', compact('permissions'));
    }

    public function store(GrupCreateRequest $request)
    {

        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $permissions = array_merge([], $input['permissions_grup']);

                unset($input['permissions_grup']);

                $hasil = $this->simpanTransaksiCreate($input, $permissions);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Menyimpan'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal menyimpan data group user! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input, $permissions) {
//        dd($input);

        DB::beginTransaction();

        try {
            $role = new Role();
            $role->name = $input['name'];
            $role->display_name = $input['display_name'];
            $role->description = $input['description'];
            $role->save();

            foreach ($permissions as $index => $value) {
                if (isset($value)) {
                    $perm = Permission::where('id', $value)->first();
                    $role->attachPermission($perm);
                }
            }
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

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);

        $permsRole = $role->perms;

        $permissions_grup = null;

        foreach($permsRole as $i  => $v) {
            $permissions_grup[] = $v->id;
        }

        return response()->json([
            'id'=>$role->id,
            'name' => $role->name,
            'display_name' => $role->display_name,
            'description' => $role->description,
            'permissions_grup' => $permissions_grup,
        ]);

//        dd('edit grup');

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(GrupUpdateRequest $request, $id)
    {
//        dd($request->all());

        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $role = Role::find($id);

                if ($role != null) {
                    $permissions = array_merge([], $input['permissions_grup']);

                    unset($input['permissions_grup']);

                    $hasil = $this->simpanTransaksiUpdate($input, $permissions, $role);
                    if ($hasil == '') {
                        return response()->json([
                            'data' => 'Sukses Mengubah Data'
                        ]);
                    } else {
                        return response()->json([
                            'data' => ['Gagal mengubah data group user! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah data group user! Group User tidak ditemukan']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $permissions, $role) {
        DB::beginTransaction();

        try {

            DB::table('roles')
                ->where('id', $role->id)
                ->update(
                    [
                        'display_name' => $input['display_name'],
                        'description' => $input['description'],
                        'updated_at' => date('Y/m/d H:i:s')
                    ]);

            $role->perms()->sync([]);
            foreach ($permissions as $index => $value) {
                if (isset($value)) {
                    $perm = Permission::where('id', $value)->first();
                    //dd($perm);
                    $role->attachPermission($perm);
                }
            }
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $role = Role::find($id);
        if ($role->name == 'kasir' || $role->name == 'owner' || $role->name == 'admin') {
            return response()->json([
                'data' => ['Grup user ini adalah grup default. Tidak dapat dihapus !']
            ], 422);
        }

        $role->loadTambahan();

        if ($role->banyakpengguna > 0) {
            return response()->json([
                'data' => ['Gagal Menghapus data! Group ini digunakan oleh '.$role->banyakpengguna.' user']
            ], 422);
        }

        $hasil = $this->simpanTransaksiDelete($role);
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

    protected function simpanTransaksiDelete($role)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $role->delete();
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
}
