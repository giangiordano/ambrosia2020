<div class="row">
    <div class="col-lg-4">
        <form id="form-inventario" class="form-horizontal">
            <input type="hidden" name="crsfkey" value="<?=( null !== $this->sessionGet('crsfkey') ? $this->sessionGet('crsfkey') : '' )?>">
            <section class="card">
                <header class="card-header">
                    <div class="card-actions">
                        <a href="#" class="card-action card-action-toggle" data-card-toggle></a>
                    </div>

                    <h2 class="card-title">Producto Terminado</h2>
                    <p class="card-subtitle">
                        Todos los campos son requeridos.
                    </p>
                </header>
                <div class="card-body">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Producto <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <select class="form-control" name="producto" id="producto" required>
                                <?=$this->productos?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Lote <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="lote" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Ingreso <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="ingreso" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Vencimiento <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="vencimiento" class="form-control" required/>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label text-sm-right pt-2">Cantidad <span class="required">*</span></label>
                        <div class="col-sm-8">
                            <input type="digits" name="cantidad" class="form-control" required/>
                        </div>
                    </div>

                </div>
                <footer class="card-footer">
                    <div class="row justify-content-end">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button id="cancel-new-inventario" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>

     <div class="col-lg-8">

        <section class="card">
            <header class="card-header">
                <h2 class="card-title">Inventario de producto terminado</h2>
            </header>
            <div class="card-body">
                
            <div class="table-responsive-xl">
                <table class="table table-striped" cellspacing="0" width="100%" id="datatable-verInventario" data-url="?servicios/ajax_inventario&tabla_inventario=true" >
                    <thead>
                        <tr>
                            <th>Producto</th>
                            <th>Lote</th>
                            <th>Cantidad</th>
                            <th>Ingreso</th>
                            <th>Vencimiento</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>

            </div>
        </section>

    </div>
</div>

