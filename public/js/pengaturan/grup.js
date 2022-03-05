$(document).ready(function () {
    var route = "/cekhakakses/ubah_grup";
    var bolehUbah;
    $.get(route, function (res) {
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_grup";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });


    $('#dataTableBuilder').DataTable({
        //scrollX: true,
        //scrollColapse:true,
        responsive: true,
        'ajax': {
            'url': '/grups',
        },
        'columnDefs': [{
            'targets': 3,
            'searchable': false,
            "orderable": false,
            "orderData": false,
            "orderDataType": false,
            "orderSequence": false,
            "sClass": "text-center col-lg-2 td-aksi",
            'render': function (data, type, full, meta) {
                var kembali = '';
                if (bolehUbah == true) {
                    kembali += '<button title="Ubah Data" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#modalUbah" onclick="UbahClick(this);"><i class="fa fa-pencil-square-o fa-fw"></i> </button>';
                }
                if (bolehHapus == true) {
                    kembali += '<button title="Hapus Data" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modalHapus" onclick="HapusClick(this);"><i class="fa fa-trash fa-fw"></i> </button>';
                }

                return kembali;

            }
        },{
            'targets':0,
            'sClass': "col-lg-2"
        }, {
            'targets':1,
            'sClass': "col-lg-3"
        },{
            'targets':2,
            'sClass': "col-lg-5"
        }],
        'rowCallback': function (row, data, dataIndex) {
            if (bolehUbah == true) {
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[3]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[3]);
            }

        }
    });

    $('select[name="permissions_grupubah[]"]').bootstrapDualListbox();

    document.getElementById("nameubah").maxLength = 100;
    document.getElementById("display_nameubah").maxLength = 200;
    document.getElementById("descriptionubah").maxLength = 200;

    document.getElementById("name").maxLength = 100;
    document.getElementById("display_name").maxLength = 200;
    document.getElementById("description").maxLength = 200;

    $('#name').focus();

    var inputHakAkses = $('select[name="permissions_grup[]"]').bootstrapDualListbox();
});

function resetTambah() {
    $('#name').val(null);
    $('#display_name').val(null);
    $('#description').val(null);
    $('select[name="permissions_grup[]"]').val(null);
    $('select[name="permissions_grup[]"]').bootstrapDualListbox('refresh');
    $('#name').focus();
}

$('#simpantambah').click(function() {
    var route = "/grup";
    var token = $('#token').val();

        var name = $('#name').val();
        if (name == '' || name == undefined) {
            alert('Nama Grup User tidak boleh dikosongkan');
            $('#name').focus();
            return;
        }


        var display_name = $('#display_name').val();
        if (display_name == '' || display_name == undefined) {
            alert('Nama yang akan terlihat tidak boleh dikosongkan');
            $('#display_name').focus();
            return;
        }

        var description = $('#description').val();
        if (description == undefined) {
            description = '';
        }

        var permissions_grup = $('select[name="permissions_grup[]"]').val();
        if (permissions_grup == null || jQuery.isEmptyObject(permissions_grup)) {
            alert('Grup User harus memiliki hak akses');
            $('select[name="permissions_grup[]"]').focus();
            return;
        }

        //console.log(permissions_grup);
        //
        //return;


        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
                name: name,
                display_name: display_name,
                description: description,
                permissions_grup: permissions_grup,
                _token: token
            },
            error: function (res) {
                var errors = res.responseJSON;
                var pesan = '';
                $.each(errors, function (index, value) {
                    pesan += value + "\n";
                });

                alert(pesan);
            },
            success: function () {
                reloadTable();
                alert('Sukses Menyimpan Data');

                resetTambah();
            }
        });
    });

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function HapusClick(btn) {
    $('#idHapus').val(btn.value);
}

$('#yakinhapus').click(function () {
    var token = $('#token').val();
    var id = $('#idHapus').val();
    var route = "/grup/" + id;

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'DELETE',
        dataType: 'json',
        error: function (res) {
            var errors = res.responseJSON;
            var pesan = '';
            $.each(errors, function (index, value) {
                pesan += value + "\n";
            });

            alert(pesan);
        },
        success: function () {
            reloadTable();
            alert('Sukses Menghapus Data');
            $('#modalHapus').modal('toggle');
        }
    });
});

function UbahClick(btn) {
    route = "/grup/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);
        $('#nameubah').val(res.name);
        $('#display_nameubah').val(res.display_name);
        $('#descriptionubah').val(res.description);

        $('select[name="permissions_grupubah[]"]').val(res.permissions_grup);

        $('select[name="permissions_grupubah[]"]').bootstrapDualListbox('refresh');

        $('#display_nameubah').focus();

    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var token = $('#token').val();
    var route = "/grup/" + id;

    var name = $('#nameubah').val();
    if (name == '' || name == undefined) {
        alert('Nama Grup User tidak boleh dikosongkan');
        $('#nameubah').focus();
        return;
    }

    var display_name = $('#display_nameubah').val();
    if (display_name == '' || display_name == undefined) {
        alert('Nama yang akan terlihat tidak boleh dikosongkan');
        $('#display_nameubah').focus();
        return;
    }

    var description = $('#descriptionubah').val();
    if (description == undefined) {
        description = '';
    }

    var permissions_grup = $('select[name="permissions_grupubah[]"]').val();
    if (permissions_grup == null || jQuery.isEmptyObject(permissions_grup)) {
        alert('Grup User harus memiliki hak akses');
        $('select[name="permissions_grupubah[]"]').focus();
        return;
    }

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            name: name,
            display_name: display_name,
            description: description,
            permissions_grup: permissions_grup,
            _token: token
        },
        error: function (res) {
            var errors = res.responseJSON;
            var pesan = '';
            $.each(errors, function (index, value) {
                pesan += value + "\n";
            });

            alert(pesan);
        },
        success: function () {
            reloadTable();
            alert('Sukses Mengubah Data');
            $('#modalUbah').modal('toggle');
        }
    });
});