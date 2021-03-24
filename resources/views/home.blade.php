@extends('layouts.app')

@section('content')


      <!-- VUEJS -->
      <div id="appVue">

        <!-- Begin Page Content -->
        <div class="container-fluid">

          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="configuracion-tab" data-toggle="tab" href="#configuracion" role="tab" aria-controls="configuracion" aria-selected="true">Configuracion</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="compras-tab" data-toggle="tab" href="#compras" role="tab" aria-controls="compras" aria-selected="false">Compras</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" id="inventario-tab" data-toggle="tab" href="#inventario" role="tab" aria-controls="inventario" aria-selected="false">Inventario</a>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="configuracion" role="tabpanel" aria-labelledby="configuracion-tab">
              <!-- CONFIGURACION CONTENT -->
              <div class="container-fluid">
                <!-- Page Heading -->


              
                
                  <div class="row mt-3">
                    <form>
                      <div class="form-group">
                        <label for="formGroupExampleInput">Nombre de la Entidad:</label>
                        <input @keyup.prevent="findEntidad" v-model="buscarNombreEntidad" type="text" class="form-control" placeholder="Buscar...">
                      </div>
                    </form>
                  </div>
                  <!-- VISTA UNO -->
                  <div class="row">
                    <!-- entidad REGISTRADA -->
                    <ul v-if="nombreExisteEnRegistroDeEntidades">
                      <li v-for="(producto, index) in nombresDeEntidadesRegistradas" :key="index">
                        <a href="#" @click.prevent="verEntidadRegistrada(producto)">
                          Ver <strong>@{{ producto.nombreEntidad }}</strong>
                        </a>
                      </li>
                    </ul>
                    <!-- /entidad REGISTRADA -->
                    <!-- entidad NUEVA -->
                    <div v-else-if="!nombreExisteEnRegistroDeEntidades && buscarNombreEntidad.length > 2">
                      <a @click.prevent="verNuevoNombreDeEntidad" href="#">
                        <p>Registrar <strong>@{{ buscarNombreEntidad }}</strong> como nuevo nombre de entidad</p>
                      </a>
                    </div>
                    <!-- /entidad NUEVA -->
                    {{-- TODO --}}
                    <ul v-else>
                      <li v-for="(producto, index) in registroDeEntidades" :key="producto.id">
                        <a href="#" @click.prevent="verEntidadRegistrada(producto)">
                          Ver <strong>@{{ producto.nombreEntidad }}</strong>
                        </a>
                      </li>
                    </ul>
                    {{-- /TODO --}}
                  </div>
                  <!-- /VISTA UNO -->
                  

                  <!-- VISTA DOS -->
                  <div class="row">
                    <div class="col-md-10 offset-md-1 text-center">
                      <!-- ENTIDAD NUEVA -->
                      <form v-if="agregarNuevoNombreDeEntidad">
                        <div class="form-group text-center">
                          <label class="text-center">Nuevo Nombre de la entidad</label>
                          <input v-model="newEntidad.nombreEntidad" type="text" class="form-control text-center" readonly>
                        </div>
                        <h5 class="text-center">Atributos</h5>
                        <div class="form-group text-center">
                          <label class="sr-only">Nombre del Atributo Nuevo</label>
                          <div class="input-group mb-2">
                            <input v-model="newAtributo.nombre" type="text" class="form-control" placeholder="Nuevo Atributo...">
                            <div class="input-group-append">
                              <button :disabled="atributoNoValidoParaSerAgregado" @click.prevent="handleNewAtributo" class="input-group-text btn btn-outline-success">
                                <i class="fa fa-plus"></i>
                              </button>
                            </div>
                          </div>
                          <small v-if="atributoNoValidoParaSerAgregado" class="text-danger">El Atributo @{{ newAtributo.nombre }} no es válido...</small>
                        </div>

                        <div class="form-row">
                          <div class="form-col" v-for="(atributo, index) in newEntidad.atributos" :key="index">
                            <!-- TARJETAS - entidad registrada -->
                            <tarjeta-de-atributo 
                              :atributo="atributo"
                              :remove-atributo="removeAtributo"
                              @new-valor="handleNewValor"
                              @remove-valor="removeIncomingValue"
                            />
                            <!-- /TARJETAS - entidad registrada -->
                          </div>
                        </div>

                        
                      </form>
                      <!-- /ENTIDAD NUEVA -->
        
                      <!-- ENTIDAD REGISTRADA -->
                      <form v-else-if="agregarNombreDeEntidadExistente">
                        <div class="form-group text-center">
                          <label class="sr-only">Nombre del Atributo Nuevo</label>
                          <div class="input-group mb-2">
                            <input v-model="newEntidad.nombreEntidad" type="text" class="form-control text-center" readonly>
                            <div class="input-group-append">
                              <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                              <a @click.prevent="removeProductNameRegistered(newEntidad.nombreEntidad, newEntidad.id)" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                            </div>
                          </div>
                        </div>
                        <div class="form-group text-center">
                          <label class="sr-only">Nombre del Atributo Nuevo</label>
                          <div class="input-group mb-2">
                            <input v-model="newAtributo.nombre" type="text" class="form-control" placeholder="Nuevo Atributo...">
                            <div class="input-group-append">
                              <button :disabled="atributoNoValidoParaSerAgregado" @click.prevent="handleNewAtributo" class="input-group-text btn btn-outline-success">
                                <i class="fa fa-plus"></i>
                              </button>
                            </div>
                          </div>
                          <small v-if="atributoNoValidoParaSerAgregado" class="text-danger">El Atributo @{{ newAtributo.nombre }} no es válido...</small>
                        </div>

                        <div class="form-row">
                          <div class="form-col" v-for="(atributo, index) in newEntidad.atributos" :key="index">
                            <!-- TARJETAS - entidad registrada -->
                            <tarjeta-de-atributo 
                              :atributo="atributo"
                              :remove-atributo="removeAtributo"
                              @new-valor="handleNewValor"
                              @remove-valor="removeIncomingValue"
                            />
                            <!-- /TARJETAS - entidad registrada -->
                          </div>
                        </div>


                        
                      </form>
                      <!-- /ENTIDAD REGISTRADA -->
                    </div>
                  </div>
                  <!-- /VISTA DOS -->

              </div>
              <!-- /CONFIGURACION CONTENT -->
            </div>

            <div class="tab-pane fade" id="compras" role="tabpanel" aria-labelledby="compras-tab">
              <!-- COMPRAS-CONTENT -->
                <div class="container-fluid mt-2">
                  <ul class="nav nav-tabs" id="myTabCompras" role="tablist">
                    <li class="nav-item">
                      <a class="nav-link active" id="registrar-nueva-compra-tab" data-toggle="tab" href="#registrar-nueva-compra" role="tab" aria-controls="registrar-nueva-compra" aria-selected="true">Registrar Nueva Compra</a>
                    </li>
                    <li class="nav-item">
                      <a class="nav-link" id="compras-recibidas-tab" data-toggle="tab" href="#compras-recibidas" role="tab" aria-controls="compras-recibidas" aria-selected="false">Compras Recibidas</a>
                    </li>
                  </ul>
                </div>
                <div class="tab-content" id="myTabComprasContent">
                  <div class="tab-pane fade show active" id="registrar-nueva-compra" role="tabpanel" aria-labelledby="registrar-nueva-compra-tab">
                    {{-- nueva-compra --}}
                      <div class="container-fluid m-3">

                        <div class="row mt-3">
                          <div class="col">
                            <form>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label for="exampleFormControlSelect1">Selecciona el Producto:</label>
                                    <select v-model="formCompra.nombreDeEntidadSeleccionadaParaComprar" class="form-control" required>
                                      <option value="">--Seleccione--</option>
                                      <option v-for="(producto, index) in registroDeEntidades" 
                                        :value="producto.nombreEntidad"
                                      >@{{ producto.nombreEntidad }}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row" v-for="(atributo, index) in atributosAMostrar" :key="atributo.nombre">
          
                                <div class="col">
                                  <div class="form-group">
                                    <label>@{{ atributo.nombre }}</label>
                                    <select v-model="formCompra.atributos[atributo.nombre]" class="form-control" required>
                                      <option :value="valor" v-for="(valor, pos) in atributo.valores">@{{ valor }}</option>
                                    </select>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label>Cantidad de Unidades</label>
                                    <input v-model="formCompra.cantidadItemsEnCompra" type="number" class="form-control" required>
                                  </div>
                                </div>
                                <div class="col">
                                  <div class="form-group">
                                    <label>Monto Total Pagado</label>
                                    <input v-model="formCompra.montoTotalPagado" type="number" class="form-control" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label>Monto Unitario (c/u)</label>
                                    <input v-model="costoUnitario" type="number" class="form-control" readonly>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label>Precio Sugerido (c/u)</label>
                                    <input v-model="formCompra.precioSugerido" type="number" class="form-control" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <label>Ingrese el enlace completo al sitio donde se realizó la compra:</label>
                                    <input v-model="formCompra.enlaceURLDeLaCompra" type="text" class="form-control" placeholder="Ejemplo: https://www.proveedor.com" required>
                                  </div>
                                </div>
                              </div>
                              <div class="row">
                                <div class="col">
                                  <div class="form-group">
                                    <button @click.prevent="handleNuevaCompra" class="btn btn-outline-success">Registrar Compra</button>
                                  </div>
                                </div>
                              </div>
                            </form>
                          </div>
                        </div>
                        <!-- Tabla -->
                        <div class="card shadow mb-4">
                          <div class="card-header py-3">
                            <h5 class="m-0 font-weight-bold text-primary text-center">Compras Registradas y esperando su despacho</h5>
                          </div>
                          <div class="card-body">
                            <div class="table-responsive">
                              <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                <thead>
                                  <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Producto(s)</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Características</th>
                                    <th class="text-center">Costo Total</th>
                                    <th class="text-center">Costo Unitario</th>
                                    <th class="text-center">Precio Sugerido</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Acciones</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(compra, index) in comprasRegistradasYPendientes">
                                    <td v-if="compra.enlace_url" class="text-center">
                                      <a target="_blank" :href="compra.enlace_url">
                                        @{{ compra.id }}
                                      </a>
                                    </td>
                                    <td v-else class="text-center">
                                      @{{ compra.id }}
                                    </td>
        
                                    <td class="text-center">
                                      <p>
                                        @{{ compra.productos[0].ejemplar.nombre }}
                                      </p>
                                    </td>
        
                                    <td class="text-center">
                                      @{{compra.productos.length}} Unidades
                                    </td>
        
                                    <td class="text-center">
                                      <p v-for="(valor, atributo) in compra.productos[0].ejemplar.atributos">
                                        @{{ atributo }}: @{{ valor }}
                                      </p>
                                    </td>
        
                                    <td class="text-center">@{{ compra.precio_total }}</td>
        
                                    <td class="text-center">@{{ compra.productos[0].costo_unitario }}</td>
        
                                    <td class="text-center">@{{ compra.productos[0].precio_sugerido }}</td>
        
                                    <td class="text-center">
                                      <p>@{{ getDateFormatted(compra.created_at) }}</p>
                                      <p>(@{{ getDate_inAgoFormat(compra.created_at) }})</p>
                                    </td>
                                    
                                    <td class="text-center">@{{ getStatusDeLaCompra(compra.status) }}</td>
        
                                    <td class="text-center">
                                      <a @click.prevent="eliminarCompra(compra.id)" class="btn btn-outline-danger btn-sm m-1" href="#">Eliminar</a>
                                      <a @click.prevent="handleCambioDeStatusDeCompra(compra.id, 'recibida')" class="btn btn-outline-info btn-sm m-1" href="#">Compra RECIBIDA</a>
                                    </td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th class="text-center">ID</th>
                                    <th class="text-center">Producto(s)</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Características</th>
                                    <th class="text-center">Costo Total</th>
                                    <th class="text-center">Costo Unitario</th>
                                    <th class="text-center">Precio Sugerido</th>
                                    <th class="text-center">Fecha</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Acciones</th>
                                  </tr>
                                </tfoot>
        
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    {{-- /nueva-compra --}}
                  </div>
                  <div class="tab-pane fade" id="compras-recibidas" role="tabpanel" aria-labelledby="compras-tab">
                    {{-- Compras-Recibidas --}}
                      <div class="container-fluid">
                        
                        {{-- TABLA DE COMPRAS RECIBIDAS --}}
                          <div class="card shadow mb-4">
                            <div class="card-header py-3">
                              <h5 class="m-0 font-weight-bold text-primary text-center">Compras Recibidas</h5>
                            </div>
                            <div class="card-body">
                              <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                  <thead>
                                    <tr>
                                      <th class="text-center">ID</th>
                                      <th class="text-center">Producto(s)</th>
                                      <th class="text-center">Cantidad</th>
                                      <th class="text-center">Características</th>
                                      <th class="text-center">Costo Total</th>
                                      <th class="text-center">Costo Unitario</th>
                                      <th class="text-center">Precio Sugerido</th>
                                      <th class="text-center">Fecha</th>
                                      <th class="text-center">Status</th>
                                      <th class="text-center">Acciones</th>
                                    </tr>
                                  </thead>
                                  <tbody>
                                    <tr v-for="(compra, index) in comprasRegistradasYRecibidas">
                                      <td v-if="compra.enlace_url" class="text-center">
                                        <a target="_blank" :href="compra.enlace_url">
                                          @{{ compra.id }}
                                        </a>
                                      </td>
                                      <td v-else class="text-center">
                                        @{{ compra.id }}
                                      </td>
          
                                      <td class="text-center">
                                        <p>
                                          @{{ compra.productos[0].ejemplar.nombre }}
                                        </p>
                                      </td>
          
                                      <td class="text-center">
                                        @{{compra.productos.length}} Unidades
                                      </td>
          
                                      <td class="text-center">
                                        <p v-for="(valor, atributo) in compra.productos[0].ejemplar.atributos">
                                          @{{ atributo }}: @{{ valor }}
                                        </p>
                                      </td>
          
                                      <td class="text-center">@{{ compra.precio_total }}</td>
          
                                      <td class="text-center">@{{ compra.productos[0].costo_unitario }}</td>
          
                                      <td class="text-center">@{{ compra.productos[0].precio_sugerido }}</td>
          
                                      <td class="text-center">
                                        <h6>Fecha de Registro</h6>
                                        <p>@{{ getDateFormatted(compra.created_at) }}</p>
                                        <p>(@{{ getDate_inAgoFormat(compra.created_at) }})</p>
                                        <hr>
                                        <h6>Fecha de recibimiento</h6>
                                        <p>@{{ getDateFormatted(compra.updated_at) }}</p>
                                        <p>(@{{ getDate_inAgoFormat(compra.updated_at) }})</p>
                                      </td>
                                      
                                      <td class="text-center">@{{ getStatusDeLaCompra(compra.status) }}</td>
          
                                      <td class="text-center">
                                        <a @click.prevent="eliminarCompra(compra.id)" class="btn btn-outline-danger btn-sm m-1" href="#">Eliminar</a>
                                        <a @click.prevent="handleCambioDeStatusDeCompra(compra.id, 'sin_recibir')" class="btn btn-outline-info btn-sm m-1" href="#">Cambiar Status</a>
                                      </td>
                                    </tr>
                                  </tbody>
                                  <tfoot>
                                    <tr>
                                      <th class="text-center">ID</th>
                                      <th class="text-center">Producto(s)</th>
                                      <th class="text-center">Cantidad</th>
                                      <th class="text-center">Características</th>
                                      <th class="text-center">Costo Total</th>
                                      <th class="text-center">Costo Unitario</th>
                                      <th class="text-center">Precio Sugerido</th>
                                      <th class="text-center">Fecha</th>
                                      <th class="text-center">Status</th>
                                      <th class="text-center">Acciones</th>
                                    </tr>
                                  </tfoot>
          
                                </table>
                              </div>
                            </div>
                          </div>
                        {{-- /TABLA DE COMPRAS RECIBIDAS --}}
                      </div>
                    {{-- /Compras-Recibidas --}}
                  </div>
                </div>
              <!-- /COMPRAS-CONTENT -->
            </div>

            <div class="tab-pane fade" id="inventario" role="tabpanel" aria-labelledby="inventario-tab">
              {{-- INVENTARIO-CONTENT --}}
                <div class="container-fluid mt-2">

                  {{-- TABLA DE productos disponibles --}}
                  <div class="card shadow mb-4">
                    <div class="card-header py-3">
                      <h5 class="m-0 font-weight-bold text-primary text-center">PRODUCTOS DISPONIBLESSS</h5>
                    </div>
                    <div class="card-body">
                      <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                          <thead>
                            <tr>
                              <th class="text-center">ID</th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="text-center">productoxxx</td>
                            </tr>
                          </tbody>
                          <tfoot>
                            <tr>
                              <th class="text-center">ID</th>
                            </tr>
                          </tfoot>

                        </table>
                      </div>
                    </div>
                  </div>
                  {{-- /TABLA DE productos disponibles --}}
                  
                </div>
              {{-- /INVENTARIO-CONTENT --}}
            </div>
          </div>

        </div>
        <!-- /.container-fluid -->






        <!-- Button trigger modal-cambiar status A SIN RECIBIR -->
        <button id="button_show_modal_cambiar_status_compra_SIN_RECIBIR" type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#camBiarStatusDeCompraxsinrecibir">
        </button>

        <!-- Modal-cambiar status A SIN RECIBIR-->
        <div class="modal fade" id="camBiarStatusDeCompraxsinrecibir" tabindex="-1" role="dialog" aria-labelledby="camBiarStatusDeCompraxsinrecibirTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambiar Status de la Compra</h5>
                <button id="cerrar_modal_cambio_de_status_a_recibida" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>¿Te equivocaste y en realidad aún no has recibido los productos?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button @click.prevent="cambiarStatusDeCompra('compra_pendiente')" type="button" class="btn btn-success">Sí, la compra está pendiente todavía</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Button trigger modal-cambiar status A RECIBIDA -->
        <button id="button_show_modal_cambiar_status_compra_recibida" type="button" class="btn btn-primary d-none" data-toggle="modal" data-target="#camBiarStatusDeComprax">
        </button>

        <!-- Modal-cambiar status A RECIBIDA-->
        <div class="modal fade" id="camBiarStatusDeComprax" tabindex="-1" role="dialog" aria-labelledby="camBiarStatusDeCompraxTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Cambiar Status de la Compra</h5>
                <button id="cerrar_modal_cambio_de_status_a_pendiente" type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p>¿Ya recibiste tus productos?</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Salir</button>
                <button @click.prevent="cambiarStatusDeCompra('compra_recibida')" type="button" class="btn btn-success">Sí, Compra Recibida</button>
              </div>
            </div>
          </div>
        </div>



      </div>
      <!-- /VUEJS -->

@endsection













@section('custom_js')
    <script type="text/javascript">
        const {createApp} = Vue;

        let ejemplo_de_entidad = {
          nombreEntidad: 'Pestaña',
          atributos: [
              {
                  nombre: 'Medida',
                  valores: ['0.05', '0.07', '0.20']
              },
              {
                  nombre: 'Color',
                  valores: ['Rojo', 'Negro', 'Transparente']
              }
          ],
        };

        const application = createApp({
        el: '#appVue',
        data() {
            return {

                registroDeEntidades: [], // esto se llena desde la base de datos (source of truth)
        
                buscarNombreEntidad: "",
        
                newEntidad: {
                    id: null,
                    nombreEntidad: '',
                    atributos: []
                },
        
                newAtributo: {
                    nombre: '',
                    valores: []
                },
        
                atributoEnModoEdicion: false,
        
                nombreExisteEnRegistroDeEntidades: false,
                nombresDeEntidadesRegistradas: [],
                agregarNuevoNombreDeEntidad: false,
                agregarNombreDeEntidadExistente: false,
                atributoNoValidoParaSerAgregado: false,
        
                formCompra: {
                    nombreDeEntidadSeleccionadaParaComprar: "",
                    cantidadItemsEnCompra: null,
                    montoTotalPagado: null,
                    costoPorUnidad: null,
                    precioSugerido: null,
                    enlaceURLDeLaCompra: null,
                    atributos: {}
                },
        
                comprasRegistradasYPendientes: [],
                comprasRegistradasYRecibidas: [],

                cambiarStatusDeLaCompraConId: null,
                mensajeDelBotonModalParaCambioDeStatus: null,
            }

        },

        methods: {
            findEntidad() {
                if (this.buscarNombreEntidad.length > 2) {
                    let existe = false;
                    let nombres = [];
                    this.registroDeEntidades.map(entidad => {
                    if ( ( entidad.nombreEntidad.toLowerCase() ).includes( (this.buscarNombreEntidad).toLowerCase() ) ) {
                        existe = true;
                        nombres.push(entidad);
                    }
                    })
                    this.nombresDeEntidadesRegistradas = nombres;
                    this.nombreExisteEnRegistroDeEntidades = existe;
                } else {
                    this.nombreExisteEnRegistroDeEntidades = false;
                    this.agregarNuevoNombreDeEntidad = false;
                    this.agregarNombreDeEntidadExistente = false;
                    this.newEntidad = {
                    nombreEntidad: '',
                    atributos: []
                    };
                }
            },

            verEntidadRegistrada(nombre){
                this.newEntidad = nombre;
                this.agregarNombreDeEntidadExistente = true;
            },

            verNuevoNombreDeEntidad(){
                this.newEntidad.nombreEntidad = this.buscarNombreEntidad;
                this.agregarNuevoNombreDeEntidad = true;
                this.registroDeEntidades.push(this.newEntidad);
                this.registrarNuevaEntidadEnBaseDeDatos(this.newEntidad.nombreEntidad);
            },

            registrarNuevaEntidadEnBaseDeDatos(nuevo_nombre_entidad){
              axios.post( "{{route('storeNewEntidad')}}", {'nombre_entidad': nuevo_nombre_entidad})
                .then(res => {
                  if (res.data.entidad_agregada) {
                    this.newEntidad.id = res.data.entidad_agregada.id;
                  }
                })
                .catch(err => {
                console.log(err)
              })
            },

            handleNewAtributo(){
                if (this.newAtributo.nombre === "") {
                    return;
                }

                if ( this.atributoValido(this.newAtributo.nombre) ) {
                    this.addNewAtributoValido(this.newAtributo.nombre); 
                } else {
                    this.atributoNoValidoParaSerAgregado = true;
                    setTimeout(() => {
                    this.atributoNoValidoParaSerAgregado = false;
                    }, 3000);
                }
            },

            atributoValido(nombre){
                for (let i = 0; i < this.newEntidad.atributos.length; i++) {
                    if (this.newEntidad.atributos[i].nombre === nombre) {
                    return false;
                    }
                }
                return true;
            },

            addNewAtributoValido(nombre){
                this.newEntidad.atributos.push({
                    nombre: nombre,
                    valores: []
                });
                this.newAtributo.nombre = "";
            },

            removeAtributo(name){
                this.newEntidad.atributos = this.newEntidad.atributos.filter(atributo => atributo.nombre !== name);
            },

            updateAtributosInDataBase(entidad){
              let obj = {
                entidad_id: entidad.id,
                atributos: JSON.stringify(entidad.atributos),
              }

              axios.post( "{{route('updateAtributosDeEntidad')}}", obj)
                .then(res => {
                  console.log(res.data);
                })
                .catch(err => {
                console.log(err)
              })
            },

            handleNewValor(request){
                this.newEntidad.atributos.map(atributo => {
                    if (atributo.nombre === request.atributoNombre) {
                    atributo.valores.push(request.newValor);
                    }
                })
            },

            removeIncomingValue(request){
                this.newEntidad.atributos.map(atributo => {
                    if (atributo.nombre === request.atributo) {
                    atributo.valores = atributo.valores.filter(valor => valor !== request.value)
                    }
                })
            },

            removeProductNameRegistered(nombre, id){
              this.borrarEntidadExistenteEnBaseDeDatos(id);
                this.registroDeEntidades = this.registroDeEntidades.filter(producto => producto.nombreEntidad !== nombre);
                this.nombresDeEntidadesRegistradas = this.nombresDeEntidadesRegistradas.filter(producto => producto.nombreEntidad !== nombre);
                this.newEntidad = {
                  id: null,
                  nombreEntidad: '',
                  atributos: []
                };
                this.agregarNombreDeEntidadExistente = false;
            },

            borrarEntidadExistenteEnBaseDeDatos(entidad_id){
              axios.post( "{{route('borrarEntidadExistente')}}", {"entidad_id": entidad_id})
                .then(res => {
                  console.log(res.data);
                }).catch(err => {
                console.log(err)
              })
            },

            handleNuevaCompra(){
              this.registrarNuevaCompraEnBaseDeDatos(this.formCompra);
              this.formCompra = {
                  nombreDeEntidadSeleccionadaParaComprar: "",
                  cantidadItemsEnCompra: null,
                  montoTotalPagado: null,
                  costoPorUnidad: null,
                  precioSugerido: null,
                  enlaceURLDeLaCompra: null,
                  atributos: {}
              };
              setTimeout(() => {
                this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
              }, 500);
            },

            handleCambioDeStatusDeCompra(compra_id, tipo_de_cambio){
              this.cambiarStatusDeLaCompraConId = compra_id;
              switch (tipo_de_cambio) {
                case 'sin_recibir':
                  document.querySelector('#button_show_modal_cambiar_status_compra_SIN_RECIBIR').click();
                  break;
                case 'recibida':
                  document.querySelector('#button_show_modal_cambiar_status_compra_recibida').click();
                  break;
              
                default:
                  break;
              }

            },

            cambiarStatusDeCompra(tipo_de_cambio){
              switch (tipo_de_cambio) {
                case 'compra_recibida':
                  this.cambiarStatus_de_compra_a_Recibida();
                  setTimeout(() => {
                    this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
                    this.traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos();
                  }, 500);
                  break;
                case 'compra_pendiente':
                  this.cambiarStatus_de_compra_a_Pendiente();
                  setTimeout(() => {
                    this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
                    this.traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos();
                  }, 500);
                  break;
              
                default:
                  break;
              }
            },

            cambiarStatus_de_compra_a_Pendiente(){
              axios.post( "{{route('CambiarStatusDeCompraAPendiente')}}", {compra_id: this.cambiarStatusDeLaCompraConId})
                .then(res => {
                  console.log(res.data);  
                }).catch(err => {
                console.log(err)
              })
              document.querySelector('#cerrar_modal_cambio_de_status_a_recibida').click();
            },

            cambiarStatus_de_compra_a_Recibida(){
              axios.post( "{{route('CambiarStatusDeCompraARecibida')}}", {compra_id: this.cambiarStatusDeLaCompraConId})
                .then(res => {
                  console.log(res.data);  
                }).catch(err => {
                console.log(err)
              })
              document.querySelector('#cerrar_modal_cambio_de_status_a_pendiente').click();
            },

            registrarNuevaCompraEnBaseDeDatos(nueva_compra){
              axios.post( "{{route('registrarNuevaCompra')}}", nueva_compra)
                .then(res => {
                  console.log(res.data);  
                }).catch(err => {
                console.log(err)
              })
            },

            handleCompraRegistrada(id){
                this.comprasRegistradasYPendientes = this.comprasRegistradasYPendientes.filter(compra => compra.id !== id);
            },

            eliminarCompra(id){
              axios.post( "{{route('eliminarCompraRegistrada')}}", {compra_id: id})
                .then(res => {
                   console.log(res.data);
                }).catch(err => {
                console.log(err)
              })
              setTimeout(() => {
                this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
                this.traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos();
              }, 1000);
            },

            traerTodasLasEntidadesRegistradasDeBaseDeDatos(){
              axios.get( "{{route('entidadesRegistradas')}}")
                .then(res => {
                    res.data.entidades_registradas.forEach(entidad_registrada => {
                      let nueva_entidad = {
                        id: entidad_registrada.id,
                        nombreEntidad: entidad_registrada.nombre,
                        atributos: JSON.parse(entidad_registrada.atributos),
                      }
                      this.registroDeEntidades.push(nueva_entidad);
                    })
                }).catch(err => {
                console.log(err)
              })
            },

            traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos(){
              axios.get( "{{route('comprasRegistradasYPendientes')}}")
                .then(res => {
                  console.log(res.data.compras_registradas);
                  this.comprasRegistradasYPendientes = res.data.compras_registradas;
                }).catch(err => {
                console.log(err)
              })
            },

            traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos(){
              axios.get( "{{route('comprasRegistradasYRecibidas')}}")
                .then(res => {
                  console.log(res.data.compras_registradas);
                  this.comprasRegistradasYRecibidas = res.data.compras_registradas;
                }).catch(err => {
                console.log(err)
              })
            },

            getStatusDeLaCompra(number){
              let response = null;
              switch (number) {
                case "1": response = 'En espera'; break;
                case "2": response = 'Recibida'; break;
              
                default: break;
              }
              return response;
            },

            getDateFormatted(value){
              return moment(String(value)).format('DD/MM/YYYY HH:mm');
            },

            getDate_inAgoFormat(value){
              return moment(String(value)).fromNow();
            }
        }, // end methods


        watch: {
          newEntidad: {
            deep: true,

            handler(newVal){
              this.registroDeEntidades = this.registroDeEntidades.map(producto => {
                    if (producto.nombreEntidad === this.newEntidad.nombreEntidad) {
                    return newVal;
                    }
                    return producto;
                })
                if (newVal.id !== undefined) {
                  this.updateAtributosInDataBase(newVal);
                }
            }
          }

        }, // end watch

        computed: {
            atributosAMostrar(){
                let response = [];
                if (this.formCompra.nombreDeEntidadSeleccionadaParaComprar === "") {
                    return [];
                }
                let producto = this.registroDeEntidades.filter(producto => producto.nombreEntidad === this.formCompra.nombreDeEntidadSeleccionadaParaComprar);
                response = producto.map(producto => producto.atributos);
                return response[0];
            },

            costoUnitario(){
                let response = null;
                if ( this.formCompra.cantidadItemsEnCompra !== null && this.formCompra.montoTotalPagado !== null ) {
                    response = ( parseFloat(this.formCompra.montoTotalPagado) / parseFloat(this.formCompra.cantidadItemsEnCompra) ).toFixed(2);
                }
                this.formCompra.costoPorUnidad = response;
                return response;
            }
        },

        mounted: function() {
          this.traerTodasLasEntidadesRegistradasDeBaseDeDatos();
          this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
          this.traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos();
        },

        })






        application.component('TarjetaDeAtributo', {
        template:/* vue-html */`
        <div>
            <div class="card m-2" style="width: 18rem;">
                <div class="card-body">
                <h5 class="card-title">
                    <div class="row" v-if="!atributoEnEdicion">
                    <div class="col">
                        <strong>@{{ atributo.nombre }}</strong>
                    </div>
                    <div class="col text-right">
                        <a @click.prevent="atributoEnEdicion = !atributoEnEdicion" href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                        <a @click.prevent="removeAtributo(atributo.nombre)" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                    </div>
                    </div>

                    <div class="row" v-else-if="atributoEnEdicion">
                    <div class="col">
                        <form>
                            <div class="form-group text-center">
                            <div class="input-group mb-2">
                                <input v-model="atributo.nombre" type="text" class="form-control">
                                <div class="input-group-append">
                                <button @click.prevent="atributoEnEdicion = !atributoEnEdicion" class="input-group-text btn btn-outline-danger"><i class="fas fa-times-circle"></i></button>
                                </div>
                            </div>
                            </div>
                        </form>
                    </div>
                    </div>

                </h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(valor, pos) in atributo.valores" :key="pos">
                    <div class="row">
                        <div class="col">
                        @{{ valor }}
                        </div>
                        <div class="col">
                            <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                            <a @click.prevent="removeValue(valor, atributo.nombre)" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                        </div>
                    </div>
                    </li>
                    <li class="list-group-item">
                    <form>
                        <div class="form-group text-center">
                        <div class="input-group mb-2">
                            <input v-model="newValor" type="text" class="form-control" placeholder="Nuevo Valor...">
                            <div class="input-group-append">
                                <button @click.prevent="handleNewValor(atributo.nombre)" class="input-group-text btn btn-outline-success"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>
                        </div>
                    </form>
                    </li>
                </ul>
            </div>
        </div>
        `,
        data(){
            return {
                atributoEnEdicion: false,
                newAtributo: "",
                newValor: ""
            }
        },

        props: ['atributo', 'removeAtributo'],

        methods: {
            handleNewValor(atributoNombre){
                if (this.newValor === "") {
                    return;
                }

                let obj = {
                    atributoNombre,
                    newValor: this.newValor
                }
                this.$emit('new-valor', obj);
                this.newValor = "";
            },

            removeValue(value, atributo){
                let obj = {
                    value,
                    atributo
                }
                this.$emit('remove-valor', obj);
            }
        } // end Methods
        })


        application.mount('#appVue')
    </script>
@endsection