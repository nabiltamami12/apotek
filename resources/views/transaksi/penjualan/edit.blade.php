@extends('layouts.master')

@section('title_name')
    Koreksi Transaksi Penjualan
@endsection

@section('active_page')
    <li>Transaksi</li>
    <li>Penjualan</li>
    <li class="active">Koreksi</li>
@endsection

@section('content')
@include('transaksi.penjualan.modal')

<input type="hidden" nama="tempTotal" value="" id="tempTotal" />
<input type="hidden" id="idubahsekali" value="{{$penjualan->id}}">

<input type="hidden" nama="tempMember" value="{{($penjualan->member!= null ? $penjualan->member_id : ' ')}}" id="tempMember" />

    <section class="content">
      <div class="row">
          <div class="col-xs-3">
          <div class="box box-primary">
            <div class="box-header with-border">
              <i class="fa fa-info"></i>
              <h3 class="box-title">Info Struk</h3>
            </div>
            <div class="box-body">
              <div class="row">
                <div class="col-sm-12 form-horizontal form-left">
                            <div class="form-group">
                                <label for="infokode" class="control-label col-sm-4">No. Bukti: </label>
                                <div class="col-sm-8">
                                    <input type="text" name="infokode" id="infokode" value="{{$penjualan->kode}}" class="form-control" disabled />
                                </div>
                            </div>
                        </div>
                <hr />

                @if(Auth::user()->can('tambah_member'))
                <div class="col-md-6">
                @else
                <div class="col-md-12">
                @endif
                  <p style="font-weight: bold;">Data Member</p>
                </div>
                @if(Auth::user()->can('tambah_member'))
                <div class="col-md-6">
                <p class="text-right"><a href="#" id="tambahmemberbaru" data-toggle="modal" data-target="#modalTambahMember">Tambah Baru ?</a></p>
                </div>
                @endif
                  

                <div class="col-md-12">
                  <div class="form-group">
                    <select name="infomember" class="form-control select2" id="infomember" style="width: 100%;">
                      <option value=" "></option>
                  </select>
                  </div>
                </div>

                <div class="col-sm-12 form-horizontal">
                    <div class="form-group">
                        <label for="infolevel" class="control-label col-sm-4">Level : </label>
                        <div class="col-sm-8">
                            <input type="text" id="infolevel" name="infolevel" style="font-weight: italic;" value="Tidak ada" class="form-control" disabled />
                        </div>
                    </div>
                  </div>
                <div class="col-sm-12 form-horizontal">
                  <div class="form-group">
                      <label for="infonama" class="control-label col-sm-4">Nama : </label>
                      <div class="col-sm-8">
                          <input type="text" id="infonama" name="infonama" style="font-weight: italic;" value="Tidak ada" class="form-control" disabled />
                      </div>
                  </div>
                </div>
                <div class="col-sm-12 form-horizontal">
                  <div class="form-group">
                      <label for="infohp" class="control-label col-sm-4">HP : </label>
                      <div class="col-sm-8">
                          <input type="text" id="infohp" name="infohp" style="font-weight: italic;" value="Tidak ada" class="form-control" disabled />
                      </div>
                  </div>
                </div>
                <div class="col-sm-12 form-horizontal">
                  <div class="form-group">
                      <label for="infoalamat" class="control-label col-sm-4">Alamat : </label>
                      <div class="col-sm-8">
                          <input type="text" id="infoalamat" name="infoalamat" style="font-weight: italic;" value="Tidak ada" class="form-control" disabled />
                      </div>
                  </div>
                </div>

              </div>
              
            </div> 
            <div class="box-footer">
              <a href="/penjualan" class="btn btn-warning btn-flat" id="batal"><i class="fa fa-close"></i> Batal</a>
            </div>  
          </div>
        </div>
            <div class="col-xs-9">
                <div class="box box-primary">
                    <div class="box-header with-border">
                      <i class="fa fa-cart-plus"></i>
                      <h3 class="box-title">Detail Penjualan Barang</h3>

                      <!--<p class="pull-right"><a href="#">Refresh Detail</a></p>-->
                    </div>

                   <div class="box-body pad table-responsive">
                    <div class="row">
                      <div class="col-sm-12 form-horizontal">
                                {!!  Form::hidden('barangasli', null, ['id'=>'barangasli', 'class' => 'form-control', 'id'=>'barangasli'])  !!}
                                <div class="form-group">
                                    {!! Form::label('barang', 'Kode Barang', ['class' => 'control-label col-sm-2']) !!}
                                    <div class="col-sm-4 controls">
                                        <div class="input-group">
                                            {!! Form::text('barang', null, ['id'=>'barang','class' => 'form-control', 'placeholder' => 'Masukan Kode Barang']) !!}
                                            <span class="input-group-btn">
                                                <a class="btn btn-default" type="button" data-toggle="modal" data-target="#modalCari" id="caribarang">
                                                    <i class="fa fa-search"></i>
                                                </a>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="col-sm-6">
                                        {!! Form::text('namabarang', null, ['class' => 'form-control', 'id'=>'namabarang', 'disabled', 'placeholder' => 'Nama Barang']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    {!! Form::label('harga_jual', 'Harga', ['class' => 'control-label col-sm-4']) !!}

                                    <div class="col-sm-4">
                                        {!! Form::text('harga_jual', null, ['id'=>'harga_jual', 'class' => 'form-control inputanangka', 'placeholder'=>'Harga Jual']) !!}
                                    </div>

                                    {!! Form::label('stok', 'Stok', ['class' => 'control-label col-sm-1']) !!}

                                    <div class="col-sm-3">
                                        {!! Form::text('stok', null, ['id'=>'stok', 'class' => 'form-control inputanangka', 'disabled']) !!}
                                    </div>
                                        
                                </div>
                            </div> 

                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        {!! Form::text('qty', null, ['class' => 'form-control inputanangka', 'id'=>'qty', 'placeholder' => 'QTY']) !!}
                                    </div>

                                    <div class="col-sm-5">
                                        {!! Form::text('total', null, ['id'=>'total', 'class' => 'form-control', 'disabled', 'placeholder' => 'Sub Total']) !!}
                                    </div>

                                    <div class="col-sm-4">
                                        <a href="#" class="btn btn-primary btn-flat pull-right" id="tambahbaris"><i class="fa fa-plus"></i> Tambah</a>
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


                          <div class="row">
                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        {!! Form::textarea('catatan',$penjualan->catatan,['id'=>'catatan', 'class'=>'form-control', 'rows'=>3, 'placeholder'=>'Catatan tambahan (jika ada)']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-12">
                                        <label for="bayar" class="control-label col-sm-4">Bayar (F7): </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="bayar" id="bayar" value="{{ number_format($penjualan->bayar, 0, '.', ',') }}" class="form-control inputanangka inputbayarkembali" placeholder="Bayar" />
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">

                                    <div class="col-sm-12">
                                        <label for="kembali" class="control-label col-sm-4">Uang Kembali: </label>
                                        <div class="col-sm-8">
                                            <input type="text" name="kembali" id="kembali" value="{{ number_format($penjualan->bayar - $penjualan->total(), 0, '.', ',') }}" class="form-control inputbayarkembali" placeholder="Uang Kembalian" disabled />
                                        </div>
                                    </div>
                                </div>
                            </div>
                          </div>

                  </div>
                <!-- /.box -->


                
                      <div class="box-footer">
                        <div class="row">
                          <div class="col-md-6">
                            <p><i class="fa fa-keyboard-o"></i> <b>Shortcut Keyboard : </b></p>
                            <p>F7 : Fokus ke inputan Bayar</p>
                            <p>F9 : Selesai dan Simpan Transaksi</p>
                          </div>
                          <div class="col-md-6">
                            <a href="#" class="btn btn-primary btn-flat pull-right" id="simpan"><i class="fa fa-save"></i> Selesai ( F9 )</a>
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
    <link rel="stylesheet" href="/theme/plugins/select2/select2.min.css">
@endsection

@section('custom_script')
    <script src="/plugins/datatables/js/jquery.dataTables.min.js"></script>
    <script src="/plugins/datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="/plugins/datatables-responsive/dataTables.responsive.js"></script>
    <script src="/theme/plugins/select2/select2.full.min.js"></script>
@endsection

@section('custom_script_footer')
    <script src="/js/transaksi/penjualan/edit.js"></script>
@endsection


