<div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data Grup User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <input type="hidden" id="idubah">
                @include('pengaturan.grup.form-ubah')
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-primary btn-flat" id="simpanubah"><i class="fa fa-save"></i> Simpan Data</a>
                <button type="button" class="btn btn-default btn-flat" data-dismiss="modal"><i class="fa fa-close"></i> Batal</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('layouts.modalhapus')
