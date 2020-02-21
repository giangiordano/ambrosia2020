<div class="row">
    <div class="col-xl-4">
        <form id="form-new-materia" class="form-horizontal">
            <input type="hidden" name="crsfkey" value="<?=( null !== $this->sessionGet('crsfkey') ? $this->sessionGet('crsfkey') : '' )?>">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>

                    <h2 class="card-title">Ingreso Materias Prima</h2>
                    <p class="card-subtitle">
                        Todos los campos son requeridos.
                    </p>
                </header>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Código <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="digits" name="codigo" id="codigobarras" class="form-control" placeholder="Código de barras" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Materia Prima <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="materia_prima" id="materia_prima" required>
                                <?=$this->materia_prima?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Marca <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="marca" id="marca" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Lote <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="lote" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-lg-4 control-label text-lg-right pt-2">F. Vencimiento <span class="required">*</span></label>
                        <div class="col-lg-8">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                </span>
                                <input type="text" data-plugin-datepicker value="<?=date('d/m/Y')?>" name="vencimiento" class="form-control" required/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Cantidad <span class="required">*</span></label>
                        <div class="col-sm-4">
                            <input type="digits" name="cantidad" id="cantidad" class="form-control" required/>
                        </div>
                        <div class="col-sm-4">
                            <select name="tipo_gramos" class="form-control">
                                <option value="kg">kg</option>
                                <option value="gr">gr</option>
                                <option value="gr">unid</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Proveedor <span class="required">*</span></label>
                        <div class="col-sm-6">
                            <select class="form-control" name="proveedor" id="proveedor" required>
                                <?=$this->proveedor?>
                            </select>
                        </div>
                        <div class="col-sm-2">
                           <button type="button" id="newProveedor" class="btn btn-primary"><i class="fas fa-plus"></i></button>
                        </div>
                    </div>

                </div>
                <footer class="card-footer">
                    <div class="row justify-content-end">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button id="cancel-new-materia" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>

     <div class="col-xl-8">

        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Material en bodega</h2>
            </header>
            <div class="card-body">
                
                <div class="table-responsive-xl">
                    <table class="table table-striped" cellspacing="0" width="100%" id="datatable-materiaPrima" data-url="?/servicios/ajax_materias_primas&tabla_materias=true" >
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Marca</th>
                                <th>Lote</th>
                                <th>Ingreso</th>
                                <th>Vencimiento</th>
                                <th>Proveedor</th>
                                <th>Estado</th>
                                <th> - </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

            </div>
        </section>

    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-new-proveedor">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Agregar Proveedor</h5>
        </div>
        <div class="modal-body">

        <form id="form-new-proveedor" class="form-horizontal">

            <input type="hidden" name="crsfkey" value="<?=( null !== $this->sessionGet('crsfkey') ? $this->sessionGet('crsfkey') : '' )?>">
            <div class="form-group row">
                <label class="col-sm-4 control-label text-sm-right pt-2">NIT <span class="required">*</span></label>
                <div class="col-sm-8">
                    <input type="digits" name="nit" class="form-control" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label text-sm-right pt-2">Nombre <span class="required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="nombre" class="form-control" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label text-sm-right pt-2">Dirección <span class="required">*</span></label>
                <div class="col-sm-8">
                    <input type="text" name="direccion" class="form-control" required/>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-4 control-label text-sm-right pt-2">Teléfono <span class="required">*</span></label>
                <div class="col-sm-8">
                    <input type="digits" name="telefono" class="form-control" required/>
                </div>
            </div>

        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        </div>
        </form>
        </div>
    </div>
</div>

<div class="modal" tabindex="-1" role="dialog" id="modal-ver-materia">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Materia Prima</h5>
        </div>
        <div class="modal-body">
                
                <input type="hidden" name="materia-prima" id="materia-prima">
                <div class="row form-group">

                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Materia Prima</label>
                            <label class="form-control form-control-sm text-dark"  id="nombre-materia-prima"></label>
                        </div>
                    </div>

                    <div class="col-lg-6 offset-md-2 text-center">
                        <div id="estado-materia"></div>
                    </div>

                </div>

                <div class="row form-group">

                     <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Lote</label>
                            <label class="form-control form-control-sm text-dark"  id="lote-proveedor"></label>
                        </div>
                    </div>
                     <div class="col-lg-3">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Marca</label>
                            <label class="form-control form-control-sm text-dark"  id="marca-proveedor"></label>
                        </div>
                    </div>
                     <div class="col-lg-6">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Proveedor</label>
                            <label class="form-control form-control-sm text-dark" id="nombre-proveedor"></label>
                        </div>
                    </div>

                </div>

                <div class="row form-group">

                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Cantidad</label>
                            <label class="form-control form-control-sm text-dark" id="cantidad"></label>
                        </div>
                    </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Direccion Proveedor</label>
                            <label class="form-control form-control-sm text-dark" id="direccion-proveedor"></label>
                        </div>
                    </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Telefono Proveedor</label>
                            <label class="form-control form-control-sm text-dark" id="telefono-proveedor"></label>
                        </div>
                    </div>

                </div>

                <div class="row form-group">

                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Fecha Ingreso</label>
                            <label class="form-control form-control-sm text-dark" id="fecha-ingreso"></label>
                        </div>
                    </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Fecha Vencimiento</label>
                            <label class="form-control form-control-sm text-dark" id="fecha-vencimiento"></label>
                        </div>
                    </div>
                     <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Código Barra</label>
                            <label class="form-control form-control-sm text-dark" id="codigo-barra"></label>
                        </div>
                    </div>

                </div>

                <div class="row form-group align-items-center">

                     <div class="col-lg-5">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Ingresado por:</label>
                            <label class="form-control form-control-sm text-dark" id="responsable-ingreso"></label>
                        </div>
                    </div>
                    <div class="col-lg-3 text-left">
                       <img src="" class="rounded-circle" width="30%" id="avatar-responsable">
                    </div>
                    <div class="col-lg-4">
                        <div class="form-group">
                            <label class="col-form-label" for="formGroupExampleInput">Estado Materia Prima</label>
                            <select id="estado-materia-prima"  class="form-control form-control-sm">
                                <option value="0"> -- </option>
                                <option value="2">En Uso</option>
                                <option value="3">Terminada</option>
                            </select>
                        </div>
                    </div>

                </div>


        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fas fa-times"></i> Cancelar</button>
            <button id="cambiar-estado-materia" class="btn btn-primary"><i class="fas fa-save"></i> Guardar</button>
        </div>
        </div>
    </div>
</div>