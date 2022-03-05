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

    
    $('#start').on('change', function (e) {
        reloadRekap();
    });
    $('#end').on('change', function (e) {
        reloadRekap();
    });

    $('#jenis').on('change', function (e) {
        reloadRekap();
    });

    $('#formcetak').on('submit', function (e) {

        var start = $('#start').val();
        var end = $('#end').val();
        var jenis = $('#jenis').val();

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
                .attr('name', 'jenis')
                .val(jenis)
        );
    });

    reloadRekap();
});

function reloadRekap() {
    var start = $('#start').val();
        var end = $('#end').val();
        var jenis = $('#jenis').val();
    var token = $('#token').val();

    $.ajax({
        url: '/laporan/getrekaplaba',
        type: 'GET',
        headers: {'X-CSRF-TOKEN': token},
        dataType: 'json',
        data: {
            start: start,
            end: end,
            jenis: jenis,
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
        success: function (res) {
            var penjualan = 0;

            if (res.penjualan != null && jQuery.trim(res.penjualan) != '') {
                penjualan = intVal(res.penjualan)
            } 

            
            var pembelian = 0;
            if (res.pembelian != null && jQuery.trim(res.pembelian) != '') {
                pembelian = intVal(res.pembelian)
            }

            var pendapatan = penjualan ;
            var pengeluaran = pembelian;
            var grandtotal = pendapatan - pengeluaran;

            $('#totalpenjualan').html( number_format(intVal(penjualan), 0, ',', '.') );
            $('#totalpendapatan').html('<strong>' +  number_format(intVal(pendapatan), 0, ',', '.')  + '</strong>');

            $('#totalpembelian').html( number_format(intVal(pembelian), 0, ',', '.') );
            $('#totalpengeluaran').html('<strong>' +  number_format(intVal(pengeluaran), 0, ',', '.')  + '</strong>');

            $('#grandtotal').html('<strong>' + number_format(intVal(grandtotal), 0, ',', '.') + '</strong>');
        }
    });
}