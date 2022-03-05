<?php

use App\Models\Permission;
use Illuminate\Database\Seeder;
use App\Models\Role;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $ownerRole = Role::where('name', 'owner')->first();
        $adminRole = Role::where('name', 'admin')->first();
        $kasirRole = Role::where('name', 'kasir')->first();

        $permissions = [
            // User
            'lihat_user' => [
                'name' => 'lihat_user',
                'display_name' => 'Lihat Pengguna',
                'description' => 'Melihat Daftar Pengguna Aplikasi'
            ],
            'tambah_user' => [
                'name' => 'tambah_user',
                'display_name' => 'Tambah Pengguna',
                'description' => 'Menambah Pengguna Aplikasi Baru'
            ],
            'ubah_user' => [
                'name' => 'ubah_user',
                'display_name' => 'Ubah Data Pengguna',
                'description' => 'Mengubah Data Pengguna Aplikasi'
            ],
            'hapus_user' => [
                'name' => 'hapus_user',
                'display_name' => 'Hapus Data Pengguna',
                'description' => 'Menghapus Data Pengguna Aplikasi'
            ],

            // member
            'lihat_member' => [
                'name' => 'lihat_member',
                'display_name' => 'Lihat Member',
                'description' => 'Melihat Daftar Member'
            ],
            'tambah_member' => [
                'name' => 'tambah_member',
                'display_name' => 'Tambah Member',
                'description' => 'Menambah Member Baru'
            ],
            'ubah_member' => [
                'name' => 'ubah_member',
                'display_name' => 'Ubah Data Member',
                'description' => 'Mengubah Data Member'
            ],
            'hapus_member' => [
                'name' => 'hapus_member',
                'display_name' => 'Hapus Data Member',
                'description' => 'Menghapus Data Member'
            ],
            // member - end

            // GRUP

            'lihat_grup' => [
                'name' => 'lihat_grup',
                'display_name' => 'Lihat Grup Pengguna',
                'description' => 'Melihat Daftar Grup Pengguna Aplikasi'
            ],
            'tambah_grup' => [
                'name' => 'tambah_grup',
                'display_name' => 'Tambah Grup Pengguna',
                'description' => 'Menambah Grup Pengguna Aplikasi Baru'
            ],
            'ubah_grup' => [
                'name' => 'ubah_grup',
                'display_name' => 'Ubah Data Grup Pengguna',
                'description' => 'Mengubah Data Grup Pengguna Aplikasi'
            ],
            'hapus_grup' => [
                'name' => 'hapus_grup',
                'display_name' => 'Hapus Data Grup Pengguna',
                'description' => 'Menghapus Data Grup Pengguna Aplikasi'
            ],

            // Owner

            'lihat_owner' => [
                'name' => 'lihat_owner',
                'display_name' => 'Lihat Grup Pembuat Software',
                'description' => 'Melihat Grup Pembuat Software'
            ],

            // Backup dan Restore Database
            // 'backup_database' => [
            //     'name' => 'backup_database',
            //     'display_name' => 'Backup Database',
            //     'description' => 'Backup Database Aplikasi'
            // ],
            // 'restore_database' => [
            //     'name' => 'restore_database',
            //     'display_name' => 'Restore Database',
            //     'description' => 'Restore Database Aplikasi'
            // ],

            // jenis
            'lihat_jenis' => [
                'name' => 'lihat_jenis',
                'display_name' => 'Lihat Daftar Jenis Barang',
                'description' => 'Melihat Daftar Jenis Barang'
            ],
            'tambah_jenis' => [
                'name' => 'tambah_jenis',
                'display_name' => 'Tambah Jenis Barang',
                'description' => 'Menambah Jenis Barang Baru'
            ],
            'ubah_jenis' => [
                'name' => 'ubah_jenis',
                'display_name' => 'Ubah Data Jenis Barang',
                'description' => 'Mengubah Data Jenis Barang'
            ],
            'hapus_jenis' => [
                'name' => 'hapus_jenis',
                'display_name' => 'Hapus Data Jenis Barang',
                'description' => 'Menghapus Data Jenis Barang'
            ],
            // jenis - end 

            // barang
            'lihat_barang' => [
                'name' => 'lihat_barang',
                'display_name' => 'Lihat Daftar Barang',
                'description' => 'Melihat Daftar Barang'
            ],
            'tambah_barang' => [
                'name' => 'tambah_barang',
                'display_name' => 'Tambah Barang',
                'description' => 'Menambah Barang Baru'
            ],
            'ubah_barang' => [
                'name' => 'ubah_barang',
                'display_name' => 'Ubah Data Barang',
                'description' => 'Mengubah Data Barang'
            ],
            'hapus_barang' => [
                'name' => 'hapus_barang',
                'display_name' => 'Hapus Data Barang',
                'description' => 'Menghapus Data Barang'
            ],
            // barang - end 

            // stok opname
            'lihat_opname' => [
                'name' => 'lihat_opname',
                'display_name' => 'Transaksi Stok Opname',
                'description' => 'Menambahkan Transaksi Stok Opname'
            ],

            // stok opname - end
            // pembelian
            'lihat_pembelian' => [
                'name' => 'lihat_pembelian',
                'display_name' => 'Lihat Pembelian Stok Barang',
                'description' => 'Melihat Pembelian Stok Barang'
            ],
            'tambah_pembelian' => [
                'name' => 'tambah_pembelian',
                'display_name' => 'Tambah Pembelian Stok Barang',
                'description' => 'Menambahkan Pembelian Stok Barang'
            ],
            'ubah_pembelian' => [
                'name' => 'ubah_pembelian',
                'display_name' => 'Ubah Pembelian Stok Barang',
                'description' => 'Mengubah Data Pembelian Stok Barang'
            ],
            'hapus_pembelian' => [
                'name' => 'hapus_pembelian',
                'display_name' => 'Hapus Pembelian Stok Barang',
                'description' => 'Menghapus Data Transaksi Pembelian Stok Barang'
            ],

            // penjualan

            'lihat_penjualan' => [
                'name' => 'lihat_penjualan',
                'display_name' => 'Lihat Penjualan Barang',
                'description' => 'Melihat Penjualan Barang'
            ],
            'tambah_penjualan' => [
                'name' => 'tambah_penjualan',
                'display_name' => 'Tambah Penjualan Barang',
                'description' => 'Menambahkan Penjualan Barang'
            ],
            'ubah_penjualan' => [
                'name' => 'ubah_penjualan',
                'display_name' => 'Ubah Penjualan Barang',
                'description' => 'Mengubah Data Penjualan Barang'
            ],
            'hapus_penjualan' => [
                'name' => 'hapus_penjualan',
                'display_name' => 'Hapus Penjualan Barang',
                'description' => 'Menghapus Data Penjualan Barang'
            ],


            // Transaksi end

            // Laporan 

            // histrory member
            'lihat_laporan_member' => [
                'name' => 'lihat_laporan_member',
                'display_name' => 'Lihat Laporan Member',
                'description' => 'Melihat Laporan Daftar Member'
            ],
            'cetak_laporan_member' => [
                'name' => 'cetak_laporan_member',
                'display_name' => 'Cetak Laporan Member',
                'description' => 'Mencetak Laporan Daftar Member'
            ],
            'lihat_laporan_barang' => [
                'name' => 'lihat_laporan_barang',
                'display_name' => 'Lihat Laporan Barang',
                'description' => 'Melihat Laporan Daftar Member'
            ],
            'cetak_laporan_barang' => [
                'name' => 'cetak_laporan_barang',
                'display_name' => 'Cetak Laporan Barang',
                'description' => 'Mencetak Laporan Daftar Barang'
            ],
            'lihat_laporan_stokopname' => [
                'name' => 'lihat_laporan_stokopname',
                'display_name' => 'Lihat Laporan Stok Opname',
                'description' => 'Melihat Laporan Stok Opname'
            ],
            'cetak_laporan_stokopname' => [
                'name' => 'cetak_laporan_stokopname',
                'display_name' => 'Cetak Laporan Stok Opname',
                'description' => 'Mencetak Laporan Stok Opname'
            ],
            'lihat_laporan_historystok' => [
                'name' => 'lihat_laporan_historystok',
                'display_name' => 'Lihat Laporan History Stok',
                'description' => 'Melihat Laporan History Stok Barang'
            ],
            'cetak_laporan_historystok' => [
                'name' => 'cetak_laporan_historystok',
                'display_name' => 'Cetak Laporan History Stok',
                'description' => 'Mencetak Laporan History Stok Barang'
            ],

            'lihat_laporan_hilang' => [
                'name' => 'lihat_laporan_hilang',
                'display_name' => 'Lihat Laporan Stok Hilang',
                'description' => 'Melihat Laporan Daftar Stok Hilang'
            ],
            'cetak_laporan_hilang' => [
                'name' => 'cetak_laporan_hilang',
                'display_name' => 'Cetak Laporan Stok Hilang',
                'description' => 'Mencetak Laporan Daftar Stok Hilang'
            ],

            'lihat_laporan_pembelian' => [
                'name' => 'lihat_laporan_pembelian',
                'display_name' => 'Lihat Laporan Transaksi Pembelian',
                'description' => 'Melihat Laporan Transaksi Pembelian'
            ],
            'cetak_laporan_pembelian' => [
                'name' => 'cetak_laporan_pembelian',
                'display_name' => 'Cetak Laporan Transaksi Pembelian',
                'description' => 'Mencetak Laporan Transaksi Pembelian'
            ],
            'cetak_laporan_pembelian_detail' => [
                'name' => 'cetak_laporan_pembelian_detail',
                'display_name' => 'Cetak Laporan Transaksi Pembelian Detail',
                'description' => 'Mencetak Laporan Transaksi Pembelian Detail'
            ],

            'lihat_laporan_penjualan' => [
                'name' => 'lihat_laporan_penjualan',
                'display_name' => 'Lihat Laporan Transaksi Penjualan',
                'description' => 'Melihat Laporan Transaksi Penjualan'
            ],
            'cetak_laporan_penjualan' => [
                'name' => 'cetak_laporan_penjualan',
                'display_name' => 'Cetak Laporan Transaksi Penjualan',
                'description' => 'Mencetak Laporan Transaksi Penjualan'
            ],
            'cetak_laporan_penjualan_detail' => [
                'name' => 'cetak_laporan_penjualan_detail',
                'display_name' => 'Cetak Laporan Transaksi Penjualan Detail ',
                'description' => 'Mencetak Laporan Transaksi Penjualan Detail'
            ],

            'lihat_keuntungan' => [
                'name' => 'lihat_keuntungan',
                'display_name' => 'Lihat Laporan Keuntungan',
                'description' => 'Melihat Laporan Keuntungan'
            ],
            'cetak_keuntungan' => [
                'name' => 'cetak_keuntungan',
                'display_name' => 'Cetak Laporan Keuntungan',
                'description' => 'Mencetak Laporan Keuntungan'
            ],

            // Laporan - end
            
        ];

        $kasirpermsarr = [
            'lihat_member', 'tambah_member', 'ubah_member',
            'lihat_barang', 'lihat_penjualan', 'tambah_penjualan'
        ];

        $notownerarr = [

        ];

        $notadminarr = [
            'lihat_owner','tambah_penjualan'
        ];

        foreach($permissions as $perm) {
            $access = null;
            $access = Permission::where('name', $perm['name'])->first();
            if ($access == null) {
                $access = new Permission;
                $access->name = $perm['name'];
                $access->display_name = $perm['display_name'];
                $access->description = $perm['description'];
                $access->save();

                if (!(in_array($perm['name'], $notownerarr))) {
                    $ownerRole->attachPermission($access);
                }

                if (!(in_array($perm['name'], $notadminarr))) {
                    $adminRole->attachPermission($access);
                }

                if (in_array($perm['name'], $kasirpermsarr)) {
                    $kasirRole->attachPermission($access);
                }
            }
        }    
    }
}
