@extends('layouts.master')

@section('title_name')
    Daftar Transaksi Pembelian
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li class="active">Pembelian</li>
@endsection

@section('content')
  @include('layouts.modalhapus')
    <section class="content">
      <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-cart-plus"></i>
                      <h3 class="box-title">Daftar Transaksi Pembelian Barang</h3>
                    </div>

                    @if(Auth::user()->can('tambah_pembelian'))
                        <div class="col-md-12 daftar-tombol">
                            <a title="Tambah Pembelian Baru" class="btn btn-primary btn-flat" href="/pembelian/create"><i class="fa fa-plus"></i>  </a>
                        </div>
                    @endif

                    <div class="box-body">
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
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-2">No. Bukti</th>
                                <th class="col-md-2">Tgl.</th>
                                <th class="col-md-2">Total</th>
                                <th class="col-md-3">User</th>
                                <th class="col-md-3">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-body -->
                    @if(Auth::user()->can('tambah_pembelian'))
                        <div class="box-footer">
                            <a title="Tambah Pembelian Baru" class="btn btn-primary btn-flat" href="/pembelian/create"><i class="fa fa-plus"></i>  </a>
                        </div>
                    @endif 
            </div>
            <!-- /.col -->
        </div>
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
    <script src="/js/transaksi/pembelian/index.js"></script>
@endsection


