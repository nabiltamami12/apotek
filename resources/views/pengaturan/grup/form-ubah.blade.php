<div class="form-group">
    {!! Form::label('nameubah', 'Nama') !!}
    {!! Form::text('nameubah', null, ['class' => 'form-control', 'id'=>'nameubah','disabled']) !!}
</div>

<div class="form-group">
    {!! Form::label('display_nameubah', 'Nama yang akan terlihat') !!}
    {!! Form::text('display_nameubah', null, ['class' => 'form-control', 'id'=>'display_nameubah','placeholder' => 'Masukan Nama yang akan terlihat nantinya']) !!}
</div>

<div class="form-group">
    {!! Form::label('descriptionubah', 'Deskripsi') !!}
    {!! Form::text('descriptionubah', null, ['class' => 'form-control', 'id'=>'descriptionubah','placeholder' => 'Masukan Deskripsi Group']) !!}
</div>


<div class="form-group">
    {!! Form::label('permissions_grupubah[]', 'Hak Akses Group') !!}
    {{--    {!! Form::select('permissions_grupubah[]', [' ' => ''], null, ['multiple'=>'multiple', 'id'=>'permissions_grupubah', 'size', '10']) !!}--}}
    {{--{!! Form::select() !!}--}}

    <select multiple="multiple" size="10" name="permissions_grupubah[]">
        @foreach ( $permissions as $perms)
            <option value="{{ $perms->id }}">{{ $perms->display_name }}</option>
        @endforeach
    </select>
</div>
