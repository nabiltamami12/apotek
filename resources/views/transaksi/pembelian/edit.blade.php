@extends('layouts.master')

@section('title_name')
    Koreksi Pembelian
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li>Pembelian</li>
    <li class="active">Koreksi Transaksi</li>
@endsection

@section('content')
@include('transaksi.pembelian.modal')
<input type="hidden" id="idubahsekali" value="{{$pembelian->id}}">
    <section class="content">
      <div class="row">
            <div class="col-xs-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-plus"></i>
              <h3 class="box-title">Barang</h3>
            </div>
            <div class="box-body">

              @include('transaksi.pembelian.form-tambah')
            </div> 
            <div class="box-footer">
              <a href="#" class="btn btn-primary btn-flat" id="tambahbaris"><i class="fa fa-save"></i> Tambah Baris</a>
              <a href="/pembelian" class="btn btn-warning btn-flat" id="batal"><i class="fa fa-close"></i> Batal</a>
            </div>  
          </div>
        </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-cart-plus"></i>
                      <h3 class="box-title">Detail Pembelian Barang</h3>

                      <!--<p class="pull-right"><a href="#">Refresh Detail</a></p>-->
                    </div>

                   <div class="box-body pad table-responsive">
                    <div class="row">
                        <div class="col-sm-6 form-horizontal form-left">
                            <div class="form-group">
                                <label for="kode" class="control-label col-sm-3">No. Bukti: </label>
                                <div class="col-sm-9">
                                    <input type="text" name="kode" id="kode" value="{{$pembelian->kode}}" class="form-control" disabled />
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 form-horizontal">
                            <div class="form-group">
                                <label for="tgl" class="control-label col-sm-4">Tanggal: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="tgl" id="tgl" value="{{$pembelian->tgl->format('m/d/Y')}}" class="form-control inputantgl" placeholder="MM/DD/YYYY" />
                                </div>
                            </div>
                        </div>
                    </div>

                   <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilder">
                                <thead>
                                <tr>
                                    <th class="text-center col-md-2">Kode</th>
                                    <th class="text-center col-md-3">Nama</th>
                                    <th class="text-center col-md-1">QTY</th>
                                    <th class="text-center col-md-2">Harga</th>
                                    <th class="text-center col-md-2">SubTotal</th>
                                    <th class="text-center col-md-2">Aksi</th>
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
                <!-- /.box -->

                
                      <div class="box-footer">
                        <div class="row">
                          <div class="col-md-6">
                            <a href="#" class="btn btn-primary btn-flat" id="simpan"><i class="fa fa-save"></i> Selesai dan Simpan Transaksi</a>
                          </div>
                        </div>
                        </div>
                    
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
    <script src="/js/transaksi/pembelian/edit.js"></script>
@endsection


