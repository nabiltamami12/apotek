<div class="modal fade" id="modalUbah" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Ubah Data User</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                <input type="hidden" id="idubah">
                <form role="form">
                    <fieldset>
                        <div class="col-md-12">
                            @include('pengaturan.user.form-ubah')
                        </div>
                    </fieldset>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                {!! link_to('#', $title='Simpan Data', $attributes=['id'=>'simpanubah', 'class'=>'btn btn-primary']) !!}
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

@include('layouts.modalhapus')
