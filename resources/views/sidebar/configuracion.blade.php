@extends('adminlte::page')

@section('title', 'Dashboard')

@section('css')
@stop

@section('content_header')
    {{-- Plantilla => https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Usage --}}
    <h1>Configuración</h1>
@stop

@section('content')
    <div id="appVue">

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

    </div>
@stop

@section('js')
    <!-- VUEJS -->
    <script src="https://unpkg.com/vue@next"></script>

    {{-- AXIOS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"
        integrity="sha512-bZS47S7sPOxkjU/4Bt0zrhEtWx0y0CRkhEp8IckzK+ltifIIE9EMIMTuT/mEzoIMewUINruDBIR/jJnbguonqQ=="
        crossorigin="anonymous"></script>

    <!-- lodash -->
    <script src="https://cdn.jsdelivr.net/npm/lodash@4.17.20/lodash.min.js"></script>

    {{-- MOMENT-JS --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"
        integrity="sha512-qTXRIMyZIFb8iQcfjXWCO8+M5Tbc38Qi5WzdPOYZHIlZpzBHG3L3by84BBBOiRGiEb7KKtAOAs5qYdUiZiQNNQ=="
        crossorigin="anonymous"></script>

    <script>
        const {
            createApp
        } = Vue;

        let ejemplo_de_entidad = {
            nombreEntidad: 'Pestaña',
            atributos: [{
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

                    // Inventario
                    ejemplares_en_base_de_datos: [],
                    vistaInventario: {
                        nombre_seleccionado: null,
                        atributos_de_nombre_seleccionado: [],
                    },
                    actualizar_ejemplaresDesdeBaseDeDatos: false,
                }

            },

            methods: {
                findEntidad() {
                    if (this.buscarNombreEntidad.length > 2) {
                        let existe = false;
                        let nombres = [];
                        this.registroDeEntidades.map(entidad => {
                            if ((entidad.nombreEntidad.toLowerCase()).includes((this.buscarNombreEntidad)
                                    .toLowerCase())) {
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

                verEntidadRegistrada(nombre) {
                    this.newEntidad = nombre;
                    this.agregarNombreDeEntidadExistente = true;
                },

                verNuevoNombreDeEntidad() {
                    this.newEntidad.nombreEntidad = this.buscarNombreEntidad;
                    this.agregarNuevoNombreDeEntidad = true;
                    this.registroDeEntidades.push(this.newEntidad);
                    this.registrarNuevaEntidadEnBaseDeDatos(this.newEntidad.nombreEntidad);
                },

                registrarNuevaEntidadEnBaseDeDatos(nuevo_nombre_entidad) {
                    axios.post("{{ route('storeNewEntidad') }}", {
                            'nombre_entidad': nuevo_nombre_entidad
                        })
                        .then(res => {
                            if (res.data.entidad_agregada) {
                                this.newEntidad.id = res.data.entidad_agregada.id;
                            }
                        })
                        .catch(err => {
                            console.log(err)
                        })
                },

                handleNewAtributo() {
                    if (this.newAtributo.nombre === "") {
                        return;
                    }

                    if (this.atributoValido(this.newAtributo.nombre)) {
                        this.addNewAtributoValido(this.newAtributo.nombre);
                    } else {
                        this.atributoNoValidoParaSerAgregado = true;
                        setTimeout(() => {
                            this.atributoNoValidoParaSerAgregado = false;
                        }, 3000);
                    }
                },

                atributoValido(nombre) {
                    for (let i = 0; i < this.newEntidad.atributos.length; i++) {
                        if (this.newEntidad.atributos[i].nombre === nombre) {
                            return false;
                        }
                    }
                    return true;
                },

                addNewAtributoValido(nombre) {
                    this.newEntidad.atributos.push({
                        nombre: nombre,
                        valores: []
                    });
                    this.newAtributo.nombre = "";
                },

                removeAtributo(name) {
                    this.newEntidad.atributos = this.newEntidad.atributos.filter(atributo => atributo.nombre !==
                        name);
                },

                updateAtributosInDataBase(entidad) {
                    let obj = {
                        entidad_id: entidad.id,
                        atributos: JSON.stringify(entidad.atributos),
                    }

                    axios.post("{{ route('updateAtributosDeEntidad') }}", obj)
                        .then(res => {
                            console.log(res.data);
                        })
                        .catch(err => {
                            console.log(err)
                        })
                },

                handleNewValor(request) {
                    this.newEntidad.atributos.map(atributo => {
                        if (atributo.nombre === request.atributoNombre) {
                            atributo.valores.push(request.newValor);
                        }
                    })
                },

                removeIncomingValue(request) {
                    this.newEntidad.atributos.map(atributo => {
                        if (atributo.nombre === request.atributo) {
                            atributo.valores = atributo.valores.filter(valor => valor !== request.value)
                        }
                    })
                },

                removeProductNameRegistered(nombre, id) {
                    this.borrarEntidadExistenteEnBaseDeDatos(id);
                    this.registroDeEntidades = this.registroDeEntidades.filter(producto => producto
                        .nombreEntidad !== nombre);
                    this.nombresDeEntidadesRegistradas = this.nombresDeEntidadesRegistradas.filter(producto =>
                        producto.nombreEntidad !== nombre);
                    this.newEntidad = {
                        id: null,
                        nombreEntidad: '',
                        atributos: []
                    };
                    this.agregarNombreDeEntidadExistente = false;
                },

                borrarEntidadExistenteEnBaseDeDatos(entidad_id) {
                    axios.post("{{ route('borrarEntidadExistente') }}", {
                            "entidad_id": entidad_id
                        })
                        .then(res => {
                            console.log(res.data);
                        }).catch(err => {
                            console.log(err)
                        })
                },

                handleNuevaCompra() {
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

                handleCambioDeStatusDeCompra(compra_id, tipo_de_cambio) {
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

                cambiarStatusDeCompra(tipo_de_cambio) {
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

                cambiarStatus_de_compra_a_Pendiente() {
                    axios.post("{{ route('CambiarStatusDeCompraAPendiente') }}", {
                            compra_id: this.cambiarStatusDeLaCompraConId
                        })
                        .then(res => {
                            console.log(res.data);
                        }).catch(err => {
                            console.log(err)
                        })
                    document.querySelector('#cerrar_modal_cambio_de_status_a_recibida').click();
                },

                cambiarStatus_de_compra_a_Recibida() {
                    axios.post("{{ route('CambiarStatusDeCompraARecibida') }}", {
                            compra_id: this.cambiarStatusDeLaCompraConId
                        })
                        .then(res => {
                            console.log(res.data);
                        }).catch(err => {
                            console.log(err)
                        })
                    document.querySelector('#cerrar_modal_cambio_de_status_a_pendiente').click();
                },

                registrarNuevaCompraEnBaseDeDatos(nueva_compra) {
                    axios.post("{{ route('registrarNuevaCompra') }}", nueva_compra)
                        .then(res => {
                            console.log(res.data);
                        }).catch(err => {
                            console.log(err)
                        })
                },

                handleCompraRegistrada(id) {
                    this.comprasRegistradasYPendientes = this.comprasRegistradasYPendientes.filter(compra => compra
                        .id !== id);
                },

                eliminarCompra(id) {
                    axios.post("{{ route('eliminarCompraRegistrada') }}", {
                            compra_id: id
                        })
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

                // antiRebote: _.debounce(function (callback, args) {
                //   callback(args);
                // }, 3000),

                traerTodasLasEntidadesRegistradasDeBaseDeDatos() {
                    axios.get("{{ route('entidadesRegistradas') }}")
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

                traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos() {
                    axios.get("{{ route('comprasRegistradasYPendientes') }}")
                        .then(res => {
                            console.log(res.data.compras_registradas);
                            this.comprasRegistradasYPendientes = res.data.compras_registradas;
                        }).catch(err => {
                            console.log(err)
                        })
                    this.actualizar_ejemplaresDesdeBaseDeDatos = true;
                },

                traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos() {
                    axios.get("{{ route('comprasRegistradasYRecibidas') }}")
                        .then(res => {
                            console.log(res.data.compras_registradas);
                            this.comprasRegistradasYRecibidas = res.data.compras_registradas;
                        }).catch(err => {
                            console.log(err)
                        })
                    this.actualizar_ejemplaresDesdeBaseDeDatos = true;
                },

                getStatusDeLaCompra(number) {
                    let response = null;
                    switch (number) {
                        case "1":
                            response = 'En espera';
                            break;
                        case "2":
                            response = 'Recibida';
                            break;

                        default:
                            break;
                    }
                    return response;
                },

                getEjemplaresEnBaseDeDatos() {
                    axios.get("{{ route('VerEjemplares') }}")
                        .then(res => {
                            this.ejemplares_en_base_de_datos = res.data.ejemplares;
                        }).catch(err => {
                            console.log(err)
                        })
                    this.actualizar_ejemplaresDesdeBaseDeDatos = false;
                    this.vistaInventario.nombre_seleccionado = null;
                    this.vistaInventario.atributos_de_nombre_seleccionado = [];
                },

                handleNombreDeEjemplarSeleccionado(nombre_de_ejemplar_seleccionado) {
                    this.vistaInventario.nombre_seleccionado = nombre_de_ejemplar_seleccionado;
                    this.vistaInventario.atributos_de_nombre_seleccionado = this.ejemplares_en_base_de_datos[
                        nombre_de_ejemplar_seleccionado];
                },

                getDateFormatted(value) {
                    return moment(String(value)).format('DD/MM/YYYY HH:mm');
                },

                getDate_inAgoFormat(value) {
                    return moment(String(value)).fromNow();
                }
            }, // end methods


            watch: {
                newEntidad: {
                    deep: true,

                    handler(newVal) {
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
                },

                actualizar_ejemplaresDesdeBaseDeDatos(newVal) {
                    if (newVal) {
                        console.log('se actualizaron los ejemplares desde base de datos');
                        this.getEjemplaresEnBaseDeDatos();
                    }
                },

            }, // end watch

            computed: {
                atributosAMostrar() {
                    let response = [];
                    if (this.formCompra.nombreDeEntidadSeleccionadaParaComprar === "") {
                        return [];
                    }
                    let producto = this.registroDeEntidades.filter(producto => producto.nombreEntidad === this
                        .formCompra.nombreDeEntidadSeleccionadaParaComprar);
                    response = producto.map(producto => producto.atributos);
                    return response[0];
                },

                costoUnitario() {
                    let response = null;
                    if (this.formCompra.cantidadItemsEnCompra !== null && this.formCompra.montoTotalPagado !==
                        null) {
                        response = (parseFloat(this.formCompra.montoTotalPagado) / parseFloat(this.formCompra
                            .cantidadItemsEnCompra)).toFixed(2);
                    }
                    this.formCompra.costoPorUnidad = response;
                    return response;
                }
            },

            mounted: function() {
                this.traerTodasLasEntidadesRegistradasDeBaseDeDatos();
                this.traerTodasLasComprasRegistradasYPendientesDeBaseDeDatos();
                this.traerTodasLasComprasRegistradasYRecibidasDeBaseDeDatos();
                this.actualizar_ejemplaresDesdeBaseDeDatos = true;
            },

        })






        application.component('TarjetaDeAtributo', {
            template: /* vue-html */ `
            <div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                    <h5 class="card-title">
                        <div class="row" v-if="!atributoEnEdicion">
                        <div class="col">
                            <strong>@{{ atributo . nombre }}</strong>
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
            data() {
                return {
                    atributoEnEdicion: false,
                    newAtributo: "",
                    newValor: ""
                }
            },

            props: ['atributo', 'removeAtributo'],

            methods: {
                handleNewValor(atributoNombre) {
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

                removeValue(value, atributo) {
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
@stop
