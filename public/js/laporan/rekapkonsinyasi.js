$(document).ready(function() {
	var route = "/cekhakakses/cetak_suplier";
    var bolehCetak;
    $.get(route, function (res) { 
        bolehCetak = res;
    });
	
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
});

$('#formcetakkonsinyasi').on('submit', function (e) { 
       

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

    }); 

$('#formcetakkonsinyasiforsuplier').on('submit', function (e) { 
       

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

    }); 
