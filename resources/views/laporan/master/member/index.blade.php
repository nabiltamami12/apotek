@extends('layouts.master')

@section('title_name')
    Laporan Daftar Member
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">Member</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Cetak Laporan Daftar Member</h3>
                    </div>

                    <div class="box-body">
                        <div class="col-sm-12">
                            @if(Auth::user()->can('cetak_laporan_member'))
                            <div class="col-sm-4 form-horizontal">
                                <div class="form-group">
                                    {!! Form::open(['url' => '/laporan/member', 'method'=>'POST', 'id'=>'formcetak']) !!}
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                        Preview Laporan
                                    </button>
                                    {!! Form::close() !!}
                                </div>
                            </div>
                            @endif
                        </div>
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-3">Nama</th>
                                <th class="col-md-1">Level</th>
                                <th class="col-md-2">No. HP</th>
                                <th class="col-md-4">Alamat</th>
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
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/laporan/member.js"></script>
@endsection


