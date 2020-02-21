function loginform() {

    $('#login-form').submit(function(e) {
        e.preventDefault();

        $('#loginbutton').html('<i class="fas fa-circle-notch fa-spin"></i> Entrar');
        $('#loginbutton').attr('disabled', 'disabled');

        var values = $(this).serialize();

        $.ajax({

            type: "POST",
            url: "?servicios/ajax_login",
            data: values,
            dataType: "json"

        }).done(function(data) {

            switch (data.sesion) {

                case false:

                    var mensaje = '<div class="validation-message"><ul style="display: block;"><li><label id="fullname-error" class="error" style="" for="fullname">' + data.msn + '</label></li></ul></div>';

                    $('#mensaje').html(mensaje);
                    $('#mensaje').show();
                    setTimeout(function() {

                        $('#mensaje').fadeOut('fast');
                        $('#loginbutton').html('<i class="fas fa-sign-in-alt"></i> Entrar');
                        $('#loginbutton').removeAttr('disabled');

                    }, 2500);
                    break;

                case true:

                    var mensaje = '<h4><label class="label label-success">' + data.msn + '</label></h4>';
                    $('#mensaje').html(mensaje);
                    $('#mensaje').show();
                    setTimeout(function() { window.location.href = data.redirect }, 500);
                    break;
            }

        })

    });
}