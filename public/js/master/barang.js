$(document).ready(function() {
    var route = "/cekhakakses/ubah_barang";
    var bolehUbah;
    $.get(route, function (res) {
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_barang";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });

    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/barangs',
        },

        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-1"
            },{
                'targets':1,
                'sClass': "text-center col-md-2"
            },{
                'targets':2,
                'sClass': "col-md-3"
            },{
                'targets':3,
                'sClass': "col-md-2"
            }, {
                'targets':4,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets': 5,
                'searchable': false,
                "orderable": false,
                "orderData": false,
                "orderDataType": false,
                "orderSequence": false,
                "sClass": "text-center col-md-3 td-aksi",
                'render': function (data, type, full, meta) {
                    var kembali = '<button title="Lihat Detail Data" class="btn btn-success btn-flat" data-toggle="modal" data-target="#modalLihat" onclick="LihatClick(this);"><i class="fa fa-eye fa-fw"></i> </button>';
                    
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
            $(row).find('button[class="btn btn-success btn-flat"]').prop('value', data[5]);
            if (bolehUbah == true) {
                $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[5]);
            }
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[5]);
            }

        }
    });

    var route3 = "/jenises";
    var inputTipe = $('#jenis');
    var inputTipe2 = $('#jenisubah');

    var list = document.getElementById("jenis");
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    inputTipe.append('<option value=" ">Pilih Jenis Barang</option>');

    var list2 = document.getElementById("jenisubah");
    while (list2.hasChildNodes()) {
        list2.removeChild(list2.firstChild);
    }
    inputTipe2.append('<option value=" ">Pilih Jenis Barang</option>');

    $.get(route3, function (res) {
        // console.log(res);
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[1] + '">' + value[0] + '</option>');
            inputTipe2.append('<option value="' + value[1] + '">' + value[0] + '</option>');
        });
    });

    $("#jenis").select2();
    $("#jenisubah").select2();

    document.getElementById("kode").maxLength = 7;
    document.getElementById("barcode").maxLength = 25;
    document.getElementById("nama").maxLength = 100;
    document.getElementById("pembulatan").maxLength = 15;
    document.getElementById("harga_beli").maxLength = 15;
    document.getElementById("markup_1").maxLength = 3;
    document.getElementById("markup_2").maxLength = 3;
    document.getElementById("harga_jual_1").maxLength = 15;
    document.getElementById("harga_jual_2").maxLength = 15;


    document.getElementById("kodeubah").maxLength = 7;
    document.getElementById("barcodeubah").maxLength = 25;
    document.getElementById("namaubah").maxLength = 100;
    document.getElementById("pembulatanubah").maxLength = 15;
    document.getElementById("harga_beliubah").maxLength = 15;
    document.getElementById("markup_1ubah").maxLength = 3;
    document.getElementById("markup_2ubah").maxLength = 3;
    document.getElementById("harga_jual_1ubah").maxLength = 15;
    document.getElementById("harga_jual_2ubah").maxLength = 15;

    $('.inputanangka').on('keypress', function(e) {
        var c = e.keyCode || e.charCode;
        switch (c) {
            case 8: case 9: case 27: case 13: return;
            case 65:
                if (e.ctrlKey === true) return;
        }
        if (c < 48 || c > 57) e.preventDefault();
    }).on('keyup', function() {
        //alert('disini');
        var inp = $(this).val().replace(/\./g, '');
        $(this).val(formatRibuan(inp));

        reloadHargaJual();
    });
});

function reloadHargaJual() {
    var harga_beli = $('#harga_beli').val();
    var pembulatan = $('#pembulatan').val();

    var markup_1 = $('#markup_1').val();
    var markup_2 = $('#markup_2').val();
    
    $('#harga_jual_1').val("0");
    $('#harga_jual_2').val("0");

    // harga 1
    if (harga_beli != undefined && jQuery.trim(harga_beli) != '' && intVal(harga_beli) > 0 && pembulatan != undefined && jQuery.trim(pembulatan) != '' && intVal(pembulatan) >= 0) {
        // harga 1
        if (markup_1 != undefined && jQuery.trim(markup_1) != '' && intVal(markup_1) >= 0 ) {
            var harga_markup1 = intVal(harga_beli) * intVal(markup_1) / 100 ;
            var harga_jual_1 = harga_markup1 + intVal(harga_beli)  ;
            var harga_markup_1_bulat = intVal(pembulatan) * intVal(markup_1) / 100  ;
            var harga_jual_1_bulat = harga_markup_1_bulat + intVal(pembulatan)  ;

            $('#harga_jual_1').val(number_format((intVal(pembulatan) != '0' ? harga_jual_1_bulat : harga_jual_1) , 0, ',', '.'));
        } 

        // harga 2
        if (markup_2 != undefined && jQuery.trim(markup_2) != '' && intVal(markup_2) >= 0 ) {
            var harga_markup2 = intVal(harga_beli) * intVal(markup_2) / 100 ;
            var harga_jual_2 = harga_markup2 + intVal(harga_beli)  ;
            var harga_markup_2_bulat = intVal(pembulatan) * intVal(markup_2) / 100  ;
            var harga_jual_2_bulat = harga_markup_2_bulat + intVal(pembulatan)  ;

            $('#harga_jual_2').val(number_format((intVal(pembulatan) != '0' ? harga_jual_2_bulat : harga_jual_2) , 0, ',', '.'));
        }   
   
    }


    // ubah
    var harga_beliubah = $('#harga_beliubah').val();
    var pembulatanubah = $('#pembulatanubah').val();

    var markup_1ubah = $('#markup_1ubah').val();
    var markup_2ubah = $('#markup_2ubah').val();
    
    
    $('#harga_jual_1ubah').val("0");
    $('#harga_jual_2ubah').val("0");

    // harga 1
    if (harga_beliubah != undefined && jQuery.trim(harga_beliubah) != '' && intVal(harga_beliubah) > 0 && 
                    pembulatanubah != undefined && jQuery.trim(pembulatanubah) != '' && intVal(pembulatanubah) >= 0) {
        // harga 1
        if (markup_1ubah != undefined && jQuery.trim(markup_1ubah) != '' && intVal(markup_1ubah) >= 0 ) {
            var harga_markup1_ubah = intVal(harga_beliubah) * intVal(markup_1ubah) / 100 ;
            var harga_jual_1_ubah = harga_markup1_ubah + intVal(harga_beliubah);
			var harga_markup_1_ubah_bulat = intVal(pembulatanubah) * intVal(markup_1ubah) / 100  ;
            var harga_jual_1_ubah_bulat = harga_markup_1_ubah_bulat + intVal(pembulatanubah)  ;

            $('#harga_jual_1ubah').val(number_format((intVal(pembulatanubah) != '0' ? harga_jual_1_ubah_bulat : harga_jual_1_ubah) , 0, ',', '.'));
			
        } 

        // harga 2
        if (markup_2ubah != undefined && jQuery.trim(markup_2ubah) != '' && intVal(markup_2ubah) >= 0 ) {
            var harga_markup2_ubah = intVal(harga_beliubah) * intVal(markup_2ubah) / 100 ;
            var harga_jual_2_ubah = harga_markup2_ubah + intVal(harga_beliubah);
			var harga_markup_2_ubah_bulat = intVal(pembulatanubah) * intVal(markup_2ubah) / 100  ;
            var harga_jual_2_ubah_bulat = harga_markup_2_ubah_bulat + intVal(pembulatanubah)  ;

            $('#harga_jual_2ubah').val(number_format((intVal(pembulatanubah) != '0' ? harga_jual_2_ubah_bulat : harga_jual_2_ubah) , 0, ',', '.'));
        }   

           
    }
}

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function TambahClick() {
    $('#kode').val(null);
    $('#barcode').val(null);
    $('#nama').val(null);
    $('#jenis').val(' ').trigger('change');
    // $('#jenis').select2('val', ' ');           
    $('#pembulatan').val("0");
    $('#harga_beli').val("0");
    $('#harga_jual_1').val('0');
    $('#harga_jual_2').val('0');

    $('#markup_1').val('0');
    $('#markup_2').val('0');
	
    $('#kode').focus();
}

$('#autokode').click(function() {
    route = "/barangautokode";

    $.get(route, function (res) {
        $('#kode').val(res);
    });
});

$('#simpantambah').click(function() {
    var route = "/barang";
    var token = $('#token').val();

    var kode = $('#kode').val();
    if (jQuery.trim(kode) == '' || kode == undefined) {
        alert('Kode barang tidak boleh dikosongkan');
        $('#kode').focus();
        return;
    }

    var barcode = $('#barcode').val();
    if (jQuery.trim(barcode) == '' || barcode == undefined) {
        alert('Kode barcode tidak boleh dikosongkan');
        $('#barcode').focus();
        return;
    }

    var nama = $('#nama').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama barang tidak boleh dikosongkan');
        $('#nama').focus();
        return;
    }

    var jenis = $('#jenis').val();
    if (jQuery.trim(jenis) == '' || jenis == ' ' || jenis == undefined) {
        alert('Pilih jenis barang dengan benar !');
        $('#jenis').focus();
        return;
    }

    var harga_beli = $('#harga_beli').val();
    if (jQuery.trim(harga_beli) == '' || harga_beli == ' ' || intVal(harga_beli) < 0) {
        alert('Harga beli barang tidak valid');
        $('#harga_beli').focus();
        return;
    }

    harga_beli = intVal(harga_beli);

    var pembulatan = $('#pembulatan').val();
    if (jQuery.trim(pembulatan) == '' || pembulatan == ' ' || intVal(pembulatan) < 0) {
        alert('Nilai pembulatan harga tidak valid');
        $('#pembulatan').focus();
        return;
    }

    pembulatan = intVal(pembulatan);

    var markup_1 = $('#markup_1').val();
    if (jQuery.trim(markup_1) == '' || markup_1 == ' ' || intVal(markup_1) < 0) {
        alert('Markup harga jual 1 tidak valid');
        $('#markup_1').focus();
        return;
    }

    markup_1 = intVal(markup_1);

    var harga_jual_1 = $('#harga_jual_1').val();
    if (jQuery.trim(harga_jual_1) == '' || harga_jual_1 == ' ' || intVal(harga_jual_1) <= 0) {
        alert('Harga jual 1 tidak valid');
        $('#markup_1').focus();
        return;
    }

    harga_jual_1 = intVal(harga_jual_1);

    // markup 2
    var markup_2 = $('#markup_2').val();
    if (jQuery.trim(markup_2) == '' || markup_2 == ' ' || intVal(markup_2) < 0) {
        alert('Markup harga jual 2 tidak valid');
        $('#markup_2').focus();
        return;
    }

    markup_2 = intVal(markup_2);

    var harga_jual_2 = $('#harga_jual_2').val();
    if (jQuery.trim(harga_jual_2) == '' || harga_jual_2 == ' ' || intVal(harga_jual_2) <= 0) {
        alert('Harga jual 2 tidak valid');
        $('#markup_2').focus();
        return;
    }

    harga_jual_2 = intVal(harga_jual_2);
    // markup 2 end

   

    if (harga_jual_1 <= harga_beli) {
        alert('Harga jual harus lebih dari harga beli');
        $('#markup_1').focus();
        return;   
    }

    if (harga_jual_2 <= harga_beli) {
        alert('Harga jual harus lebih dari harga beli');
        $('#markup_2').focus();
        return;   
    }


    $.ajax({
        url: route,
        type: 'POST',
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        data: {
            kode : kode,
            barcode: barcode,
            nama: nama,
            jenis: jenis,
            harga_beli: harga_beli,
            pembulatan: pembulatan,
            markup_1: markup_1,
            markup_2: markup_2,
            harga_jual_1: harga_jual_1,
            harga_jual_2: harga_jual_2,
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
    route = "/barang/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);

        $('#kodeubah').val(res.kode);
        $('#barcodeubah').val(res.barcode);
        $('#namaubah').val(res.nama);
        $('#jenisubah').val(''+res.jenis_id).trigger('change');
        // $('#jenisubah').select2('val', ''+res.jenis_id);           
        // $('#harga_jualubah').val(number_format(intVal(res.harga_jual), 0, ',', '.'));
        $('#harga_beliubah').val(number_format(intVal(res.harga_beli), 0, ',', '.'));
        $('#pembulatanubah').val(number_format(intVal(res.pembulatan), 0, ',', '.'));
        $('#markup_1ubah').val(number_format(intVal(res.markup_1), 0, ',', '.'));
        $('#markup_2ubah').val(number_format(intVal(res.markup_2), 0, ',', '.'));
        $('#harga_jual_1ubah').val(number_format(intVal(res.harga_jual_1), 0, ',', '.'));
        $('#harga_jual_2ubah').val(number_format(intVal(res.harga_jual_2), 0, ',', '.'));

        $('#barcodeubah').focus();

    });

}

function LihatClick(btn) {
    route = "/barang/" + btn.value;

    $.get(route, function (res) {
        $('#kodelihat').val(res.kode);
        $('#barcodelihat').val(res.barcode);
        $('#namalihat').val(res.nama);
        $('#jenislihat').val(res.jenis);
        $('#harga_belilihat').val(number_format(intVal(res.harga_beli), 0, ',', '.'));
        $('#harga_jual_1lihat').val(number_format(intVal(res.harga_jual_1), 0, ',', '.'));
        $('#harga_jual_2lihat').val(number_format(intVal(res.harga_jual_2), 0, ',', '.'));
    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var token = $('#token').val();
    var route = "/barang/" + id;

    var barcode = $('#barcodeubah').val();
    if (jQuery.trim(barcode) == '' || barcode == undefined) {
        alert('Kode barcode tidak boleh dikosongkan');
        $('#barcodeubah').focus();
        return;
    }

    var nama = $('#namaubah').val();
    if (jQuery.trim(nama) == '' || nama == undefined) {
        alert('Nama barang tidak boleh dikosongkan');
        $('#namaubah').focus();
        return;
    }

    var jenis = $('#jenisubah').val();
    if (jQuery.trim(jenis) == '' || jenis == ' ' || jenis == undefined) {
        alert('Pilih jenis barang dengan benar !');
        $('#jenisubah').focus();
        return;
    }

    var harga_beli = $('#harga_beliubah').val();
    if (jQuery.trim(harga_beli) == '' || harga_beli == ' ' || intVal(harga_beli) < 0) {
        alert('Harga beli barang tidak valid');
        $('#harga_beliubah').focus();
        return;
    }

    harga_beli = intVal(harga_beli);

    var pembulatan = $('#pembulatanubah').val();
    if (jQuery.trim(pembulatan) == '' || pembulatan == ' ' || intVal(pembulatan) < 0) {
        alert('Nilai pembulatan harga tidak valid');
        $('#pembulatanubah').focus();
        return;
    }

    pembulatan = intVal(pembulatan);

    var markup_1 = $('#markup_1ubah').val();
    if (jQuery.trim(markup_1) == '' || markup_1 == ' ' || intVal(markup_1) < 0) {
        alert('Markup harga jual 1 tidak valid');
        $('#markup_1ubah').focus();
        return;
    }

    markup_1 = intVal(markup_1);

    var harga_jual_1 = $('#harga_jual_1ubah').val();
    if (jQuery.trim(harga_jual_1) == '' || harga_jual_1 == ' ' || intVal(harga_jual_1) <= 0) {
        alert('Harga jual 1 tidak valid');
        $('#markup_1ubah').focus();
        return;
    }

    harga_jual_1 = intVal(harga_jual_1);

    // markup 2
    var markup_2 = $('#markup_2ubah').val();
    if (jQuery.trim(markup_2) == '' || markup_2 == ' ' || intVal(markup_2) < 0) {
        alert('Markup harga jual 2 tidak valid');
        $('#markup_2ubah').focus();
        return;
    }

    markup_2 = intVal(markup_2);

    var harga_jual_2 = $('#harga_jual_2ubah').val();
    if (jQuery.trim(harga_jual_2) == '' || harga_jual_2 == ' ' || intVal(harga_jual_2) <= 0) {
        alert('Harga jual 2 tidak valid');
        $('#markup_2ubah').focus();
        return;
    }

    harga_jual_2 = intVal(harga_jual_2);
    // markup 2 end

   

    if (harga_jual_1 <= harga_beli) {
        alert('Harga jual harus lebih dari harga beli');
        $('#markup_1ubah').focus();
        return;   
    }

    if (harga_jual_2 <= harga_beli) {
        alert('Harga jual harus lebih dari harga beli');
        $('#markup_2ubah').focus();
        return;   
    }

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            barcode: barcode,
            nama: nama,
            jenis: jenis,
            harga_beli: harga_beli,
            pembulatan: pembulatan,
            markup_1: markup_1,
            markup_2: markup_2,
            harga_jual_1: harga_jual_1,
            harga_jual_2: harga_jual_2,
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
    var route = "/barang/" + id;
    var token = $('#token').val();

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