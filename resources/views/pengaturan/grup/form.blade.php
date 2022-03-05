<div class="form-group">
        {!! Form::label('name', 'Nama') !!}
        {!! Form::text('name', null, ['class' => 'form-control', 'id'=>'name','placeholder' => 'Masukan Nama Group']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('display_name', 'Nama yang akan terlihat') !!}
        {!! Form::text('display_name', null, ['class' => 'form-control', 'id'=>'display_name','placeholder' => 'Masukan Nama yang akan terlihat nantinya']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('description', 'Deskripsi') !!}
        {!! Form::text('description', null, ['class' => 'form-control', 'id'=>'description','placeholder' => 'Masukan Deskripsi Group']) !!}
    </div>

        <div class="form-group">
            {!! Form::label('permissions_grup[]', 'Hak Akses Grup') !!}

            <select multiple="multiple" size="10" name="permissions_grup[]">
                @foreach ( $permissions as $perms)
                    <option value="{{ $perms->id }}">{{ $perms->display_name }}</option>
                @endforeach
            </select>
        </div>