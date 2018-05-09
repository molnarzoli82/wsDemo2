
$(document).ready(function () {

    $('form').on('submit', function (e) {

        e.preventDefault();

        $.post('controller.php', $('form').serialize(), function (html) {

        }).done(function (html) {
            alert('Az űrlap adatai rögzítve');

            $(':input', '#urlap')
                    .not(':button, :submit, :reset, :hidden')
                    .val('')
                    .removeAttr('checked')
                    .removeAttr('selected');

        });
        return false;

    });

    document.getElementById("nameTh").addEventListener("click", function () {
        list('name');
    }, true);
    document.getElementById("emailTh").addEventListener("click", function () {
        list('email');
    }, true);
    document.getElementById("phoneTh").addEventListener("click", function () {
        list('phone');
    }, true);
    document.getElementById("birthdayTh").addEventListener("click", function () {
        list('birthday');
    }, true);

    document.getElementById("reset").addEventListener("click", function () {
        $("#save").html('Rögzít');
    }, true);

    document.getElementById("list").addEventListener("click", function () {
        list('name');
    }, true);

    document.getElementById("szures").addEventListener("keyup", function () {
        list();
    }, true);

});


function list(order) {
    if (document.getElementById("szures") != null) {
        szures = '&filter=' + document.getElementById("szures").value;
    } else {
        szures = '';
    }
    if (!order) {
        order = 'name';
    }
    $.ajax({
        type: 'POST',
        url: 'controller.php',
        data: 'method=list' + szures + '&order=' + order,
        dataType: 'html',
        cache: false
    })
            .done(function (html) {
                $('#adatsorok').html(html);
                $("#lista").show();

                $("#filterDiv").show();

            });

}

function szerkeszt(id) {
    $.ajax({
        type: 'POST',
        url: 'controller.php',
        data: 'method=edit' + szures + '&id=' + id,
        dataType: 'json',
        cache: false
    })
            .done(function (html) {
                document.getElementById("name").value = html.name;
                document.getElementById("telefon").value = html.phone;
                document.getElementById("email").value = html.email;
                document.getElementById("szuletesiDatum").value = html.birthday;
                document.getElementById("modosit").value = html.id;
                $("#save").html('Módosít');

                $("#lista").hide();
                $("#filterDiv").hide();

                if (html.hobbiKerekpar == '1') {
                    $("#hobbiKerekpar").prop('checked', true);
                }
                if (html.hobbiTurazas == '1') {
                    $("#hobbiTurazas").prop('checked', true);
                }
                if (html.hobbiHegymaszas == '1') {
                    $("#hobbiHegymaszas").prop('checked', true);
                }
                if (html.hobbiProgramozas == '1') {
                    $("#hobbiProgramozas").prop('checked', true);
                }
                if (html.hobbiEgyeb == '1') {
                    $("#hobbiEgyeb").prop('checked', true);
                }

            });

}