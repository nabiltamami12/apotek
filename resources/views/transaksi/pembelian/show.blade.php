@extends('layouts.master')

@section('title_name')
    Detail Transaksi Pembelian
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li>Pembelian</li>
    <li class="active">Lihat Detail</li>
@endsection

@section('content')
<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail Pembelian Barang</h3>
                    </div>
                    <div class="box-body">
                    {!!  Form::hidden('kode', $pembelian->kode, ['id'=>'kode', 'class' => 'form-control'])  !!}
                        <div class="form-group">
                            {!! Form::label('kode', 'No. Bukti : ') !!} {{ $pembelian->kode }}
                        </div>
                        <div class="form-group">
                            {!! Form::label('tgl', 'Tgl. Transaksi : ' ) !!} {{ $pembelian->tgl->format('d-m-Y') }}
                        </div>
                        <div class="form-group">
                            {!! Form::label('user', 'Operator : ') !!} {{ $pembelian->user->fullname }}
                        </div>

                            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                                <thead>
                                <tr>
                                    <th class="col-md-2">Kode</th>
                                    <th class="col-md-2">Nama</th>
                                    <th class="col-md-2">Jenis</th>
                                    <th class="col-md-2">Harga</th>
                                    <th class="col-md-1">QTY</th>
                                    <th class="col-md-2">Sub Total</th>
                                </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th colspan="6" style="text-align:right; font-size:22px; color: #9d1500;">Rp 0</th>
                                    </tr>
                                    </tfoot>
                                <tbody>

                                </tbody>
                            </table>
                        
                        
                    </div>
                    <div class="box-footer">
                            <a href="/pembelian" class="btn btn-primary btn-flat"><i class="fa fa-arrow-left"></i> Kembali</a>
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
    <script src="/js/transaksi/pembelian/show.js"></script>
@endsection


