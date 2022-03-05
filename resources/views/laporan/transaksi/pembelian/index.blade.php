@extends('layouts.master')

@section('title_name')
    Laporan Transaksi Pembelian barang
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">Pembelian</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
             <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Cetak Transaksi Pembelian Barang</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-6 form-horizontal form-left">
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
                            <div class="col-sm-6">
                                @if(Auth::user()->can('cetak_laporan_pembelian'))
                                    <div class="col-sm-6 form-horizontal">
                                        <div class="form-group">
                                            {!! Form::open(['url' => '/laporan/pembelian', 'method'=>'POST', 'id'=>'formcetak']) !!}
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                                Preview Laporan
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                @endif
                                @if(Auth::user()->can('cetak_laporan_pembelian_detail'))
                                    <div class="col-sm-6 form-horizontal">
                                        <div class="form-group">
                                            {!! Form::open(['url' => '/laporan/pembelian', 'method'=>'POST', 'id'=>'formcetakdetail']) !!}
                                            <button type="submit" class="btn btn-success btn-flat"><i class="fa fa-print"></i>
                                                Preview Laporan Detail
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                @endif
                            </div> 
                            
                        </div>


                        
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-3">No. Bukti</th>
                                <th class="col-md-2">Tgl.</th>
                                <th class="col-md-3">Total</th>
                                <th class="col-md-4">Operator</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
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
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/laporan/pembelian.js"></script>
@endsection


