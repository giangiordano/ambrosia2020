(function() {

    // Geo Localizacion de cliente

    let options = {
        enableHighAccuracy: true,
        timeout: 5000,
        maximumAge: 0
    };

    function success(pos) {
        let crd = pos.coords;
        $('#latitude').val(crd.latitude);
        $('#longitude').val(crd.longitude);
        $('#accurency').val(crd.accuracy);
    };

    function error(err) {
        console.warn('ERROR(' + err.code + '): ' + err.message);
    };

    navigator.geolocation.getCurrentPosition(success, error, options);

    // Geo Localizacion de cliente


    var stack_bar_top = { "dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0 };
    let buttons = "<button id=\"editCliente\" title=\"Editar Cliente\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-edit\"></i></button> ";
    var table = $('#datatable-verCartera');
    table.dataTable({

        "lengthMenu": [10, 25, 50, 75],
        "ordering": false,
        bServerSide: true,
        bProcessing: true,
        sAjaxSource: table.data('url'),
        "columnDefs": [{
            "targets": -1,
            "data": null,
            "defaultContent": buttons
        }],
        "language": {

            "sProcessing": null,
            "sLengthMenu": "Mostrar _MENU_ registros",
            "sZeroRecords": "No se encontraron resultados",
            "sEmptyTable": "Ningún dato disponible en esta tabla",
            "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
            "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
            "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
            "sInfoPostFix": "",
            "sSearch": "",
            "searchPlaceholder": "Buscar",
            "sUrl": "",
            "sInfoThousands": ",",
            "sLoadingRecords": "Cargando...",
            "oPaginate": {
                "sFirst": "Primero",
                "sLast": "Último",
                "sNext": "Siguiente",
                "sPrevious": "Anterior"
            },
            "oAria": {
                "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
                "sSortDescending": ": Activar para ordenar la columna de manera descendente"
            }
        }
    });

    $('#departamento').change(function(event) {
        event.preventDefault();
        let id = $(this).children("option:selected").val();
        $.ajax({

                url: '?/servicios/ajax_getMunicipios&getMunicipios=true&id_depart=' + id,
                type: 'GET',
                dataType: 'json',
            })
            .done(function(data) {

                $('#municipio').html(data.html);
            });
    });

    $('#cancel-new-client').click(function(e) {
        e.preventDefault();
        $('#form-new-client')[0].reset();
    });


    $("#form-new-client").validate({

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
                url: '?/servicios/ajax_cliente&crear_cliente=true',
                data: form,
                dataType: 'json',
                success: function(response) {
                    if (response.insert) { $('#form-new-client')[0].reset(); }
                    table.fnDraw();
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