$(document).ready(function() {
	route = "/getcountdashboard";

    $.get(route, function (res) {

        $('#infoc-member').html(number_format(res.member, 0, ',', '.'));
        $('#infoc-penjualan').html(number_format(res.penjualan, 0, ',', '.'));
        $('#infoc-pembelian').html(number_format(res.pembelian, 0, ',', '.'));
        $('#infoc-barang').html(number_format(res.barang, 0, ',', '.'));
    });

    $('#dataTableMenguntungkan').DataTable({
        responsive: true,
        ordering: false,
        'ajax': {
            'url': '/menguntungkan',
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
                'sClass': "col-md-7"
            },{
                'targets':3,
                'sClass': "col-md-7"
            },{
                'targets':4,
                'sClass': "col-md-1 text-right",
                'render': function (data, type, full, meta) {
                    return number_format(intVal(data), 0, ',', '.');
                }
            }
        ]
    });

    $('#dataTableHabis').DataTable({
        responsive: true,
        'ajax': {
            'url': '/daftarhabis',
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
                'sClass': "col-md-5"
            },{
                'targets':3,
                'sClass': "col-md-3"
            }
        ]
    });
});

function reloadTableMenguntungkan() {
    var table = $('#dataTableMenguntungkan').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}

function reloadTableHabis() {
    var table = $('#dataTableHabis').dataTable();
    table.cleanData;
    table.api().ajax.reload();
}