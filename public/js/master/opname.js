$(document).ready(function() {
    $('#dataTableBuilderCari').DataTable({
        responsive: true,
        'ajax': {
            'url': '/barangs',
        },
        'columnDefs': [
        {
            'targets':0,
            'sClass': "text-center col-lg-2"
        }, {
            'targets':1,
            'sClass': "text-center col-lg-2"
        }, {
            'targets':2,
            'sClass': "col-lg-3"
        },{
            'targets':3,
            'sClass': "col-lg-2"
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

    document.getElementById("stok_nyata").maxLength = 15;
    document.getElementById("keterangan").maxLength = 150;

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

        loadSelisih();
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

            if (keywords.length > 0) {

                $.get('/findbarang/kode/' + keywords, function(res) {
                    if (res.nama == null) {
                        $('#barangasli').val(null);
                        $('#nama').val('Barang tidak ditemukan');
                        $('#stok_komputer').val(null);
                    } else {
                        $('#barangasli').val(res.kode);
                        $('#nama').val(res.nama);
                        $('#stok_komputer').val(number_format(res.stok, 0, ',', '.'));
                    }

                    loadSelisih();
                });
            } else {
                 $('#barangasli').val(null);
                 $('#nama').val(null);
                 $('#stok_komputer').val(null);
            }
        }, 500);
    });


    $('#caribarang').click(function() {
        reloadTableCari();
    });

    kodeOtomatis();

    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    $('.inputantgl').datepicker({
        format: "mm/dd/yyyy",
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    $(".inputantgl").datepicker("setDate", new Date());
});

function reloadTableCari() {
    var table = $('#dataTableBuilderCari').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function kodeOtomatis() {
    var thi = new Date();
    $('#kode').val('OP' + thi.toString('yyMMddHHmmss'));
}

function PilihClick(btn) {
    route = "/findbarang/id/" + btn.value;

    $.get(route, function (res) {
        $('#barangasli').val(res.kode);
        $('#barang').val(res.kode);
        $('#nama').val(res.nama);
        $('#stok_komputer').val(number_format(res.stok, 0, ',', '.'));

        $('#barang').focus();

        $('#modalCari').modal('toggle');

        loadSelisih();

    });
}

function loadSelisih() {
    var stok_komputer = $('#stok_komputer').val();
    var stok_nyata = $('#stok_nyata').val();
    $('#selisih').val(null);

    if (stok_komputer != undefined && jQuery.trim(stok_komputer) != '' && intVal(stok_komputer) >= 0 && stok_nyata != undefined && jQuery.trim(stok_nyata) != '' && intVal(stok_nyata) >= 0) {
        var selisih = intVal(stok_nyata) - intVal(stok_komputer);
        $('#selisih').val(number_format(selisih, 0, ',', '.'));    
    }
}

$('#simpan').click(function () {
    var token = $('#token').val();

    var kode = $("#kode").val();
    if (kode == undefined || jQuery.trim(kode) == '') {
        alert('No. bukti tidak benar ! Refresh page!');
        return;
    }

    var tgl = $("#tgl").val();
    if (jQuery.trim(tgl) == '' || tgl==' ' || tgl == undefined) {
        alert('Tanggal stok opname tidak benar !');
        $('#tgl').focus();
        return;
    }

    var barang = $('#barangasli').val();
    if (jQuery.trim(barang) == '' || barang == undefined) {
        alert('Barang tidak valid!');
        $('#barang').focus();
        return;
    }

    var stok_komputer = $('#stok_komputer').val();
    if (jQuery.trim(stok_komputer) == '' || stok_komputer == undefined || intVal(stok_komputer) < 0) {
        alert('Inputkan stok komputer dengan benar !');
        return;
    }
    stok_komputer = intVal(stok_komputer);

    var stok_nyata = $('#stok_nyata').val();
    if (jQuery.trim(stok_nyata) == '' || stok_nyata == undefined || intVal(stok_nyata) < 0) {
        alert('Inputan stok nyata tidak benar !');
        return;
    }
    stok_komputer = intVal(stok_komputer);

    loadSelisih();

    var selisih = $('#selisih').val();
    if (jQuery.trim(selisih) == '' || selisih == undefined) {
        alert('Selisih tidak benar! Silahkan refresh page!');
        return;
    }
    selisih = intVal(selisih);

    var keterangan = $('#keterangan').val();
    if (keterangan == undefined) {
        keterangan = '';
    }

    $.ajax({
        url: '/opname',
        headers: {'X-CSRF-TOKEN': token},
        type: 'POST',
        dataType: 'json',
        data: {
            kode: kode,
                tgl : tgl,
                barang: barang,
                stok_nyata : stok_nyata,
                stok_komputer : stok_komputer,
                selisih: selisih,
                keterangan: keterangan,
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
            alert('Sukses menyimpan opname stok barang !!');

                kodeOtomatis();

                $('#barang').val(null);
                $('#barangasli').val(null);
                $('#nama').val(null);
                $('#stok_komputer').val(null);
                $('#stok_nyata').val(null);
                $('#selisih').val(null);
                $(".inputantgl").datepicker("setDate", new Date());
                $('#keterangan').val(null);

                $('#barang').focus();
        }
    });
});