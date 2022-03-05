$(document).ready(function() {
    var container=$('.bootstrap-iso form').length>0 ? $('.bootstrap-iso form').parent() : "body";

    $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        container: container,
        todayHighlight: true,
        autoclose: true,
    });

    var fd = Date.today().clearTime().moveToFirstDayOfMonth();
    // var firstday = fd.toString("MM/dd/yyyy");
    var ld = Date.today().clearTime().moveToLastDayOfMonth();
    // var lastday = ld.toString("MM/dd/yyyy");
    
    $("#start").datepicker("setDate", fd);
    $("#end").datepicker("setDate", ld);


    var table = $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/laporan/pembelians',
            'data': function (d) {
                d.start = $('#start').val();
                d.end = $('#end').val();
            }
        },

        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-3"
            },{
                'targets':1,
                'sClass': "text-center col-md-2"
            },{
                'targets':2,
                'sClass': "text-right col-md-3",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets':3,
                'sClass': "text-center col-md-4"
            }
        ]
    });
    $('#start').on('change', function (e) {
        reloadTable();
    });
    $('#end').on('change', function (e) {
        reloadTable();
    });

    $('#formcetak').on('submit', function (e) {
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }

        var start = $('#start').val();
        var end = $('#end').val();

        var form = this;

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'start')
                .val(start)
        );

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'end')
                .val(end)
        );

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'lap')
                .val('semua')
        );
    });

    $('#formcetakdetail').on('submit', function (e) {
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }

        var start = $('#start').val();
        var end = $('#end').val();

        var form = this;

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'start')
                .val(start)
        );

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'end')
                .val(end)
        );

        $(form).append(
            $('<input>')
                .attr('type', 'hidden')
                .attr('name', 'lap')
                .val('detail')
        );
    });

});

function reloadTable() {
    var table = $('#dataTableBuilder').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}