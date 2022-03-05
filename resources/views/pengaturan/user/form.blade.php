<div class="form-group">
        {!! Form::label('username', 'Username') !!}
        {!! Form::text('username', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Pengguna', 'required']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('role', 'Grup') !!}
        {!!  Form::select('role', [], null, ['class' => 'form-control select2', 'style'=>"width: 100%;"])  !!}
    </div>

    <div class="form-group">
        {!! Form::label('fullname', 'Nama Lengkap') !!}
        {!! Form::text('fullname', null, ['class' => 'form-control', 'placeholder' => 'Masukan Nama Lengkap']) !!}
    </div>


    {!! Form::label('password', 'Password') !!} <br/>
    <div class="form-group input-group">
        {!! Form::text('password', null, ['class' => 'form-control', 'placeholder' => 'Masukan Kata Sandi']) !!}
        <span class="input-group-btn">
            <a class="btn btn-flat btn-default" id="katasandiauto">
                <i class="fa fa-magic"> Otomatis</i>
            </a>
        </span>
    </div>

    <div class="checkbox">
        <label>
            <input type="checkbox" name="active" id="active" value=""> Aktif
        </label>
    </div>