@extends('layouts.master')

@section('title_name')
    Laporan Transaksi Penjualan barang
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">Penjualan</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
             <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Cetak Transaksi Penjualan Barang</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-4 form-horizontal form-left">
                                <div class="form-group">
                                    {!! Form::label('start', 'Periode', ['class' => 'control-label col-sm-2']) !!}
                                    <div class="col-sm-10 controls">
                                        <div class="input-daterange input-group">
                                            {!! Form::text('start', null, ['class'=>'form-control', 'id' => 'start', 'placeholder'=> 'DD/MM/YYYY']) !!}
                                            <span class="input-group-addon">s/d</span>
                                            {!! Form::text('end', null, ['class'=>'form-control', 'id'=>'end', 'placeholder'=> 'DD/MM/YYYY']) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 form-horizontal">
                                <div class="form-group">
                                    {!! Form::label('member', 'Member', ['class' => 'control-label col-sm-2']) !!}
                                    <div class="col-sm-10">
                                        {!!  Form::select('member', [], null, ['class' => 'form-control select2', 'style'=>"width:100%;"])  !!}
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 form-horizontal">
                                 @if(Auth::user()->can('cetak_laporan_penjualan'))
                                {!! Form::open(['url' => '/laporan/penjualan', 'method'=>'POST', 'id'=>'formcetak', 'class'=>'pull-left', 'style'=>"margin-right:5px;"]) !!}
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                                Preview Laporan
                                            </button>
                                            {!! Form::close() !!}
                            @endif

                            @if(Auth::user()->can('cetak_laporan_penjualan_detail'))
                                {!! Form::open(['url' => '/laporan/penjualan', 'method'=>'POST', 'id'=>'formcetakdetail', 'class'=>'pull-left', 'style'=>"margin-right:5px;"]) !!}
                                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-print"></i>
                                                Preview Laporan Detail
                                            </button>
                                            {!! Form::close() !!}
                            @endif
                            </div>
                            
                        </div>


                        
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-2">Tgl.</th>
                                <th class="col-md-2">No. Bukti</th>
                                <th class="col-md-2">Member</th>
                                <th class="col-md-1">Total</th>
                                <th class="col-md-1">Laba</th>
                                <th class="col-md-1">-</th>
                                <th class="col-md-1">Kasir/User</th>
                                <th class="col-md-2">Catatan</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                            <tfoot>
                                <th colspan="3">Grand Total</th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                                <th class="col-md-1"></th>
                                <th colspan="2"></th>
                            </tfoot>
                        </table>

                    </div>
                </div>
                <!-- /.box -->
            </div>
        </div>
        <!-- /.row -->
    </section>
@endsection

@section('custom_style')
        <!-- DataTables -->
   <link href="/plugins/datatables-plugins/dataTables.bootstrap.css" rel="stylesheet">

    <!-- DataTables Responsive CSS -->
    <link href="/plugins/datatables-responsive/dataTables.responsive.css" rel="stylesheet">
    <link href="/plugins/bootstrap-datepicker-master/bootstrap-datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="/theme/plugins/select2/select2.min.css">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js"></script>
    <script src="/theme/plugins/select2/select2.full.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/laporan/penjualan.js"></script>
@endsection


