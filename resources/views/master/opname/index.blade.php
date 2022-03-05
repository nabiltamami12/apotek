@extends('layouts.master')

@section('title_name')
    Stok Opname Barang
@endsection

@section('active_page')
    <li>Master Data</li>
    <li class="active">Stok Opname</li>
@endsection

@section('content')

  @include('master.opname.modal')

    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-default">
                    <div class="box-header with-border">
                        <h3 class="box-title">Daftar Stok Opname Barang</h3>
                    </div>

                   <div class="box-body">
                    <div class="row">
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for="kode" class="control-label col-sm-4">No. Bukti : </label>
                          <div class="col-sm-8">
                            <input type="text" name="kode" id="kode" value="" class="form-control" disabled />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for="tgl" class="control-label col-sm-4">Tanggal : </label>
                          <div class="col-sm-8">
                            <input type="text" name="tgl" id="tgl" value="" class="form-control inputantgl" placeholder="MM/DD/YYYY" />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-12 form-horizontal form-left">
                        <input type="hidden" name="barangasli" value="" id="barangasli" class="form-control" />
                        <div class="form-group">
                          <label for="barang" class="control-label col-sm-2">Kode Barang : </label>
                          <div class="col-sm-4 controls">
                            <div class="input-group">
                              <input type="text" name="barang" id="barang" value="" class="form-control" placeholder="Ketikkan kode barang / scan barcode" />
                              <span class="input-group-btn">
                                <a class="btn btn-default" type="button" data-toggle="modal" data-target="#modalCari" id="caribarang">
                                  <i class="fa fa-search"></i>
                                </a>
                              </span>
                            </div>
                          </div>
                          <div class="col-sm-6">
                            <input type="text" name="nama" id="nama" value="" class="form-control" placeholder="Nama Barang" disabled />
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for"stok_komputer" class="control-label col-sm-4">Stok Komputer : </label>
                          <div class="col-sm-8">
                            <input type="text" name="stok_komputer" id="stok_komputer" class="form-control inputanangka" value="" disabled />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for"stok_nyata" class="control-label col-sm-4">Stok Nyata : </label>
                          <div class="col-sm-8">
                            <input type="text" name="stok_nyata" id="stok_nyata" class="form-control inputanangka" value="" placeholder="Stok nyata setelah di cek" />
                          </div>
                        </div>          
                      </div> 
                    </div>


                    <div class="row">
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for"selisih" class="control-label col-sm-4">Selisih : </label>
                          <div class="col-sm-8">
                            <input type="text" name="selisih" id="selisih" class="form-control inputanangka" value="" disabled />
                          </div>
                        </div>
                      </div>
                      <div class="col-sm-6 form-horizontal form-left">
                        <div class="form-group">
                          <label for"keterangan" class="control-label col-sm-4">Keterangan : </label>
                          <div class="col-sm-8">
                            <input type="text" name="keterangan" id="keterangan" class="form-control" value="" placeholder="Keterangan stok opname" />
                          </div>
                        </div>          
                      </div> 
                    </div>
                    <!-- /.box-body -->

                </div>
                <!-- /.box -->

                      <div class="box-footer">
                            <a title="Simpan Data Stok Opname" class="btn btn-primary btn-flat" href="#" id="simpan"><i class="fa fa-plus"></i>  Simpan</a>
                        </div>
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
<link href="/plugins/bootstrap-datepicker-master/bootstrap-datepicker3.css" rel="stylesheet">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/plugins/bootstrap-datepicker-master/bootstrap-datepicker.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/master/opname.js"></script>
@endsection


