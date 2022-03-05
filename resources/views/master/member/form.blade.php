<div class="form-group">
    <label for="kode">Kode : </label>
    <div class="input-group">
        <input type="text" name="kode" id="kode" value="" class="form-control" placeholder="Kode member" required autofocus />
            <span class="input-group-btn">
                <a class="btn btn-flat btn-success" id="autokode"><i class="fa fa-magic"> Auto</i></a>
            </span>
    </div>
</div>

<div class="form-group">
    <label for="nama">Nama Lengkap : </label>
    <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama Lengkap" value="" required />
</div>

<div class="form-group">
    <label for="gsm">No. HP : </label>
    <input type="text" class="form-control" name="gsm" id="gsm" placeholder="Nomor HP" value="" />
</div>

<div class="form-group">
    <label for="alamat">Alamat : </label>
    <input type="text" class="form-control" name="alamat" id="alamat" placeholder="Alamat member" value="" />
</div>

<div class="form-group">
    <label for="level">Level Harga : </label>
    <select name="level" class="form-control select2" id="level" style="width: 100%;">
        <option value=" ">=== Pilih Level Harga === </option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
    </select>
</div>