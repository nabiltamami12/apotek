
$(document).ready(function() {
    var table = $('#dataTableBuilder').DataTable({
        ordering: false,
        searching:false,
        paging: false,
        responsive: true,
        info:false,
        'ajax': {
            'url': '/getsementara',
            'data': function (d) {
                d.kode = $('#infokode').val();
            }
        },
        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-2",
            },{
                'targets':1,
                'sClass': "col-md-3",
            }, {
                'targets':2,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');
                }
            },{
                'targets':3,
                'sClass': "text-right col-md-2",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');
                }
            },{
                'targets':4,
                'sClass': "text-right col-md-2",
                'render': function (data, type, full, meta) {
                    // return number_format(intVal(data), 0, ',', '.');
                    return number_format(intVal(data), 0, ',', '.');
                }
            },{
                'targets': 5,
                'searchable': false,
                "orderable": false,
                "orderData": false,
                "orderDataType": false,
                "orderSequence": false,
                "sClass": "text-center col-md-2 td-aksi",
                'render': function (data, type, full, meta) {
                    var kembali = '<button title="Ubah Data" class="btn btn-warning btn-flat" data-toggle="modal" data-target="#modalUbah" onclick="UbahClick(this);"><i class="fa fa-edit fa-fw"></i> </button>';
                    kembali += '<button title="Hapus Item" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modalHapus" onclick="HapusClick(this);"><i class="fa fa-trash fa-fw"></i> </button>';

                    return kembali;
                }
            }
        ],
        'rowCallback': function (row, data, dataIndex) {
            $(row).find('button[class="btn btn-warning btn-flat"]').prop('value', data[5]);
            $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[5]);
        },
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
            if (data.length > 0) {
                total = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        // console.log(a);
                        return intVal(a) + intVal(b);
                    } );

                // Update footer
                $('#tempTotal').val(total);

                $( api.column( 1 ).footer() ).html(
                    //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                    'Rp '+ number_format(total, 0, ',', '.')  +''
                );

                loadTotalBayar();
            } else {
                $('#tempTotal').val('0');
                $( api.column(1).footer() ).html(
                   //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                   'Rp 0'
                );

                loadTotalBayar();
            }
        },
    });

    document.getElementById("barang").maxLength = 7;
    document.getElementById("qty").maxLength = 5;
    document.getElementById("qtyubah").maxLength = 5;

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

        loadTotal();
        loadTotalBayar();
    });

    $('#barangasli').val(null);

    var timer;

    $('#barang').on('keydown', function(evt) {
        evt = (evt) ? evt : window.event;
        var charCode = (evt.which) ? evt.which : evt.keyCode;
        if (charCode == 13) {
            clearTimeout(timer);
        }
    }).on('keyup', function(e) {
        timer = setTimeout(function () {
            //alert('disini');
            var keywords = $('#barang').val();
            var kodetransaksi = $('#kode').val();

            if (keywords.length > 0) {

                $.get('/findbarang/kode/' + keywords + '/' + kodetransaksi, function(res) {
                    if (res.nama == null) {
                        $('#barangasli').val(null);
                        $('#harga_jual').val(null);
                        $('#stok').val(null);
                        $('#nama').val('Tidak ditemukan');
                    } else {
                        $('#barangasli').val(res.kode);

                        $('#stok').val(number_format(res.stok, 0, ',', '.'));
                        $('#namabarang').val(res.nama);

                        var member = $('#infomember').val();
                        if (member == undefined || jQuery.trim(member) == '') {
                            $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                        } else {
                            var levelmember = $('#infolevel').val();
                            if (levelmember == '1') {
                                $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                            } else if (levelmember == '2') {
                                $('#harga_jual').val(number_format(res.harga_jual_2, 0, ',', '.'));
                            } else if (levelmember == '3') {
                                $('#harga_jual').val(number_format(res.harga_jual_3, 0, ',', '.'));
                            } else {
                                $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                            }
                        }

                        loadTotal();
                    }
                });
            }
        }, 500);
    });


    $('#dataTableBuilderCari').DataTable({
        responsive: true,
        'ajax': {
            'url': '/barangpenjualankoreksi',
            'data': function (d) {
                d.kode = $('#infokode').val();
                d.member = $('#infomember').val();
            }
        },
        'columnDefs': [
        {
            'targets':0,
            'sClass': "text-center col-lg-2"
        }, {
            'targets':1,
            'sClass': "col-lg-3"
        },{
            'targets':2,
            'sClass': "col-lg-2"
        },{
            'targets':3,
            'sClass': "col-lg-2",'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
        },{
            'targets':4,
            'sClass': "text-center col-lg-1",
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
            "sClass": "text-center col-lg-2 td-aksi",
            'render': function (data, type, full, meta) {
                var kembali = '';

                kembali += '<button title="Pilih Data" class="btn btn-success btn-flat" onclick="PilihClick(this);"><i class="fa fa-hand-pointer-o fa-fw"></i> </button>';


                return kembali;

            }
        }],
        'rowCallback': function (row, data, dataIndex) {
            $(row).find('button[class="btn btn-success btn-flat"]').prop('value', data[5]);
        }
    });


    $('#caribarang').click(function() {
        reloadTableCari();
    });

    var routemember = "/get_select_member";
    var inputTipe = $('#infomember');

    var list = document.getElementById("infomember");
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    inputTipe.append('<option value=" ">Penjualan Umum</option>');

    $.get(routemember, function (res) {
        // console.log(res);
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[1] + '">' + value[0] + '</option>');
        });

        $('#infomember').val($('#tempMember').val()).trigger('change');
    });

    $("#infomember").select2();

    $('#infomember').change(function(e) {
        var nilaimember = $('#infomember').val();

        if (nilaimember == undefined || jQuery.trim(nilaimember) == '') {
            $('#infolevel').val('Tidak ada');
            $('#infonama').val('Tidak ada');
            $('#infoalamat').val('Tidak ada');
            $('#infohp').val('Tidak ada');
        } else {
            $.get('/getinfomember/' + nilaimember, function(res) {
                if (res != null) {
                    $('#infolevel').val(res.level);
                    $('#infonama').val(res.nama);
                    $('#infoalamat').val(res.alamat);
                    $('#infohp').val(res.gsm);
                } else {
                    $('#infolevel').val('Tidak ada');
                    $('#infonama').val('Tidak ada');
                    $('#infoalamat').val('Tidak ada');
                    $('#infohp').val('Tidak ada');
                }
            });
        }
    });


    // tambah member

    $('#tambahmemberbaru').click(function(){
        $('#kode').val(null);
        $('#nama').val(null);
        $('#level').val(' ').trigger('change');
        $('#gsm').val(null);
        $('#alamat').val(null);

        $('#kode').focus();
    });

    $("#level").select2();

    document.getElementById("kode").maxLength = 7;
    document.getElementById("nama").maxLength = 100;
    document.getElementById("gsm").maxLength = 15;
    document.getElementById("alamat").maxLength = 200;
    // tambah member - end

    $('#qty').val('1');

    $('#barang').focus();
});

function reloadDataMember() {
    var routemember = "/get_select_member";
    var inputTipe = $('#infomember');

    var list = document.getElementById("infomember");
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    inputTipe.append('<option value=" ">Penjualan Umum</option>');

    $.get(routemember, function (res) {
        // console.log(res);
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[1] + '">' + value[0] + '</option>');
        });
    });
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
            reloadDataMember();
            alert('Sukses Menyimpan Data Member');
            $('#modalTambahMember').modal('toggle');
        }
    });
});

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function reloadTableCari() {
    var table = $('#dataTableBuilderCari').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function PilihClick(btn) {
    route = "/barangfindkoreksi/" + btn.value + "/" + $('#infokode').val();

    $.get(route, function (res) {
        $('#barangasli').val(res.kode);
        $('#barang').val(res.kode);
        $('#nama').val(res.nama);
        var member = $('#infomember').val();
                        if (member == undefined || jQuery.trim(member) == '') {
                            $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                        } else {
                            var levelmember = $('#infolevel').val();
                            if (levelmember == '1') {
                                $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                            } else if (levelmember == '2') {
                                $('#harga_jual').val(number_format(res.harga_jual_2, 0, ',', '.'));
                            } else if (levelmember == '3') {
                                $('#harga_jual').val(number_format(res.harga_jual_3, 0, ',', '.'));
                            } else {
                                $('#harga_jual').val(number_format(res.harga_jual_1, 0, ',', '.'));
                            }
                        }
        $('#stok').val(number_format(res.stok, 0, ',', '.'));
        $('#qty').val('1');

        $('#barang').focus();

        $('#modalCari').modal('toggle');

        loadTotal();

    });
}

function loadTotal() {
    var qty = $('#qty').val();
    var harga = $('#harga_jual').val();
    $('#total').val(null);

    if (qty != undefined && jQuery.trim(qty) != '' && intVal(qty) > 0 && harga != undefined && jQuery.trim(harga) != '' && intVal(harga) > 0) {
        var total = intVal(qty) * intVal(harga);
        $('#total').val(number_format(total, 0, ',', '.'));    
    }

    var qty1 = $('#qtyubah').val();
    var harga1 = $('#harga_jualubah').val();
    $('#totalubah').val(null);

    if (qty1 != undefined && jQuery.trim(qty1) != '' && intVal(qty1) > 0 && harga1 != undefined && jQuery.trim(harga1) != '' && intVal(harga1) > 0) {
        var total1 = intVal(qty1) * intVal(harga1);
        $('#totalubah').val(number_format(total1, 0, ',', '.'));    
    }
}

function loadTotalBayar() {
    var bayarnilai = $('#bayar').val();
    var bayartotal = $('#tempTotal').val();
    $('#kembali').val(number_format($('#tempTotal').val(), 0, ',', '.'));

    if (bayartotal != undefined && jQuery.trim(bayartotal) != '' && intVal(bayartotal) > 0 && bayarnilai != undefined && jQuery.trim(bayarnilai) != '' && intVal(bayarnilai) > 0) {
        var kembali = intVal(bayarnilai) - intVal(bayartotal);
        $('#kembali').val(number_format(kembali, 0, ',', '.'));    
    }
}

$('#tambahbaris').click(function() {

    var kode = $('#infokode').val();
    if (jQuery.trim(kode) == '' || kode == undefined) {
            alert("Kode tidak valid!");
            window.location.href = '/penjualan';
            return;
        }

        var route = "/sementarajualkoreksi";
        var token = $('#token').val();

        var barang = $('#barangasli').val();
        if (jQuery.trim(barang) == '' || barang == undefined) {
            alert('Kode barang tidak boleh dikosongkan');
            $('#barang').focus();
            return;
        }

        var stok = $('#stok').val();
        if (jQuery.trim(stok) == '' || stok == ' ' || intVal(stok) <= 0) {
            alert('Stok barang tidak valid');
            $('#qty').focus();
            return;
        }

        var qty = $('#qty').val();
        if (jQuery.trim(qty) == '' || qty == ' ' || intVal(qty) <= 0) {
            alert('QTY penjualan tidak valid');
            $('#qty').focus();
            return;
        }

        var harga = $('#harga_jual').val();
        if (jQuery.trim(harga) == '' || harga == ' ' || intVal(harga) <= 0) {
            alert('Harga jual penjualan tidak valid');
            $('#harga_jual').focus();
            return;
        }

        harga = intVal(harga);

        stok = intVal(stok);
        qty = intVal(qty);

        // console.log('stok : ' + stok + ', qty : ' + qty);

        if (stok < qty) {
            alert('Stok barang tidak mencukupi !');
            $('#qty').focus();
            return;
        }

        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
               barang : barang,
                kode : kode,
                qty : qty,
                harga: harga,
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

                $('#barang').val(null);
                $('#barangasli').val(null);
                $('#nama').val(null);
                $('#harga_jual').val(null);
                $('#total').val(null);
                $('#stok').val(null);
                $('#qty').val('1');

                $('#barang').focus();
            }
        });
});


function HapusClick(btn) {
    $('#idHapus').val(btn.value);
}

$('#yakinhapus').click(function () {
    var token = $('#token').val();
    var id = $('#idHapus').val();
    var route = "/sementara/" + id;

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
            $('#modalHapus').modal('toggle');
        }
    });
});

function UbahClick(btn) {
    route = "/sementarakoreksi/" + btn.value + "/edit";

    $.get(route, function (res) {
        $('#idubah').val(res.id);
        $('#barangubah').val(res.barang);
        $('#namaubah').val(res.nama);
        $('#stokubah').val(number_format(intVal(res.stok), 0, ',', '.'));
        $('#harga_jualubah').val(number_format(intVal(res.harga), 0, ',', '.'));
        $('#qtyubah').val(number_format(intVal(res.jumlah), 0, ',', '.'));
        $('#totalubah').val(number_format(intVal(res.total), 0, ',', '.'));

        $('#qtyubah').focus();

    });

}

$('#simpanubah').click(function () {
    var id = $('#idubah').val();
    var token = $('#token').val();
    var route = "/sementara/" + id;

    var qty = $('#qtyubah').val();
        var stok = $('#stokubah').val();
        if (jQuery.trim(stok) == '' || stok == ' ' || intVal(stok) <= 0) {
            alert('Stok barang tidak valid');
            $('#qtyubah').focus();
            return;
        }

        if (jQuery.trim(qty) == '' || qty == ' ' || intVal(qty) <= 0) {
            alert('QTY penjualan tidak valid');
            $('#qtyubah').focus();
            return;
        }

        stok = intVal(stok);
        qty = intVal(qty);

        if (stok < qty) {
            alert('Stok barang tidak cukup !!');
            $('#qtyubah').focus();
            return;
        }

        var harga = $('#harga_jualubah').val();
        if (jQuery.trim(harga) == '' || harga == ' ' || intVal(harga) <= 0) {
            alert('Harga barang tidak valid');
            $('#harga_jualubah').focus();
            return;
        }

        harga = intVal(harga);

    $.ajax({
        url: route,
        headers: {'X-CSRF-TOKEN': token},
        type: 'PUT',
        dataType: 'json',
        data: {
            qty : qty,
            harga: harga,
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
            $('#modalUbah').modal('toggle');
        }
    });
});

$('#simpan').click(function () {
    var kode = $('#infokode').val();
    if (jQuery.trim(kode) == '' || kode == undefined) {
            alert("No. Bukti tidak valid!");
            window.location.href = '/penjualan';
            return;
        }

    var kembali = $('#kembali').val();
    if (jQuery.trim(kembali) == '' || kembali == undefined || intVal(kembali) < 0) {
        alert('Inputkan nilai pembayaran dengan benar !');
        return;
    }

    var bayar = $('#bayar').val();
    if (jQuery.trim(bayar) == '' || bayar == undefined || intVal(bayar) < 0) {
        alert('Inputkan nilai pembayaran dengan benar !');
        $('#bayar').focus();
        return;
    }
    bayar = intVal(bayar);
        
        var table = $('#dataTableBuilder').DataTable();
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data detail penjualan di tabel !!' );
            return;
        }

        var member = $('#infomember').val();
        if (member == undefined) {
            member = '';
        }

        var catatan = $('#catatan').val();
        if (catatan == undefined) {
            catatan = '';
        }

        var id = $('#idubahsekali').val();
        var token = $('#token').val();
        var route = "/penjualan/" + id;

        $.ajax({
            url: route,
            headers: {'X-CSRF-TOKEN': token},
            type: 'PUT',
            dataType: 'json',
            data: {
                kode: kode,
                bayar: bayar,
                member: member,
                catatan: catatan,
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
                $('#modalBayar').modal('toggle');
                alert('Sukses Melakukan Koreksi Transaksi Penjualan !!');
                window.location.href = '/penjualan';
            }
        });
});