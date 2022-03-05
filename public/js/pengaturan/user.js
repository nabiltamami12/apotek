$(document).ready(function () {
    document.getElementById("fullnameubah").maxLength = 200;
    document.getElementById("usernameubah").maxLength = 50;
    document.getElementById("passwordubah").maxLength = 50;
    // document.getElementById("validate_password").maxLength = 50;

    var route = "/get_select_group";
    var inputTipe = $('#roleubah');
    var inputTipe1 = $('#role');

    var list = document.getElementById("roleubah");
    var list1 = document.getElementById("role");

    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    while (list1.hasChildNodes()) {
        list1.removeChild(list1.firstChild);
    }

    inputTipe.append('<option value=" ">Pilih Grup User</option>');
    inputTipe1.append('<option value=" ">Pilih Grup User</option>');

    $.get(route, function (res) {
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[0] + '">' + value[1] + '</option>');
            inputTipe1.append('<option value="' + value[0] + '">' + value[1] + '</option>');
        });
    });


    var route1 = "/cekhakakses/ubah_user";
    var bolehUbah;
    $.get(route1, function (res) {
        bolehUbah = res;
    });

    var route2 = "/cekhakakses/hapus_user";
    var bolehHapus;
    $.get(route2, function (res) {
        bolehHapus = res;
    });

    $("#roleubah").select2();
    $("#role").select2();

    $('#dataTableBuilder').DataTable({
        //scrollX: true,
        //scrollColapse:true,
        responsive: true,
        'ajax': {
            'url': '/users',
        },
        'columnDefs': [{
            'targets': 4,
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
            'sClass': "col-lg-1"
        }, {
            'targets':1,
            'sClass': "col-lg-3"
        },{
            'targets':2,
            'sClass': "col-lg-2"
        },{
            'targets':3,
            'sClass': "text-center col-lg-1",
            'render': function (data, type, full, meta) {
                return '<input type="checkbox" disabled>';
            }
        }],
        'rowCallback': function (row, data, dataIndex) {
            if (bolehUbah == true) {
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[4]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[4]);
            }

            if (data[3] == '1') {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');    
            }
        }
    });

    $('#ubahkatasandi').click(function () {
        var ubahkatasandi = $('#ubahkatasandi').is(':checked') ? 1 : 0;
        if (ubahkatasandi == 1) {
            $('#divSandi').removeClass('hidden');
            // $('#divValidasiSandi').removeClass('hidden');
        } else {
            $('#divSandi').addClass('hidden');
            // $('#divValidasiSandi').addClass('hidden');
        }
    });

    document.getElementById("fullname").maxLength = 200;
    document.getElementById("username").maxLength = 50;
    document.getElementById("password").maxLength = 50;

    $("#active").attr('checked', true);

    $('#username').focus();
});

function resetTambah() {
    $('#username').val(null);
    $('#role').val(' ').trigger('change');
    $('#fullname').val(null);
    $('#password').val(null);
    $("#active").attr('checked', true);
    $('#username').focus();
}

$('#simpantambah').click(function() {
        var route = "/user";
        var token = $('#token').val();

        var username = $('#username').val();
        if (username == '' || username == undefined) {
            alert('Username tidak boleh dikosongkan');
            $('#username').focus();
            return;
        }

        var role = $('#role').val();
        if (role == '' || role == ' ' || role == undefined) {
            alert('Pilih grup user dengan benar!');
            $('#role').focus();
            return;
        }

        var fullname = $('#fullname').val();
        if (fullname == '' || fullname == undefined) {
            alert('Nama Lengkap tidak boleh dikosongkan');
            $('#fullname').focus();
            return;
        }

        var password = $('#password').val();
        if (password == '' || password == undefined) {
            alert('Kata Sandi tidak boleh kosong');
            $('#password').focus();
            return;
        }

        var active = $("#active").is(':checked') ? 1 : 0;
        if (active == undefined) {
            active = 1;
        }

        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
                fullname : fullname,
                username : username,
                role : role,
                password : password,
                active : active,
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

function UbahClick(btn) {
    route = "/user/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);
        $('#usernameubah').val(res.username);

        $('#roleubah').val(''+res.role).trigger('change');
        // $('#roleubah').select2('val', '' + res.role);

        $('#passwordubah').val('');

        //$('#role').val(res.role);
        $('#fullnameubah').val(res.fullname);

        $("#activeubah").prop('checked', (res.active == '0' ? false : true));

        var ubahkatasandi = $('#ubahkatasandi').is(':checked') ? 1 : 0;
        if (ubahkatasandi == 1) {
            $('#divSandi').addClass('hidden');
            // $('#divValidasiSandi').addClass('hidden');

            $("#ubahkatasandi").prop('checked', false);
        }

        $('#usernameubah').focus();

    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var token = $('#token').val();
    var route = "/user/" + id;

    var username = $('#usernameubah').val();
    if (username == '' || username == undefined) {
        alert('Username tidak boleh dikosongkan');
        $('#usernameubah').focus();
        return;
    }

    var role = $('#roleubah').val();
    if (role == '' || role == ' ' || role == undefined) {
        alert('Pilih grup user dengan benar!');
        $('#roleubah').focus();
        return;
    }

    var fullname = $('#fullnameubah').val();
    if (fullname == '' || fullname == undefined) {
        alert('Nama Lengkap tidak boleh dikosongkan');
        $('#fullnameubah').focus();
        return;
    }

    var password = '';
    var validate_password = '';

    var ubahkatasandi = $('#ubahkatasandi').is(':checked') ? 1 : 0;
    if (ubahkatasandi == 1) {
        password = $('#passwordubah').val();
        if (password == '' || password == undefined) {
            alert('Kata Sandi tidak boleh kosong');
            $('#passwordubah').focus();
            return;
        }
    }

    var active = $("#activeubah").is(':checked') ? 1 : 0;
    if (active == undefined) {
        active = 1;
    }

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            fullname : fullname,
            username : username,
            role : role,
            ubahkatasandi : ubahkatasandi,
            password : password,
            active : active,
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

function HapusClick(btn) {
    $('#idHapus').val(btn.value);
}

$('#yakinhapus').click(function () {
    var token = $('#token').val();
    var id = $('#idHapus').val();
    var route = "/user/" + id;

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

$('#katasandiautoubah').click(function() {
    $('#passwordubah').val(randomPassword(5));
});

$('#katasandiauto').click(function() {
    $('#password').val(randomPassword(5));
});