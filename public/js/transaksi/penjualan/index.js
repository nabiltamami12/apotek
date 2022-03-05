$(document).ready(function() {
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    var todayDate = new Date();
    
    $("#start").datepicker("setDate", todayDate);
    $("#end").datepicker("setDate", todayDate);

    var route = "/cekhakakses/ubah_penjualan";
    var bolehUbah;
    $.get(route, function (res) {
        bolehUbah = res;
    });

    var route1 = "/cekhakakses/hapus_penjualan";
    var bolehHapus;
    $.get(route1, function (res) {
        bolehHapus = res;
    });

    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/penjualans',
            'data': function (d) {
                d.start = $('#start').val();
                d.end = $('#end').val();
            }
        },

        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-2"
            },{
                'targets':1,
                'sClass': "text-center col-md-2"
            },{
                'targets':2,
                'sClass': "text-right col-md-2",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets':3,
                'sClass': "text-center col-md-2"
            },{
                'targets':4,
                'sClass': "text-center col-md-1"
            },{
                'targets': 5,
                'searchable': false,
                "orderable": false,
                "orderData": false,
                "orderDataType": false,
                "orderSequence": false,
                "sClass": "text-center col-md-3 td-aksi",
                'render': function (data, type, full, meta) {
                    var kembali = '';
                    kembali += '<a title="Lihat Transaksi" class="btn btn-info btn-flat" href="/penjualan/'+data+'"><i class="fa fa-eye fa-fw"></i> </a>';
                    kembali += '<button title="Cetak Struk Jual Recta" class="btn btn-default btn-flat" onclick="CetakClick(this)"><i class="fa fa-print fa-fw"></i> </button>';
                    kembali += '<a title="Cetak Struk Jual" class="btn btn-info btn-flat" target="_blnak"  href="/strukcetak/'+data+'"><i class="fa fa-print fa-fw"></i> </a>';
                    if (bolehUbah == true) {
                        kembali += '<a title="Koreksi Transaksi" class="btn btn-warning btn-flat" href="#" onclick="UbahClick('+data+');"><i class="fa fa-pencil-square-o fa-fw"></i> </a>';
                    }
                    if (bolehHapus == true) {
                        kembali += '<button title="Hapus Data" class="btn btn-danger btn-flat" data-toggle="modal" data-target="#modalHapus" onclick="HapusClick(this);"><i class="fa fa-trash fa-fw"></i> </button>';
                    }

                    return kembali;

                }
            }
        ],
        'rowCallback': function (row, data, dataIndex) {
            if (bolehHapus == true) {
                $(row).find('button[class="btn btn-danger btn-flat"]').prop('value', data[5]);
            }

            // if (bolehUbah == true) {
                $(row).find('button[class="btn btn-default btn-flat"]').prop('value', data[0]);
            // }

        }
    });

    $('#start').on('change', function (e) {
        reloadTable();
    });
    $('#end').on('change', function (e) {
        reloadTable();
    });
});

function CetakClick_old(id) {
    $.get('/strukjual/'+id.value, function(res) {
    });
}

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

// function Cetakpdf(kode) {
//     $.get('/strukcetak/'+kode.value, function(res) {
//     });
//     console.log("print");
// }

function UbahClick(id) {
        var route = "/siapkankoreksipenjualan";
        var token = $('#token').val();

        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
                id: id,
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
                window.location.href = '/penjualan/' + id + '/edit';
            }
        });
}

function UbahClick(id) {
        var route = "/siapkankoreksipenjualan";
        var token = $('#token').val();

        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
                id: id,
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
                window.location.href = '/penjualan/' + id + '/edit';
            }
        });
}

function HapusClick(btn) {
    $('#idHapus').val(btn.value);
}

$('#yakinhapus').click(function () {
    var token = $('#token').val();
    var id = $('#idHapus').val();
    var route = "/penjualan/" + id;

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
            alert('Sukses Menghapus Transaksi Penjualan');
            $('#modalHapus').modal('toggle');
        }
    });
});