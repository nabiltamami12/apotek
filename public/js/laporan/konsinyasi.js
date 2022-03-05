$(document).ready(function() {
	var route = "/cekhakakses/cetak_suplier";
    var bolehCetak;
    $.get(route, function (res) { 
        bolehCetak = res;
    });
	
	
    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/laporan/konsinyasis',			
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
                    
                    if (bolehCetak == true) {
                        kembali += '<a title="Cetak Laporan Konsinyasi"  class="btn btn-warning btn-flat" "><i class="fa fa-print fa-fw"></i> </a>';
                    }

                    return kembali;

                }
            }
        ],
        'rowCallback': function (row, data, dataIndex) {
            if (bolehCetak == true) {
                $(row).find('a[class="btn btn-warning btn-flat"]').prop('value', data[8]);
                $(row).find('a[class="btn btn-warning btn-flat"]').attr('href', '/laporan/rekapkonsinyasi/'+data[8]);
            }
            if (data[7] == '1') {
                $(row).find('input[type="checkbox"]').prop('checked', true);
                $(row).addClass('selected');    
            }

        }
    });
	
});

$('#formcetak').on('submit', function (e) {
    var table = $('#dataTableBuilder').DataTable();
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }
    });