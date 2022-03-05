@extends('layouts.master')

@section('title_name')
    Laporan Rugi Laba
@endsection

@section('active_page')
    <li>Laporan</li>
    <li>Suplier</li>
    <li class="active">Konsinyasi</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Rekapitulasi Laporan Konsinyasi Suplier {{$suplier->nama}}</h3>
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
										{!! Form::hidden('id_suplier', $suplier->id, ['class'=>'form-control',  'id'=>'id_suplier']) !!}
                                    </div>
                                </div>
                            </div>
                                @if(Auth::user()->can('cetak_suplier'))
                                    <div class="col-sm-3 form-horizontal">
                                        <div class="form-group">
                                            {!! Form::open(['url' => '/laporan/cetakrekapkonsinyasi/cetak', 'method'=>'POST', 'id'=>'formcetakkonsinyasi']) !!}
											{!! Form::hidden('id_suplier', $suplier->id, ['class'=>'form-control',  'id'=>'id_suplier']) !!}
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                                Cetak Laporan Konsinyasi For Manajemen
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>
									
									<div class="col-sm-3 form-horizontal">
                                        <div class="form-group">
                                            {!! Form::open(['url' => '/laporan/cetakrekapkonsinyasi_suplier/cetak', 'method'=>'POST', 'id'=>'formcetakkonsinyasiforsuplier']) !!}
											{!! Form::hidden('id_suplier', $suplier->id, ['class'=>'form-control',  'id'=>'id_suplier']) !!}
                                            <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                                Cetak Laporan Konsinyasi For Suplier
                                            </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </div>

                                @endif
                            </div>  
                        </div>

                        <hr />
                        
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
    <script src="/js/laporan/rekapkonsinyasi.js"></script>
@endsection


