(function() {

    let tecla = '';
    $('#codigobarras').focus();

    $('#codigobarras').keypress(function(event) {
        event.preventDefault();

        if (event.charCode === 13) {

            $.ajax({
                type: 'POST',
                url: '?/servicios/ajax_codigobarra&buscarMateria=true',
                data: { codigo: tecla },
                dataType: 'json',
                success: function(response) {

                    console.log(response);

                    if (response) {

                        $('#codigobarras').attr('readonly', 'readonly');
                        $('#materia_prima option:selected').attr('selected', false);
                        $('#materia_prima option[value="' + response[0].materia_prima_idmateria_prima + '"]').attr('selected', 'selected');
                        $('#marca').val(response[0].marca);
                        $('#marca').attr('readonly', 'readonly');
                        $('#proveedor option:selected').attr('selected', false);
                        $('#proveedor option[value="' + response[0].proveedor_idproveedor + '"]').attr('selected', 'selected');
                        $('#cantidad').val(response[0].tipo_presentacion);

                    } else {

                        new PNotify({

                            title: 'Sin Datos',
                            text: 'Materia prima no encontrada',
                            type: 'warning',
                            addclass: 'stack-bar-top',
                            stack: stack_bar_top,
                            width: "100%"

                        });

                    }

                    $('#codigobarras').val(tecla);
                    tecla = '';
                }
            });

        } else { tecla = tecla + event.key; }
    });

    let stack_bar_top = { "dir1": "down", "dir2": "right", "push": "top", "spacing1": 0, "spacing2": 0 };

    let buttons = "<button id=\"verMateria\" title=\"Editar materia prima\" class=\"btn btn-primary btn-sm\"><i class=\"fas fa-list\"></i></button> ";

    let table = $('#datatable-materiaPrima');
    table.dataTable({
        "createdRow": function(row, data, dataIndex) {
            statusTable(row, data, dataIndex);
        },
        "lengthMenu": [7, 25, 75, 100],
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

    function statusTable(row, data, dataIndex) {

        if (data[6] == 'Vencida') { $(row).addClass('bg-danger'); }
        if (data[6] == 'En Uso') { $(row).addClass('table-success'); }
        if (data[6] == 'Terminada') { $(row).addClass('table-warning'); }

    }

    // Inicio Modal mostrar materia prima

    $('#datatable-materiaPrima tbody').on('click', '#verMateria', function(event) {
        event.preventDefault();
        let sData = table.fnGetData($(this).parents('tr'));

        $.ajax({
            type: "GET",
            url: "?/servicios/ajax_materias_primas&getMateria=true&id_materia=" + sData[7],
            dataType: "json",
            success: function(response) {

                $('#materia-prima').val(response[0].id_materia_prima_ingresada);
                $('#nombre-materia-prima').html(response[0].materiaPrima);
                $('#lote-proveedor').html(response[0].lote_proveedor);
                $('#marca-proveedor').html(response[0].marca);
                $('#nombre-proveedor').html('NIT' + response[0].NITProveedor + ' - ' + response[0].proveedor);
                $('#cantidad').html(response[0].tipo_presentacion);
                $('#direccion-proveedor').html(response[0].proveedorDireccion);
                $('#telefono-proveedor').html(response[0].telefonoProveedor);
                $('#fecha-ingreso').html(response[0].fecha_ingreso);
                $('#fecha-vencimiento').html(response[0].fecha_vencimiento);
                $('#codigo-barra').html(response[0].codigobarra);
                $('#fecha-ingreso').html(response[0].fecha_ingreso);
                $('#fecha-vencimiento').html(response[0].fecha_vencimiento);
                $('#codigo-barra').html(response[0].codigobarra);
                $('#responsable-ingreso').html(response[0].nombres + ' ' + response[0].apellidos);
                $('#avatar-responsable').attr('src', response[0].avatar);

                $('#estado-materia-prima option:selected').attr('selected', false);
                $('#estado-materia-prima option[value="' + response[0].id_estado + '"]').attr('selected', 'selected');

                switch (response[0].id_estado) {
                    case 1:
                        $('#estado-materia').html('<span style="color: orange"><h2> Estado: ' + response[0].estado + ' <i class="fas fa-star"></i></h2></span>');
                        break;
                    case 2:
                        $('#estado-materia').html('<span style="color: green"><h2> Estado: ' + response[0].estado + ' <i class="fas fa-mitten"></i></h2></span>');
                        break;
                    case 3:
                        $('#estado-materia').html('<span style="color: orange"><h2> Estado: ' + response[0].estado + ' <i class="fas fa-star-half"></i></h2></span>');
                        break;
                    case 4:
                        $('#estado-materia').html('<span style="color: red"><h2> Estado: ' + response[0].estado + ' <i class="fas fa-skull-crossbones"></i></h2></span>');
                        break;
                }

                $('#modal-ver-materia').modal({
                    backdrop: 'static',
                    keyboard: false
                });

            }
        });
    });

    $('#close-modal-ver-materia').on('click', function(event) {
        event.preventDefault();
        $('#modal-ver-materia').modal('hide');

    });

    $('#cambiar-estado-materia').click(function(e) {
        e.preventDefault();
        let materia = $('#materia-prima').val();
        let estado = $('#estado-materia-prima option:selected').val();
        $.ajax({
            type: 'POST',
            url: '?/servicios/ajax_materias_primas&materia_estado=true',
            data: { idestado: estado, idmateria: materia },
            dataType: 'json',
            success: function(response) {

                if (response.insert) { $('#modal-ver-materia').modal('hide'); }
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


    });

    // Inicio Modal ingreso proveedores

    $('#newProveedor').on('click', function(event) {
        event.preventDefault();

        $('#modal-new-proveedor').modal({
            backdrop: 'static',
            keyboard: false
        });

    });

    $('#cose-modal-curso-nuevo').on('click', function(event) {
        event.preventDefault();
        $('#modal-new-proveedor').modal('hide');

    });

    // Fin modals

    $('#cancel-new-materia').click(function(e) {
        e.preventDefault();

        $('#marca').removeAttr('readonly');
        $('#codigobarras').removeAttr('readonly');

        $('#materia_prima option:selected').attr('selected', false);
        $('#materia_prima option[value=""]').attr('selected', 'selected');

        $('#proveedor option:selected').attr('selected', false);
        $('#proveedor option[value=""]').attr('selected', 'selected');

        $('#form-new-materia')[0].reset();
        $('#codigobarras').focus();
    });

    $("#form-new-materia").validate({

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
                url: '?/servicios/ajax_materias_primas&add_materia=true',
                data: form,
                dataType: 'json',
                success: function(response) {

                    if (response.insert) { $('#form-new-materia')[0].reset(); }
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


    $("#form-new-proveedor").validate({

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
                url: '?/servicios/ajax_materias_primas&add_proveedor=true',
                data: form,
                dataType: 'json',
                success: function(response) {

                    if (response.insert) {
                        $('#proveedor').html(response.proveedores);
                        $('#modal-new-proveedor').modal('hide');
                        $('#form-new-proveedor')[0].reset();
                    }

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