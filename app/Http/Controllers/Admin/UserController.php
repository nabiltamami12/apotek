<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\HomeController;
use App\Http\Requests\UserCreateRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Http\Requests\UserPasswordRequest;
use App\Models\Role;
use App\Models\User;
use App\Models\Utility;
use Exception;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends HomeController
{
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        return view('pengaturan.user.index');
    }

    public function users() {
        $user = User::all();
        $cacah = 0;
        $data = [];

        foreach ($user as $d) {
            $d->loadTambahan();

            if ($d->role()->name == 'owner') {
                if (Auth::user()->can('lihat_owner')) {
                    $data[$cacah] = [$d->username, $d->fullname, $d->role_name, $d->active, $d->id];
                    $cacah++;
                }
            } else {
                $data[$cacah] = [$d->username, $d->fullname, $d->role_name, $d->active, $d->id];
                $cacah++;   
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function getSelectGroup() {
        $role = DB::table('roles')->select('id', 'display_name', 'name')
                ->orderBy('display_name')->get();

        $cacah = 0;
        $data = [];

        foreach ($role as $i => $d) {

            if ($d->name == 'owner') {
                if (Auth::user()->can('lihat_owner')) {
                    $data[$cacah] = [$d->id, $d->display_name];
                    $cacah++;
                }
            } else {
                $data[$cacah] = [$d->id, $d->display_name];
                $cacah++;
            }
        }

        return response()->json([
            'data' => $data
        ]);
    }

    public function store(UserCreateRequest $request)
    {
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
                        'data' => ['Gagal menyimpan data user! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiCreate($input) {
//        dd($input);


        DB::beginTransaction();

        try {

            $user = new User();
            $user->fullname = $input['fullname'];
            $user->username = $input['username'];
            $user->password = bcrypt($input['password']);
            $user->active = $input['active'];
            $user->save();

            $role = Role::where('id', $input['role'])->first();

            $user->attachRole($role);
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
        $user = User::find($id);

        return response()->json([
            'id' => $user->id,
            'username' => $user->username,
            'role' => $user->role()->id,
            'fullname' => $user->fullname,
            'active' => $user->active
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                $user = User::find($id);

                $userCari = User::where('username', $input['username'])->first();
                if ($userCari != null) {
                    if ($user->id != $userCari->id) {
                        return response()->json([
                            'data' => ['Username ini sudah digunakan oleh data lainnya!']
                        ], 422);
                    }
                }
                if ($user != null) {
                    $role = Role::find($input['role']);
                    if ($role != null) {
                        $hasil = $this->simpanTransaksiUpdate($input, $user, $role);
                        if ($hasil == '') {
                            return response()->json([
                                'data' => 'Sukses Mengubah Data'
                            ]);
                        } else {
                            return response()->json([
                                'data' => ['Gagal mengubah data user! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                            ], 422);
                        }
                    } else {
                        return response()->json([
                            'data' => ['Group User tidak terdaftar di database! Silahkan refresh browser anda!']
                        ], 422);
                    }
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah data user! User Aplikasi tidak ditemukan di database']
                    ], 422);
                }
            }
        }
    }

    protected function simpanTransaksiUpdate($input, $user, $role) {
        DB::beginTransaction();

        try {
            $dataubah = [
                'fullname' => $input['fullname'],
                'username' => $input['username'],
                'active' => $input['active'],
                'updated_at' => date('Y/m/d H:i:s')
            ];

            if ($input['ubahkatasandi'] != '0') {
                $dataubah['password'] = bcrypt($input['password']);
            }

            DB::table('users')
                ->where('id', $user->id)
                ->update($dataubah);

            $user->roles()->sync([]);
            $user->attachRole($role);
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
        $user = User::find($id);

        if ($user->id == Auth::user()->id) {
            return response()->json([
                'data' => ['Tidak dapat menghapus user yang sedang aktif saat ini']
            ], 422);
        }

        $user->loadTambahan();

        $hasil = $this->simpanTransaksiDelete($user);
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

    protected function simpanTransaksiDelete($user)
    {
//        dd($input);
        DB::beginTransaction();

        try {
            $user->delete();
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

    public function changePassword(UserPasswordRequest $request) {
        if ($request->ajax()) {
            $input = $request->all();

            if (!isset($input['_token'])) {
                return response()->json([
                    'data' => $input->toArray()
                ]);
            } else {
                if (!isset($input['passwordlama'])) {
                    return response()->json([
                        'data' => ['Gagal mengubah password. Password lama tidak ada!!!']
                    ], 422);
                }

                if (!isset($input['passwordbaru'])) {
                    return response()->json([
                        'data' => ['Gagal mengubah password. Password baru tidak ada!!!']
                    ], 422);
                }

                if (!Hash::check($input['passwordlama'], Auth::user()->password)) {
                    return response()->json([
                        'data' => ['Password lama tidak benar!!!']
                    ], 422);
                }

                $hasil = $this->simpanTransaksiPassword($input);
                if ($hasil == '') {
                    return response()->json([
                        'data' => 'Sukses Mengubah Password'
                    ]);
                } else {
                    return response()->json([
                        'data' => ['Gagal mengubah password! Periksa data anda dan pastikan server MySQL anda sedang aktif!']
                    ], 422);
                }

            }
        }
    }

    protected function simpanTransaksiPassword($input) {
        DB::beginTransaction();

        try {

            $dataubah = [
                'password' => bcrypt($input['passwordbaru']),
                'updated_at' => date('Y/m/d H:i:s')
            ];
            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update($dataubah);
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