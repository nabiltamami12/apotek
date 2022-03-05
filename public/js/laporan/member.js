$(document).ready(function() {
    $('#dataTableBuilder').DataTable({
        responsive: true,
        'ajax': {
            'url': '/laporan/members',
        },

        'columnDefs': [
            {
                'targets':0,
                'sClass': "text-center col-md-2"
            },{
                'targets':1,
                'sClass': "col-md-3"
            },{
                'targets':2,
                'sClass': "col-md-1 text-center"
            },{
                'targets':3,
                'sClass': "col-md-2 text-center"
            },{
                'targets':4,
                'sClass': "text-center col-md-4",
            }
        ]
    });
});

$('#formcetak').on('submit', function (e) {
    var table = $('#dataTableBuilder').DataTable();
        if ( ! table.data().count() ) {
            alert( 'Tidak ada data yang akan dicetak !!' );
            return false;
        }
    });