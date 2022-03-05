@extends('layouts.master')

@section('title_name')
    Laporan Daftar Barang
@endsection

@section('active_page')
    <li>Laporan</li>
    <li class="active">Barang</li>
@endsection

@section('content')
    <section class="content">
        <div class="row">
            
                <div class="col-xs-3">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <i class="fa fa-filter"></i>
                            <h3 class="box-title">Pilihan</h3>
                        </div>
                        <div class="box-body">
                            <div class="form-group">
                                    <label for="jenis">Jenis Barang : </label>
                                    
                                      {!!  Form::select('jenis', [], null, ['id'=>'jenis','class' => 'form-control select2', 'style'=>"width:100%;"])  !!} 
                                    
                                </div>
                        </div> 

                        @if(Auth::user()->can('cetak_laporan_barang'))

                        <div class="box-footer">
                            {!! Form::open(['url' => '/laporan/barang', 'method'=>'POST', 'id'=>'formcetak']) !!}
                                    <button type="submit" class="btn btn-primary btn-flat"><i class="fa fa-print"></i>
                                        Preview Laporan
                                    </button>
                                    {!! Form::close() !!}
                        </div>  

                        @endif
                    </div>
                </div>
                <div class="col-xs-9">
            
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Cetak Laporan Daftar Barang</h3>
                    </div>
                    

                    <div class="box-body pad table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-2">Barcode</th>
                                <th class="col-md-4">Nama</th>
                                <th class="col-md-3">Jenis</th>
                                <th class="col-md-1">Stok</th>
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
    <script src="/js/laporan/barang.js"></script>
@endsection


