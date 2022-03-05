@extends('layouts.master')

@section('title_name')
    Daftar Member
@endsection

@section('active_page')
    <li>Master Data</li>
    <li class="active">Member</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            @if(Auth::user()->can('tambah_member'))
                <div class="col-xs-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-plus"></i>
                            <h3 class="box-title">Baru</h3>
                        </div>
                        <div class="box-body">
                            @include('master.member.form')
                        </div> 

                        <div class="box-footer">
                            <a href="#" class="btn btn-primary btn-flat" id="simpantambah"><i class="fa fa-save"></i> Simpan Data</a>
                        </div>  
                    </div>
                </div>
                <div class="col-xs-9">
            @else
                <div class="col-xs-12">
            @endif
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Daftar Member</h3>
                    </div>

                    @include('master.member.modal')

                    <div class="box-body">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-2">Nama</th>
                                <th class="col-md-2">GSM</th>
                                <th class="col-md-2">Alamat</th>
                                <th class="col-md-1">Level</th>
                                <th class="col-md-1">Aktif</th>
                                <th class="col-md-2">Aksi</th>
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

    <link rel="stylesheet" href="/theme/plugins/select2/select2.min.css">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>

    <script src="/theme/plugins/select2/select2.full.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/master/member.js"></script>
@endsection


