<div class="modal modal-danger fade" id="modalHapus" tabindex="-1" role="dialog"
     aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">HAPUS DATA</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="idHapus">
                <p style="font-weight: bold;">Anda yakin akan menghapus Data ini??<br/>Jika menghapus, kemungkinan data lainnya akan berubah. <br/>Jika
                    anda tidak memahaminya, sebaiknya hubungi Administrator Sistem Anda!</p>
                {{--<p>One fine body&hellip;</p>--}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline btn-flat pull-left" data-dismiss="modal">Batal</button>
                {{--<button type="button" class="btn btn-outline">Save changes</button>--}}
                {!! link_to('#', $title='Saya Yakin Menghapus Data', $attributes=['id'=>'yakinhapus', 'class'=>'btn btn-outline btn-flat']) !!}
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
