$(document).ready(function() {
    var route = "/jenises";
    var inputTipe = $('#jenis');

    var list = document.getElementById("jenis");
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    inputTipe.append('<option value=" ">Semua Jenis Barang</option>');

    $.get(route, function (res) {
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[1] + '">' + value[0] + '</option>');
        });
    });

    $("#jenis").select2();


    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/laporan/barangs',
            'data': function (d) {
                d.jenis = $('#jenis').val();
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
                'sClass': "col-md-4"
            },{
                'targets':3,
                'sClass': "col-md-3"
            },{
                'targets':4,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            }
        ]
    });

    $('#jenis').on('change', function (e) {
        reloadTable();
    });
});

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

$('#formcetak').on('submit', function (e) {
    var table = $('#dataTableBuilder').DataTable();
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }

        var jenis = $('#jenis').val();

        var form = this;

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'jenis')
                .val(jenis)
        );
    });