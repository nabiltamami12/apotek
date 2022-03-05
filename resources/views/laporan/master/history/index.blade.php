@extends('layouts.master')

@section('title_name')
    Laporan Daftar History Barang
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">History</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
                <div class="col-xs-12">
            
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Cetak Laporan Daftar History Barang</h3>
                    </div>
                    

                    <div class="box-body pad table-responsive">
                        <div class="row">
                            <div class="col-sm-12 form-horizontal">
                                <div class="form-group">
                                    {!! Form::label('start', 'Periode', ['class' => 'control-label col-sm-1']) !!}
                                    <div class="col-sm-11 controls">
                                        <div class="input-daterange input-group">
                                            {!! Form::text('start', null, ['class'=>'form-control', 'id' => 'start', 'placeholder'=> 'DD/MM/YYYY']) !!}
                                            <span class="input-group-addon">s/d</span>
                                            {!! Form::text('end', null, ['class'=>'form-control', 'id'=>'end', 'placeholder'=> 'DD/MM/YYYY']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>  
                        </div>

                        <div class="row">
                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    {!! Form::label('barang', 'Berdasarkan Barang : ', ['class' => 'control-label col-sm-4']) !!}
                                    <div class="col-sm-8">
                                        {!!  Form::select('barang', [], null, ['class' => 'form-control select2', 'style'=>"width:100%;"])  !!}
                                    </div>
                                </div>
                            </div>
                            @if(Auth::user()->can('cetak_laporan_historystok'))
                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    {!! Form::open(['url' => '/laporan/history', 'method'=>'POST', 'id'=>'formcetak']) !!}
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
                                <th class="col-md-2" rowspan="2">Tanggal</th>
                                <th class="col-md-2" rowspan="2">Data Barang</th>
                                <th class="text-center" colspan="4">Stok</th>
                                <th class="col-md-1" rowspan="2">Operator</th>
                                <th class="col-md-4" rowspan="2">Keterangan</th>
                            </tr>

                            <tr>
                                <th>Awal</th>
                                <th>Masuk</th>
                                <th>Keluar</th>
                                <th>Saldo</th>
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
    <link href="/plugins/bootstrap-datepicker-master/bootstrap-datepicker3.css" rel="stylesheet">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/theme/plugins/select2/select2.full.min.js"></script>
    <script src="/plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/laporan/history.js"></script>
@endsection


