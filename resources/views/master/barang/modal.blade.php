<div class="modal fade" id="modalTambah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Barang Baru</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            @include('master.barang.form')
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


<div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data Barang</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idubah">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            @include('master.barang.form-ubah')
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
<!-- /.modal -->

@include('layouts.modalhapus')

<div class="modal fade" id="modalLihat" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Detail Barang</h4>
            </div>
            <div class="modal-body">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            @include('master.barang.form-lihat')
                        </div>
                    </fieldset>
                </form>

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