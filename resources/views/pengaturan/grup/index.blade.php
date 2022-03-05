@extends('layouts.master')

@section('title_name')
    Grup User
@endsection

@section('active_page')
    <li>Pengaturan</li>
    <li class="active">Grup</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @if(Auth::user()->can('tambah_grup'))
                <div class="col-xs-6">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-plus"></i>
                            <h3 class="box-title">Baru</h3>
                        </div>
                        <div class="box-body">
                            @include('pengaturan.grup.form')
                        </div> 

                        <div class="box-footer">
                            <a href="#" class="btn btn-primary btn-flat" id="simpantambah"><i class="fa fa-save"></i> Simpan Data</a>
                        </div>  
                    </div>
                </div>
                <div class="col-xs-6">
            @else
                <div class="col-xs-12">
            @endif
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Daftar Grup User</h3>
                    </div>

                    @include('pengaturan.grup.modal')

                    <div class="box-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <td>Nama</td>
                                <td>Nama Yang Dilihat</td>
                                <td>Deskripsi</td>
                                <td>Aksi</td>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
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

    <link href="/plugins/bootstrap-dualbox/bootstrap-duallistbox.css" rel="stylesheet">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/plugins/bootstrap-dualbox/jquery.bootstrap-duallistbox.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/pengaturan/grup.js"></script>
@endsection


