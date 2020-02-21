(function() {

    var stack_bar_top = { "dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0 };

    var table = $('#datatable-verInventario');
    table.dataTable({

        "lengthMenu": [25, 50, 75, 100],
        "ordering": false,
        bServerSide: true,
        bProcessing: true,
        sAjaxSource: table.data('url'),
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


    $('#cancel-new-inventario').click(function(e) {
        e.preventDefault();
        $('#form-inventario')[0].reset();
    });


    $("#form-inventario").validate({

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
                url: '?/servicios/ajax_inventario&add_product=true',
                data: form,
                dataType: 'json',
                success: function(response) {
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