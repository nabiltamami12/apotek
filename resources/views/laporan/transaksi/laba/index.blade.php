@extends('layouts.master')

@section('title_name')
    Laporan Rugi Laba
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">Rugi Laba</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Rekapitulasi Laporan Rugi Laba</h3>
                    </div>

                    <div class="box-body">
                        <div class="row">
                            <div class="col-sm-12">
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
                                    {!! Form::label('jenis', 'Jenis Barang', ['class' => 'control-label col-sm-4']) !!}
                                    <div class="col-sm-8">
                                        {!!  Form::select('jenis', [], null, ['class' => 'form-control select2', 'style'=>"width:100%;"])  !!}
                                    </div>
                                </div>
                            </div>
                                @if(Auth::user()->can('cetak_keuntungan'))
                                    <div class="col-sm-4 form-horizontal">
                                        <div class="form-group">
                                            {!! Form::open(['url' => '/laporan/laba', 'method'=>'POST', 'id'=>'formcetak']) !!}
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                                Preview Laporan
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                @endif
                            </div>  
                        </div>

                        <hr />
                        
                        <div class="row">
                            <div class="col-xs-6">
                                <p class="lead">Pendapatan</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Penjualan</th>
                                            <td style="text-align: right;" id="totalpenjualan"></td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td class="lead" style="text-align: right;" id="totalpendapatan"><strong></strong></td>
                                        </tr> 
                                    </table>
                                </div>
                            </div>

                            <div class="col-xs-6">
                                <p class="lead">Pengeluaran</p>

                                <div class="table-responsive">
                                    <table class="table">
                                        <tr>
                                            <th style="width:50%">Pembelian Barang</th>
                                            <td style="text-align: right;" id="totalpembelian"></td>
                                        </tr>
                                        <!-- <tr>
                                            <th>Pembayaran Maintenance Alat</th>
                                            <td style="text-align: right;" id="totalmaintenance"></td>
                                        </tr>
                                        <tr>
                                            <th>Pembayaran Listrik</th>
                                            <td style="text-align: right;" id="totallistrik"></td>
                                        </tr>
                                        <tr>
                                            <th>Pembayaran Gaji</th>
                                            <td style="text-align: right;" id="totalgaji"></td>
                                        </tr> -->
                                        <tr>
                                            <th>Total:</th>
                                            <td class="lead" style="text-align: right;" id="totalpengeluaran"><strong></strong></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer">
                        <div class="row">
                            <div class="col-xs-6">
                            <table>
                                <tr>
                                    <th style="width:50%" class="lead">Grand Total :</th>
                                    <td class="lead" style="text-align: right; color:red;" id="grandtotal"><strong></strong></td>
                                </tr>
                            </table>
                            </div>
                        </div>
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
    <link href="/plugins/bootstrap-datepicker-master/bootstrap-datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="/theme/plugins/select2/select2.min.css">
   
@endsection

@section('custom_script')
    <script src="/plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js"></script>
    <script src="/theme/plugins/select2/select2.full.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/laporan/laba.js"></script>
@endsection


