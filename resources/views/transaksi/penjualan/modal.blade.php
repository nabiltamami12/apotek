<div class="modal fade" id="modalCari" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Cari Data Barang</h4>
            </div>
            <div class="modal-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTableBuilderCari">
                            <thead>
                            <tr>
                                <th class="col-md-2">Kode</th>
                                <th class="col-md-3">Nama</th>
                                <th class="col-md-2">Jenis</th>
                                <th class="col-md-2">Harga</th>
                                <th class="col-md-1">Stok</th>
                                <th class="col-md-2">Pilih</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->



<div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data Detail Penjualan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idubah">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            <div class="row">
                            <div class="col-sm-12 form-horizontal">
                                
                                <div class="form-group">
                                    <div class="col-sm-6">
                                        {!! Form::text('barangubah', null, ['class' => 'form-control', 'id'=>'barangubah', 'disabled', 'placeholder' => 'Kode Barang']) !!}
                                    </div>

                                    <div class="col-sm-6">
                                        {!! Form::text('namaubah', null, ['class' => 'form-control', 'id'=>'namaubah', 'disabled', 'placeholder' => 'Nama Barang']) !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    {!! Form::label('harga_jualubah', 'Harga', ['class' => 'control-label col-sm-4']) !!}

                                    <div class="col-sm-4">
                                        {!! Form::text('harga_jualubah', null, ['id'=>'harga_jualubah', 'class' => 'form-control inputanangka', 'placeholder'=>'Harga Jual']) !!}
                                    </div>

                                    {!! Form::label('stokubah', 'Stok', ['class' => 'control-label col-sm-1']) !!}

                                    <div class="col-sm-3">
                                        {!! Form::text('stokubah', null, ['id'=>'stokubah', 'class' => 'form-control inputanangka', 'disabled']) !!}
                                    </div>
                                        
                                </div>
                            </div> 

                            <div class="col-sm-6 form-horizontal">
                                <div class="form-group">
                                    <div class="col-sm-3">
                                        {!! Form::text('qtyubah', null, ['class' => 'form-control inputanangka', 'id'=>'qtyubah', 'placeholder' => 'QTY']) !!}
                                    </div>

                                    <div class="col-sm-9">
                                        {!! Form::text('totalubah', null, ['id'=>'totalubah', 'class' => 'form-control', 'disabled', 'placeholder' => 'Sub Total']) !!}
                                    </div>

                                    
                                </div>
                        
                                
                            </div>   
                        </div>
                        </div>
                    </fieldset>
                </form>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-flat" id="simpanubah"><i class="fa fa-save"></i> Simpan Perubahan</a>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- Modal Struk -->
 <div class="modal fade" id="modalStruk" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Print Struk Penjualan</h4>
            </div>
            <div class="modal-body">
                <p style="font-weight: bold;">Print Struk Penjualan ?</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-flat" id="printstruk"><i class="fa fa-save"></i> Print Struk</a>
                <a href="#" class="btn btn-default btn-flat" id="batalstruk"><i class="fa fa-close"></i> Tidak</a>
                <!-- <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Tidak</button> -->
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('layouts.modalhapus')



<div class="modal fade" id="modalTambahMember" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Member Baru</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            @include('master.member.form')
                        </div>
                    </fieldset>
                </form>

            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-flat" id="simpantambah"><i class="fa fa-save"></i> Simpan</a>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- Modal Tambah - END -->