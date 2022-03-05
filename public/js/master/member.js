$(document).ready(function() {
    var route = "/cekhakakses/ubah_member";
    var bolehUbah;
    $.get(route, function (res) {
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_member";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });

    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/members',
        },

        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-2"
            },{
                'targets':1,
                'sClass': "col-md-2"
            },{
                'targets':2,
                'sClass': "text-center col-md-2"
            },{
                'targets':3,
                'sClass': "col-md-2"
            }, {
                'targets':4,
                'sClass': "text-center col-md-1"
            },{
                'targets':5,
                'sClass': "text-center col-md-1",
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" disabled>';
                }
            },{
                'targets': 6,
                'searchable': false,
                "orderable": false,
                "orderData": false,
                "orderDataType": false,
                "orderSequence": false,
                "sClass": "text-center col-md-2 td-aksi",
                'render': function (data, type, full, meta) {
                    var kembali = '';
                    
                    if (bolehHapus == true) {
                        kembali += '<button title="Hapus Data" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modalHapus" onclick="HapusClick(this);"><i class="fa fa-trash fa-fw"></i> </button>';
                    }
                    if (bolehUbah == true) {
                        kembali += '<button title="Ubah Data" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#modalUbah" onclick="UbahClick(this);"><i class="fa fa-pencil-square-o fa-fw"></i> </button>';
                    }

                    return kembali;

                }
            }
        ],
        'rowCallback': function (row, data, dataIndex) {
            if (bolehUbah == true) {
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[6]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[6]);
            }
            if (data[5] == '1') {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');    
            }

        }
    });


    $("#level").select2();
    $("#levelubah").select2();

    document.getElementById("kode").maxLength = 7;
    document.getElementById("nama").maxLength = 100;
    document.getElementById("gsm").maxLength = 15;
    document.getElementById("alamat").maxLength = 200;


    document.getElementById("namaubah").maxLength = 100;
    document.getElementById("gsmubah").maxLength = 15;
    document.getElementById("alamatubah").maxLength = 200;
});

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function TambahClick() {
    $('#kode').val(null);
    $('#nama').val(null);
    $('#level').val(' ').trigger('change');
    $('#gsm').val(null);
    $('#alamat').val(null);

    $('#kode').focus();
}

$('#autokode').click(function() {
    route = "/memberautokode";

    $.get(route, function (res) {
        $('#kode').val(res);
    });
});

$('#simpantambah').click(function() {
    var route = "/member";

    var kode = $('#kode').val();
    if (jQuery.trim(kode) == '' || kode == undefined) {
        alert('Kode member tidak boleh dikosongkan');
        $('#kode').focus();
        return;
    }

    var nama = $('#nama').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama member tidak boleh dikosongkan');
        $('#nama').focus();
        return;
    }

    var level = $('#level').val();
    if (jQuery.trim(level) == '' || level == ' ' || level == undefined) {
        alert('Pilih jenis member dengan benar !');
        $('#level').focus();
        return;
    }

    var gsm = $('#gsm').val();
    if (gsm == undefined) {
        gsm = '';
    }

    var alamat = $('#alamat').val();
    if (alamat == undefined) {
        alamat = '';
    }

    var token = $('#token').val();

    $.ajax({
        url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
        data: {
            kode : kode,
            nama: nama,
            level: level,
            alamat: alamat,
            gsm: gsm,
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

            TambahClick();
        }
    });
});

function UbahClick(btn) {
    route = "/member/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);

        $('#kodeubah').val(res.kode);
        $('#namaubah').val(res.nama);
        $('#gsmubah').val(res.gsm);
        $('#alamatubah').val(res.alamat);
        $('#levelubah').val(''+res.level).trigger('change');
        $("#aktifubah").prop('checked', (res.aktif == '0' ? false : true));

        $('#namaubah').focus();

    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var route = "/member/" + id;

    var nama = $('#namaubah').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama member tidak boleh dikosongkan');
        $('#namaubah').focus();
        return;
    }

    var level = $('#levelubah').val();
    if (jQuery.trim(level) == '' || level == ' ' || level == undefined) {
        alert('Pilih jenis member dengan benar !');
        $('#levelubah').focus();
        return;
    }

    var gsm = $('#gsmubah').val();
    if (gsm == undefined) {
        gsm = '';
    }

    var alamat = $('#alamatubah').val();
    if (alamat == undefined) {
        alamat = '';
    }

    var aktif = $("#aktifubah").is(':checked') ? 1 : 0;
    if (aktif == undefined) {
        aktif = 1;
    }

    var token = $('#token').val();

    $.ajax({
        url: route,
        type: 'PUT',
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        data: {
            nama: nama,
            gsm: gsm,
            aktif : aktif,
            alamat: alamat,
            level: level,
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
    var id = $('#idHapus').val();
    var route = "/member/" + id;
    var token = $('#token').val();

    $.ajax({
        url: route,
        type: 'DELETE',
        headers: {'X-CSRF-TOKEN': token},
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