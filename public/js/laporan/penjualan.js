$(document).ready(function() {
    var route = "/get_select_member";
    var inputTipe = $('#member');

    var list = document.getElementById("member");
    while (list.hasChildNodes()) {
        list.removeChild(list.firstChild);
    }
    inputTipe.append('<option value=" ">Member Umum</option>');

    $.get(route, function (res) {
        $.each(res.data, function (index, value) {
            inputTipe.append('<option value="' + value[1] + '">' + value[0] + '</option>');
        });
    });

    $("#member").select2();

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
            'url': '/laporan/penjualans',
            'data': function (d) {
                d.start = $('#start').val();
                d.end = $('#end').val();
                d.member = $('#member').val();
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
                'sClass': "col-md-2"
            },{
                'targets':3,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets':4,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets':5,
                'sClass': "text-right col-md-1",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');

                }
            },{
                'targets':6,
                'sClass': "text-center col-md-1"
            },{
                'targets':7,
                'sClass': "col-md-2"
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
            if (data.length > 0) {
                total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        // console.log(a);
                        return intVal(a) + intVal(b);
                    } );
                total1 = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        // console.log(a);
                        return intVal(a) + intVal(b);
                    } );

                // Update footer

                $( api.column( 3 ).footer() ).html(
                    //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                    number_format(total, 0, ',', '.')
                );
                $( api.column( 4 ).footer() ).html(
                    //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                    number_format(total1, 0, ',', '.')
                );
            } else {
                $( api.column(3).footer() ).html(
                   //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                   '0'
                );
                $( api.column(4).footer() ).html(
                   //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                   '0'
                );
                $( api.column(5).footer() ).html(
                   //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                   '0'
                );
            }
        },
    });
    $('#start').on('change', function (e) {
        reloadTable();
    });
    $('#end').on('change', function (e) {
        reloadTable();
    });

    $('#member').on('change', function (e) {
        reloadTable();
    });

    $('#formcetak').on('submit', function (e) {
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }

        var start = $('#start').val();
        var end = $('#end').val();
        var member = $('#member').val();

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
                .attr('name', 'member')
                .val(member)
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
        var member = $('#member').val();

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
                .attr('name', 'member')
                .val(member)
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