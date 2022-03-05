@extends('layouts.master')

@section('title_name')
    Daftar Transaksi Penjualan
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li class="active">Penjualan</li>
@endsection

@section('content')
  @include('layouts.modalhapus')
    <section class="content">
      <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar Penjualan Barang</h3>
                    </div>

                    @include('layouts.modalhapus')

                    @if(Auth::user()->can('tambah_penjualan'))
                        <div class="col-md-12 daftar-tombol">
                            <a title="Tambah Penjualan Baru" class="btn btn-primary btn-flat" href="/penjualan/create"><i class="fa fa-plus"></i>  </a>
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
                                <th class="col-md-2">Member</th>
                                <th class="col-md-1">Kasir/User</th>
                                <th class="col-md-3">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

                    </div>
                    <!-- /.box-body -->
                    @if(Auth::user()->can('tambah_penjualan'))
                        <div class="box-footer">
                            <a title="Tambah Penjualan Baru" class="btn btn-primary btn-flat" href="/penjualan/create"><i class="fa fa-plus"></i>  </a>
                        </div>
                    @endif

                </div>
                <!-- /.box -->
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
    <script src="/js/transaksi/penjualan/index.js"></script>
    <script type="text/javascript">
    // TOKO
        function CetakClick(id) {
            var route = "/cetak2";
            var token = '<?= csrf_token()?>';
            $.ajax({
              url: route,
              type: 'POST',
              headers: {'X-CSRF-TOKEN': token},
              data: 'kode='+id.value,
              success:function(data) 
              {
                $('<script src="https://cdn.jsdelivr.net/npm/recta/dist/recta.js"></' + 'script> <script>var printer = new Recta("2690302662", "1811"); printer.open().then(function () { '+data+' })</' + 'script>').appendTo(document.body); 
              } 
            });
        }
    </script>
@endsection


