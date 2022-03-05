@extends('layouts.master')

@section('title_name')
    Home
@endsection

@section('active_page')
    <li class="active">Dashboard</li>
@endsection

@section('content')

    <!-- Main content -->
<section class="content">

        <!-- Info boxes -->
      <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="ion ion-ios-cart-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Penjualan</span>
              <span class="info-box-number" id="infoc-penjualan"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="ion ion-bag"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Pembelian</span>
              <span class="info-box-number" id="infoc-pembelian"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="ion ion-iphone"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Barang</span>
              <span class="info-box-number" id="infoc-barang"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Member</span>
              <span class="info-box-number" id="infoc-member"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

      <div class="row">
            
            <div class="col-xs-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Barang Paling Menguntungkan</h3>
                    </div>

                    <div class="box-body pad table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableMenguntungkan">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-2">Barcode</th>
                                <th class="col-md-7">Nama</th>
                                <th class="col-md-7">Nama Suplier</th>
                                <th class="col-md-1">Terjual</th>
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

            <div class="col-xs-6">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <i class="fa fa-list"></i>
                        <h3 class="box-title">Stok Habis</h3>
                    </div>

                    <div class="box-body pad table-responsive">
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableHabis">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-2">Barcode</th>
                                <th class="col-md-5">Nama</th>
                                <th class="col-md-3">Jenis</th>
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

    </section>
    <!-- /.content -->
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
    <script src="/js/dashboard.js"></script>
@endsection