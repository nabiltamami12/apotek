<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="kode" class="control-label col-sm-4">Kode Barang : </label>
            <div class="col-sm-8 controls">
                <div class="input-group">
                    <input type="text" nama="kode" id="kode" value="" class="form-control" placeholder="Kode Barang" required autofocus />
                        <span class="input-group-btn">
                            <a class="btn btn-flat btn-success" id="autokode">
                                <i class="fa fa-magic"> Auto</i>
                            </a>
                        </span>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="barcode" class="control-label col-sm-4">Barcode : </label>
            <div class="col-sm-8">
                <input type="text" nama="barcode" id="barcode" value="" class="form-control" placeholder="Kode Barcode" required />
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="nama" class="control-label col-sm-4">Nama Barang : </label>
            <div class="col-sm-8">
                <input type="text" nama="nama" id="nama" value="" class="form-control" placeholder="Nama Barang" required />
            </div>
        </div>
    </div>
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="jenis" class="control-label col-sm-4">Jenis Barang : </label>
            <div class="col-sm-8">
                <select name="jenis" class="form-control select2" id="jenis" style="width: 100%;">
                    <option value=" "></option>
                </select>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="harga_beli" class="control-label col-sm-4">Harga Beli : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_beli" id="harga_beli" value="" class="form-control inputanangka" placeholder="Harga Beli Barang" required />
            </div>
        </div>
    </div>  
    <div class="col-sm-6 form-horizontal">
        <div class="form-group">
            <label for="pembulatan" class="control-label col-sm-4">Pembulatan : </label>
            <div class="col-sm-8">
                <input type="text" nama="pembulatan" id="pembulatan" value="" class="form-control inputanangka" placeholder="Nilai pembulatan (contoh : 1.000)" required />
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4 form-horizontal">
        <div class="form-group">
            <label for="markup_1" class="control-label col-sm-6">Markup 1 (%) : </label>
            <div class="col-sm-6">
                <input type="text" nama="markup_1" id="markup_1" value="" class="form-control inputanangka" placeholder="contoh: 100" required />
            </div>
        </div>
    </div>  
    <div class="col-sm-4 form-horizontal">
        <div class="form-group">
            <label for="harga_jual_1" class="control-label col-sm-4">Harga 1 : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_jual_1" id="harga_jual_1" value="" class="form-control inputanangka" placeholder="Harga Jual 1" required disabled />
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-4 form-horizontal">
        <div class="form-group">
            <label for="markup_2" class="control-label col-sm-6">Markup 2 (%) : </label>
            <div class="col-sm-6">
                <input type="text" nama="markup_2" id="markup_2" value="" class="form-control inputanangka" placeholder="contoh: 75" required />
            </div>
        </div>
    </div>  
    <div class="col-sm-4 form-horizontal">
        <div class="form-group">
            <label for="harga_jual_2" class="control-label col-sm-4">Harga 2 : </label>
            <div class="col-sm-8">
                <input type="text" nama="harga_jual_2" id="harga_jual_2" value="" class="form-control inputanangka" placeholder="Harga Jual 2" required disabled />
            </div>
        </div>
    </div>
</div>

<hr />
<div class="row">
    <div class="col-md-12">
        <p class="text-warning"><span class="text-danger">* </span> Catatan : </p>
        <p><span class="text-primary">Harga Jual 1 : </span> Untuk penjualan umum dan member dengan level 1</p>
        <p><span class="text-primary">Harga Jual 2 dan 3 : </span> Untuk member dengan level 2 dan 3</p>
    </div>
</div>