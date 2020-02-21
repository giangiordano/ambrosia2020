<div class="row">
    <div class="col-xl-4">
        <form id="form-new-client" class="form-horizontal">
            <input type="hidden" name="crsfkey" value="<?=( null !== $this->sessionGet('crsfkey') ? $this->sessionGet('crsfkey') : '' )?>">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>

                    <h2 class="card-title">Crear cliente</h2>
                    <p class="card-subtitle">
                        Todos los campos son requeridos.
                    </p>
                </header>
                <div class="card-body">
                    
                    <input type="hidden" id="longitude" name="longitude" value="">
                    <input type="hidden" id="latitude" name="latitude" value="">
                    <input type="hidden" id="accurency" name="accurency" value="">

                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Nombres <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="nombres" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Apellidos <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="apellidos" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Documento <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="digits" name="documento" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Email <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="email" name="email" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Telefono <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="digits" name="telefono" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Direccion <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="direccion" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Departamento <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="departamento" id="departamento" required>
                                <?=$this->departamento?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Municipio <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="municipio" id="municipio" required>
                                <option></option>
                            </select>
                        </div>
                    </div>

                </div>
                <footer class="card-footer">
                    <div class="row justify-content-end">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button id="cancel-new-client" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>
    <div class="col-xl-8">

        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Clientes</h2>
            </header>
            <div class="card-body">
                
            <div class="table-responsive-xl">
                <table class="table table-striped" cellspacing="0" width="100%" id="datatable-verCartera" data-url="?servicios/ajax_cliente&tabla_cliente=true" >
                    <thead>
                        <tr>
                            <th>Nombres</th>
                            <th>Apellidos</th>
                            <th>Documento</th>
                            <th>Email</th>
                            <th>Dirección</th>
                            <th>Telefono</th>
                            <th>-</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            </div>
        </section>

    </div>
</div>

