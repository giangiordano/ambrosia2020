<div class="row">
    <div class="col-xl-12">
        <form id="form-new-lote" class="form-horizontal">
            <input type="hidden" name="crsfkey" value="<?=( null !== $this->sessionGet('crsfkey') ? $this->sessionGet('crsfkey') : '' )?>">
            <section class="card card-collapsed">
                <header class="card-header">
                    <div class="card-actions">
                        <button class="btn btn-primary" data-card-toggle><i class="fas fa-plus"></i> Nuevo Lote</button>
                    </div>

                    <h2 class="card-title">Generar Nuevo Lote</h2>
                    <p class="card-subtitle">
                        Todos los campos son requeridos.
                    </p>
                </header>
                <div class="card-body">

                    <div class="row">
                    
                        <div class="col-md-3">

                            <div class="form-group row">
                                <label class="col-sm-12 control-label pt-2">Lote <span class="required">*</span></label>
                                <div class="col-sm-12">
                                    <input type="text" name="lote" style="font-weight: bold; color: black" class="form-control" value="<?='L'.Date('dmY')?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-sm-12 control-label pt-2">Producto <span class="required">*</span></label>
                                <div class="col-sm-12">
                                    <select class="form-control" name="producto" id="producto" required>
                                        <?=$this->producto_descripcion?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-12 control-label pt-2">F. Vencimiento <span class="required">*</span></label>
                                <div class="col-lg-12">
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text">
                                                <i class="fas fa-calendar-alt"></i>
                                            </span>
                                        </span>
                                        <input type="text" data-plugin-datepicker value="<?=$this->vencimiento?>" name="vencimiento" class="form-control" required/>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-9">

                           <div class="row">
                                <div class="col-md-12">
                                    <div class="row m-2">
                                        <div class="col-md-4">
                                            <input type="text" name="buscar_materia" id="codigobarra" class="form-control">
                                        </div>
                                        <div class="col-md-2">
                                            <button class="btn btn-success">Buscar</button>
                                        </div>
                                    </div>

                                    <table id="tabla-ingredientes" class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Marca</th>
                                                <th scope="col">Lote</th>
                                                <th scope="col">F. Vencimiento</th>
                                                <th scope="col">Presentación</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>

                                </div>
                           </div>
                           <div class="row m-5">
                                <div class="col-md-6">
                                    <button type="button" id="add-ingrediente" class="btn btn-outline-success btn-block">Agregar</button>
                                </div>
                                <div class="col-md-6">
                                <button type="button" id="del-ingrediente" class="btn btn-outline-danger  btn-block">Eliminar</button>
                                </div>
                           </div>
                           <div class="row">
                                <div class="col-md-12">
                                
                                    <table class="table" id="tabla-ingredientes-lote">
                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col">Marca</th>
                                                <th scope="col">Lote</th>
                                                <th scope="col">F. Vencimiento</th>
                                                <th scope="col">Presentación</th>
                                                <th scope="col">Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>

                                </div>
                           </div>

                        </div>

                    </div>

                </div>
                <footer class="card-footer">
                    <div class="row justify-content-end">
                        <div class="col-md-12 text-center">
                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button id="cancel-new-lote" class="btn btn-default">Cancelar</button>
                        </div>
                    </div>
                </footer>
            </section>
        </form>
    </div>

</div>

<div class="row">

    <div class="col-xl-12">

        <div class="card-body">

                <div class="table-responsive-xl">
                    <table class="table table-striped" cellspacing="0" width="100%" id="datatable-lotes" data-url="?servicios/ajax_lote&tabla_inventario=true" >
                        <thead>
                            <tr>
                                <th>Lote</th>
                                <th>Producto</th>
                                <th>Fecha Producción</th>
                                <th>Fecha Vencimiento</th>
                                <th>Estado Lote</th>
                                <th>--</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>

        </div>

    </div>

</div>