$(document).ready(function() {
	var route = "/cekhakakses/ubah_jenis";
    var bolehUbah;
    $.get(route, function (res) {
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_jenis";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });

    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/jenises',
        },
        'columnDefs': [
        	{
            	'targets':0,
            	'sClass': "col-md-10"
        	},{
	            'targets': 1,
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
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[1]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[1]);
            }

        }
    });

    document.getElementById("nama").maxLength = 50;
});

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

$('#simpantambah').click(function() {
	var route = "/jenis";
    var token = $('#token').val();

    var nama = $('#nama').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
    	alert('Nama Jenis Barang tidak boleh kosong !!');
        $('#nama').focus();
        return;
    }

	$.ajax({
		url: route,
		type: 'POST',
		headers: {'X-CSRF-TOKEN': token},
		dataType: 'json',
		data: {
			nama: nama,
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
			$('#nama').val('');
		}
	});
});

function UbahClick(btn) {
    var route = "/jenis/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);
        $('#namaubah').val(res.nama);
    });
}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var token = $('#token').val();
    var route = "/jenis/" + id;

    var namaubah = $('#namaubah').val();
    if (namaubah == '' || jQuery.trim(namaubah) == '' || namaubah == undefined) {
    	alert('Nama jenis barang tidak boleh dikosongkan');
        $('#namaubah').focus();
        return;
    }

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            nama: namaubah,
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
    var route = "/jenis/" + id;

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