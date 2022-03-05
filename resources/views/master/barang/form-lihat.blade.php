<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="kodelihat" class="control-label col-sm-4">Kode Barang : </label>
            <div class="col-sm-8">
                    <input type="text" nama="kodelihat" id="kodelihat" value="" class="form-control" placeholder="Kode Barang" disabled />
            </div>
        </div>
    </div>

    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="barcodelihat" class="control-label col-sm-4">Barcode : </label>
            <div class="col-sm-8">
                <input type="text" nama="barcodelihat" id="barcodelihat" value="" class="form-control" placeholder="Kode Barcode" disabled />
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="namalihat" class="control-label col-sm-4">Nama Barang : </label>
            <div class="col-sm-8">
                <input type="text" nama="namalihat" id="namalihat" value="" class="form-control" placeholder="Nama Barang" disabled />
            </div>
        </div>
    </div>
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="jenislihat" class="control-label col-sm-4">Jenis Barang : </label>
            <div class="col-sm-8">
                <input type="text" nama="jenislihat" id="jenislihat" value="" class="form-control" placeholder="Jenis Barang" disabled />
            </div>
        </div>
    </div>
</div>

<div class="row">
    @if(Auth::user()->role()->name != 'kasir')
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="harga_belilihat" class="control-label col-sm-4">Harga Beli : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_belilihat" id="harga_belilihat" value="" class="form-control inputanangka" placeholder="Harga Beli Barang" disabled />
            </div>
        </div>
    </div>
    <div class="col-sm-6 form-horizontal">
    @else
    <div class="col-sm-12 form-horizontal">
    @endif
        <div class="form-group">
            <label for="harga_jual_1lihat" class="control-label col-sm-4">Harga 1 : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_jual_1lihat" id="harga_jual_1lihat" value="" class="form-control inputanangka" placeholder="Harga Jual 1" disabled />
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="harga_jual_2lihat" class="control-label col-sm-4">Harga 2 : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_jual_2lihat" id="harga_jual_2lihat" value="" class="form-control inputanangka" placeholder="Harga Jual 2" disabled />
            </div>
        </div>
    </div>
</div>