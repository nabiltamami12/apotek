$(document).ready(function() {
    var route = "/cekhakakses/ubah_suplier";
    var bolehUbah;
    $.get(route, function (res) { 
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_suplier";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });

    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/supliers', 
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
                'sClass': "col-md-1"
            }, {
                'targets':4,
                'sClass': "text-center col-md-1"
            }, {
                'targets':5,
                'sClass': "text-center col-md-1"
            }, {
                'targets':6,
                'sClass': "text-center col-md-1"
            },{
                'targets':7,
                'sClass': "text-center col-md-1",
                'render': function (data, type, full, meta) {
                    return '<input type="checkbox" disabled>';
                }
            },{
                'targets': 8,
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
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[8]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[8]);
            }
            if (data[7] == '1') {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');    
            }

        }
    });


    document.getElementById("kode").maxLength = 7;
    document.getElementById("nama").maxLength = 100;
    document.getElementById("telp").maxLength = 15;
    document.getElementById("alamat").maxLength = 200;


    document.getElementById("namaubah").maxLength = 100;
    document.getElementById("telpubah").maxLength = 15;
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
    $('#alamat').val(null);
    $('#telp').val(null);
    $('#bank').val(null);
    $('#norek').val(null);
    $('#bank_pemilik').val(null);
    $('#email').val(null);

    $('#kode').focus();
}

$('#autokode').click(function() {
    route = "/suplierautokode";

    $.get(route, function (res) {
        $('#kode').val(res);
    });
});

$('#simpantambah').click(function() {
    var route = "/suplier";

    var kode = $('#kode').val();
    if (jQuery.trim(kode) == '' || kode == undefined) {
        alert('Kode member tidak boleh dikosongkan');
        $('#kode').focus();
        return;
    }

    var nama = $('#nama').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama Suplier tidak boleh dikosongkan');
        $('#nama').focus();
        return;
    }
	
	var alamat = $('#alamat').val();
    if (jQuery.trim(alamat) == '' || alamat == undefined) {
        alert('Alamat Suplier tidak boleh dikosongkan');
        $('#alamat').focus();
        return;
    }
	
	var telp = $('#telp').val();
    if (jQuery.trim(telp) == '' || telp == undefined) {
        alert('telp Suplier tidak boleh dikosongkan');
        $('#telp').focus();
        return;
    }
	
	var bank = $('#bank').val();
    if (jQuery.trim(bank) == '' || bank == undefined) {
        alert('bank Suplier tidak boleh dikosongkan');
        $('#bank').focus();
        return;
    }
	
	var norek = $('#norek').val();
    if (jQuery.trim(norek) == '' || norek == undefined) {
        alert('norek Suplier tidak boleh dikosongkan');
        $('#norek').focus();
        return;
    }
	
	var bank_pemilik = $('#bank_pemilik').val();
    if (jQuery.trim(bank_pemilik) == '' || bank_pemilik == undefined) {
        alert('Bank Pemilik Suplier tidak boleh dikosongkan');
        $('#bank_pemilik').focus();
        return;
    }
	
	var email = $('#email').val();
    if (jQuery.trim(email) == '' || email == undefined) {
        alert('Email Suplier tidak boleh dikosongkan');
        $('#email').focus();
        return;
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
            alamat: alamat,
            telp: telp,
            bank: bank,
            norek: norek,
            bank_pemilik: bank_pemilik,
            email: email,
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
    route = "/suplier/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);

        $('#kodeubah').val(res.kode);
        $('#namaubah').val(res.nama);
        $('#alamatubah').val(res.alamat);
        $('#telpubah').val(res.telp);
        $('#bankubah').val(res.bank);
        $('#norekubah').val(res.norek);
        $('#bank_pemilikubah').val(res.bank_pemilik);
        $('#emailubah').val(res.email);
        $("#aktifubah").prop('checked', (res.aktif == '0' ? false : true));

        $('#namaubah').focus();

    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var route = "/suplier/" + id;

    var nama = $('#namaubah').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama Suplier tidak boleh dikosongkan');
        $('#namaubah').focus();
        return;
    }
	
	var alamat = $('#alamatubah').val();
    if (jQuery.trim(alamat) == '' || alamat == undefined) {
        alert('Alamat Suplier tidak boleh dikosongkan');
        $('#alamatubah').focus();
        return;
    }
	
	var telp = $('#telpubah').val();
    if (jQuery.trim(telp) == '' || telp == undefined) {
        alert('telp Suplier tidak boleh dikosongkan');
        $('#telpubah').focus();
        return;
    }
	
	var bank = $('#bankubah').val();
    if (jQuery.trim(bank) == '' || bank == undefined) {
        alert('bank Suplier tidak boleh dikosongkan');
        $('#bankubah').focus();
        return;
    }
	
	var norek = $('#norekubah').val();
    if (jQuery.trim(norek) == '' || norek == undefined) {
        alert('norek Suplier tidak boleh dikosongkan');
        $('#norekubah').focus();
        return;
    }
	
	var bank_pemilik = $('#bank_pemilikubah').val();
    if (jQuery.trim(bank_pemilik) == '' || bank_pemilik == undefined) {
        alert('Bank Pemilik Suplier tidak boleh dikosongkan');
        $('#bank_pemilikubah').focus();
        return;
    }
	
	var email = $('#emailubah').val();
    if (jQuery.trim(email) == '' || email == undefined) {
        alert('Email Suplier tidak boleh dikosongkan');
        $('#emailubah').focus();
        return;
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
            alamat: alamat,
            telp: telp,
            bank: bank,
            norek: norek,
            bank_pemilik: bank_pemilik,
            email: email,
			aktif : aktif,
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
    var route = "/suplier/" + id;
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