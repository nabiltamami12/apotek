$(document).ajaxStart(function() {
    Pace.restart();
});

$(document).ready(function() {

	setInterval(function() {
		$('#datawaktu').html(new Date().toString('dddd, dd MMMM yyyy  HH:mm:ss'))
	}, 1000);


    document.getElementById("password-lama").maxLength = 50;
    document.getElementById("validate_password").maxLength = 50;
    document.getElementById("password-baru").maxLength = 50;

    $('#simpanpassword').click(function() {
        var route = "/change_password";
        var token = $('#token').val();

        var passwordlama = $('#password-lama').val();
        if (passwordlama == '' || passwordlama == undefined) {
            alert('Password lama tidak boleh kosong');
            $('#password-lama').focus();
            return;
        }

        var passwordbaru = $('#password-baru').val();
        if (passwordbaru == '' || passwordbaru == undefined) {
            alert('Password baru tidak boleh kosong');
            $('#password-baru').focus();
            return;
        }

        var validate_password = $('#validate_password').val();
        if (validate_password == '' || validate_password == undefined) {
            alert('Silahkan melakukan validasi password baru !!!');
            $('#validate_password').focus();
            return;
        }

        if (validate_password != passwordbaru) {
            alert('Validasi password baru tidak cocok !!!');
            $('#validate_password').val('');
            $('#validate_password').focus();
            return;
        }

        $.ajax({
            url: route,
            type: 'POST',
            headers: {'X-CSRF-TOKEN': token},
            dataType: 'json',
            data: {
                passwordbaru : passwordbaru,
                passwordlama : passwordlama,
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
                alert('Sukses mengubah password user');
                window.location.href = "/";
            }
        });
    });
});

function formatNomorTelepon(teks) {
    var kata = teks.toString().trim();
    kata = (kata + '').replace(/[- ]/g, '');

    var kembali = '';
    if (kata.length > 4) {
        var cacah = 0;
        for (var i = 0; i < kata.length; i++) {
            if (cacah < 4) {
                kembali += kata[i];
                cacah++;
            } else {
                kembali += "-" + kata[i];
                cacah = 1;
            }
        }
    } else {
        kembali = kata;
    }

    return kembali;
}

//$(document).ready(function () {
//    console.log(formatNomorTelepon("  085-3-4564-56-45  "));
//});

function validasiAngka(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
}

function validasihuruf(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return true;
    }
    return false;
}

function number_format(number, decimals, dec_point, thousands_sep) {

    number = (number + '')
        .replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + (Math.round(n * k) / k)
                    .toFixed(prec);
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
        .split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '')
            .length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1)
            .join('0');
    }
    return s.join(dec);
}

function intVal(i) {
    return typeof i === 'string' ?
    i.replace(/[\$,.]/g, '') * 1 :
        typeof i === 'number' ?
            i : 0;
};

// memformat angka ribuan
function formatRibuan(angka) {
    if (typeof(angka) != 'string') angka = angka.toString();
    var reg = new RegExp('([0-9]+)([0-9]{3})');
    while(reg.test(angka)) angka = angka.replace(reg, '$1.$2');
    return angka;
}

function getNilaiPembulatan(nilai, pembulat)
{
    var hasil = (Math.ceil(parseInt(intVal(nilai))) % parseInt(intVal(pembulat)) == 0) ? Math.ceil(parseInt(intVal(nilai))) : Math.round((parseInt(intVal(nilai)) + parseInt( intVal(pembulat) ) / 2 ) / parseInt(intVal(pembulat))) * parseInt( intVal(pembulat));
    // console.log(hasil);
    return hasil;
}

function randomPassword(length) {
    var randomstring = Math.random().toString(36).slice(length * -1);
    return randomstring;
}