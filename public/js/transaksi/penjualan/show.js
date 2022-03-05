$(document).ready(function() {
    $('#dataTableBuilder').DataTable({
        ordering: false,
        searching:false,
        paging: false,
        responsive: true,
        info:false,
        'ajax': {
            'url': '/getdetailjual',
            'data': function (d) {
                d.kode = $('#kode').val();
            }
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
            }
        ],
        "footerCallback": function (row, data, start, end, display) {
            var api = this.api(), data;
            if (data.length > 0) {
                // Remove the formatting to get integer data for summation
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                    i.replace(/[\$Rp,.]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };

                // Total over all pages

                total = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    } );

                // // Total over this page
                // pageTotal = api
                //     .column( 3, { page: 'current'} )
                //     .data()
                //     .reduce( function (a, b) {
                //         return intVal(a) + intVal(b);
                //     }, 0 );

                // Update footer
                $( api.column( 0 ).footer() ).html(
                    //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                    'Rp '+ number_format(total, 0, ',', '.')  +''
                );
            } else {
                $( api.column(0).footer() ).html(
                   //'Rp '+ numberfo pageTotal +' dari total Rp '+ total +''
                   'Rp 0'
                );
            }
        },
    });

});