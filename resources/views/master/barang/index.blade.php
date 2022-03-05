@extends('layouts.master')

@section('title_name')
    Master Barang
@endsection

@section('active_page')
    <li>Master Data</li>
    <li class="active">Barang</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Daftar Barang</h3>
                    </div>

                    @include('master.barang.modal')

                    <div class="box-body">
                        @if(Auth::user()->can('tambah_barang'))
                        <div class="col-md-12 daftar-tombol">
                            <button title="Tambah Barang Baru" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modalTambah" onclick="TambahClick();"><i class="fa fa-plus"></i> </button>
                        </div>
                        @endif

                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-1">Kode</th>
                                <th class="col-md-2">Barcode</th>
                                <th class="col-md-3">Nama</th>
                                <th class="col-md-2">Jenis</th>
                                <th class="col-md-1">Stok</th>
                                <th class="col-md-3">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>

                    @if(Auth::user()->can('tambah_barang'))
                    <div class="box-footer">
                        
                    
                        <div class="col-md-12 daftar-tombol">
                            <button title="Tambah Barang Baru" class="btn btn-primary btn-flat" data-toggle="modal" data-target="#modalTambah" onclick="TambahClick();"><i class="fa fa-plus"></i> </button>
                        </div>
                        </div>
                        @endif
                    
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('custom_style')
        <!-- DataTables -->
   <link href="/plugins/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/plugins/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link rel="stylesheet" href="/theme/plugins/select2/select2.min.css">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/theme/plugins/select2/select2.full.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/master/barang.js"></script>
@endsection


