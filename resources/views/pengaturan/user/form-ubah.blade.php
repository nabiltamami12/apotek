<div class="form-group">
        {!! Form::label('usernameubah', 'Username') !!}
        {!! Form::text('usernameubah', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Pengguna']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('roleubah', 'Grup') !!}
        {!!  Form::select('roleubah', [], null, ['class' => 'form-control select2', 'style'=>"width: 100%;"])  !!}
    </div>

    <div class="form-group">
        {!! Form::label('fullnameubah', 'Nama Lengkap') !!}
        {!! Form::text('fullnameubah', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Lengkap']) !!}
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="ubahkatasandi" id="ubahkatasandi" value="" checked><strong class="f_warning">Mengubah Password</strong>
        </label>
    </div>

    <div id="divSandi" class="form-group hidden">
        {!! Form::label('passwordubah', 'Password Baru') !!} <br/>
        <div id="divSandi" class="form-group input-group">
            {!! Form::text('passwordubah', null, ['class' => 'form-control', 'placeholder' => 'Masukan Password']) !!}
            <span class="input-group-btn">
                <a class="btn btn-flat btn-default" id="katasandiautoubah">
                    <i class="fa fa-magic"> Otomatis</i>
                </a>
            </span>
        </div>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="activeubah" id="activeubah" value=""> Aktif
        </label>
    </div>

