(function() {

    var stack_bar_top = { "dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0 };

    let tecla = '';
    $(document).keypress(function(event) {
        event.preventDefault();
        if (event.charCode === 13) {

            $.ajax({
                type: 'POST',
                url: '?/servicios/ajax_codigobarra&buscar_ingredientes=true',
                data: { codigo: tecla },
                dataType: 'json',
                success: function(response) {

                    $('#tabla-ingredientes tbody').html(response.table);
                    if (response.found == false) {

                        new PNotify({

                            title: response.titulo,
                            text: response.mensaje,
                            type: response.tipo,
                            addclass: 'stack-bar-top',
                            stack: stack_bar_top,
                            width: "100%"

                        });

                    }

                    tecla = '';
                }
            });

        } else { tecla = tecla + event.key; }
    });

    $('#add-ingrediente').click(function(e) {
        e.preventDefault();
        let tr = $('#tabla-ingredientes').find("tr.selected");
        tr.removeClass('table-success selected');
        $('#tabla-ingredientes-lote tbody').append(tr);

    });

    $('#del-ingrediente').click(function(e) {
        e.preventDefault();
        $('#tabla-ingredientes-lote').find("tr.selected").remove();
    });

    $('#tabla-ingredientes tbody').on('click', 'tr', function() {
        if ($(this).hasClass('table-success selected')) {
            $(this).removeClass('table-success selected');
        } else {
            $('#tabla-ingredientes tr.selected').removeClass('table-success selected');
            $(this).addClass('table-success selected');
        }
    });

    $('#tabla-ingredientes-lote tbody').on('click', 'tr', function() {
        if ($(this).hasClass('table-danger selected')) {
            $(this).removeClass('table-danger selected');
        } else {
            $('#tabla-ingredientes-lote tr.selected').removeClass('table-danger selected');
            $(this).addClass('table-danger selected');
        }
    });

    $('#cancel-new-lote').click(function(e) {
        e.preventDefault();
        $('#form-new-lote')[0].reset();
    });

    $("#form-new-lote").validate({

        highlight: function(label) {
            $(label).closest('.form-group').removeClass('has-success').addClass('has-error');
            $(label).removeClass('has-success').addClass('error');
        },
        success: function(label) {
            $(label).closest('.form-group').removeClass('has-error');
            $(label).removeClass('has-error');
            label.remove();
        },
        errorPlacement: function(error, element) {
            var placement = element.closest('.input-group');
            if (!placement.get(0)) {
                placement = element;
            }
            if (error.text() !== '') {
                placement.after(error);
            }
        },
        submitHandler: function(_form) {
            let form = $(_form).serialize();
            $.ajax({

                type: 'POST',
                url: '?/servicios/ajax_lote&add_lote=true',
                data: form,
                dataType: 'json',
                success: function(response) {

                    new PNotify({

                        title: response.titulo,
                        text: response.mensaje,
                        type: response.tipo,
                        addclass: 'stack-bar-top',
                        stack: stack_bar_top,
                        width: "100%"

                    });
                }
            });
        }
    });

}).apply(this, [jQuery]);