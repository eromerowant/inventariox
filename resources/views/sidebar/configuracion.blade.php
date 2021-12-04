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
            <!-- USER INPUT -->
            <div class="row mt-3">
                <form>
                    <div class="form-group">
                        <label for="formGroupExampleInput">Nombre de la Entidad:</label>
                        <input @keyup.prevent="handleUserInput" v-model="WORD_TO_SEARCH" type="text" class="form-control" placeholder="Buscar...">
                    </div>
                </form>
            </div>

            <div class="row">
                {{-- PASO UNO --}}
                <div class="col-3">
                    <!-- entidad REGISTRADA -->
                    <ul v-if="IS_WORD_IN_DB_ENTITIES">
                        <li v-for="(entity, index) in ENTITIES_LIKE_QUERY" :key="index">
                            <a href="#" @click.prevent="showRegisteredEntity(entity)">
                                Entidad registrada: <strong>@{{ entity.name }} (@{{ entity.attributes.length }} atributos)</strong>
                            </a>
                        </li>
                    </ul>
                    
                    <!-- entidad NUEVA -->
                    <div v-else-if="!IS_WORD_IN_DB_ENTITIES && WORD_TO_SEARCH.length > 0">
                        <a @click.prevent="handleNewPossibleEntity" href="#">
                            <p>Registrar <strong>@{{ WORD_TO_SEARCH }}</strong> como nuevo nombre de entidad</p>
                        </a>
                    </div>
                    
                    {{-- TODAS --}}
                    <ul v-else>
                        <li v-for="(entity, index) in ENTITIES_IN_DATABASE" :key="entity.id">
                            <a href="#" @click.prevent="showRegisteredEntity(entity)">
                                Ver <strong>@{{ entity.name }} (@{{ entity.attributes.length }} atributos)</strong>
                            </a>
                        </li>
                    </ul>

                </div>

                {{-- PASO DOS --}}
                <div class="col-9">
                    <!-- MOSTRAR ENTIDAD SELECCIONADA -->
                    <form v-if="SHOW_REGISTERED_ENTITY">
                        <div class="form-group text-center">
                            <label>Entidad</label>
                            <div class="input-group mb-2">
                                <input v-model="SELECTED_ENTITY.name" type="text" class="form-control text-center" readonly>
                                <div class="input-group-append">
                                    <a href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                                    <a @click.prevent="removeEntityFromDatabase" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                                </div>
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <label>Nombre del Atributo Nuevo</label>
                            <div class="input-group mb-2">
                                <input v-model="NEW_ATTRIBUTE_NAME" type="text" class="form-control" placeholder="Ejemplo: Tamaño">
                                <div class="input-group-append">
                                    <button @click.prevent="handleNewAtributo" class="input-group-text btn btn-outline-success">
                                        <i class="fa fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-col" v-for="(atributo, index) in SELECTED_ENTITY.attributes" :key="index">
                                <!-- TARJETAS - entidad registrada -->
                                <tarjeta-de-atributo 
                                    :atributo="atributo"
                                    :remove-atributo="removeAtributo"
                                    @new-valor="handleNewValor"
                                    @remove-valor="removeValueFromAttributeInDataBase"
                                    @change-attribute-name="changeAttributeName"
                                />
                                <!-- /TARJETAS - entidad registrada -->
                            </div>
                        </div>


                        
                    </form>

                </div>
            </div>
        

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

                    ENTITIES_IN_DATABASE: [], // esto se llena desde la base de datos (source of truth)

                    WORD_TO_SEARCH: "",

                    SELECTED_ENTITY: {
                        id: null,
                        name: '',
                        attributes: []
                    },

                    NEW_ATTRIBUTE_NAME: "",

                    IS_WORD_IN_DB_ENTITIES: false,
                    ENTITIES_LIKE_QUERY: [],
                    SHOW_REGISTERED_ENTITY: false,
                    DONT_ADD_ATTRIBUTE: false,

                }

            },

            methods: {
                handleUserInput() {
                    if ( this.WORD_TO_SEARCH.length > 0 ) {
                        this.ENTITIES_LIKE_QUERY = this.ENTITIES_IN_DATABASE.filter(item => item.name.toLowerCase().includes( (this.WORD_TO_SEARCH).toLowerCase() ))
                        if ( this.ENTITIES_LIKE_QUERY.length ) {
                            this.IS_WORD_IN_DB_ENTITIES = true;
                        } else {
                            this.IS_WORD_IN_DB_ENTITIES = false;    
                        }
                    } else {
                        this.ENTITIES_LIKE_QUERY = [];
                        this.IS_WORD_IN_DB_ENTITIES = false;
                        this.SHOW_REGISTERED_ENTITY = false;
                        this.SELECTED_ENTITY = {
                            id: null,
                            name: '',
                            attributes: []
                        };
                    }
                },

                showRegisteredEntity(nombre) {
                    this.SELECTED_ENTITY = this.ENTITIES_IN_DATABASE.find(item => item.id === nombre.id);
                    this.SHOW_REGISTERED_ENTITY = true;
                },

                async handleNewPossibleEntity() {
                    this.SELECTED_ENTITY.name = this.WORD_TO_SEARCH;
                    await this.registrarNuevaEntidadEnBaseDeDatos(this.SELECTED_ENTITY.name);
                },

                async registrarNuevaEntidadEnBaseDeDatos(nuevo_nombre_entidad) {
                    let response = await axios.post("{{ route('storeNewEntidad') }}", {'name': nuevo_nombre_entidad})
                        .then(res => res.data.entidad_registrada)
                        .catch(err => {console.error(err)})

                    this.ENTITIES_IN_DATABASE.push( response )
                    this.SELECTED_ENTITY = response;
                    this.SHOW_REGISTERED_ENTITY = true;
                },

                async handleNewAtributo() {
                    let name          = this.NEW_ATTRIBUTE_NAME;
                    let entidad_id    = this.SELECTED_ENTITY.id;
                    let new_attribute = await axios.post("{{ route('addNewAttributeInDataBase') }}", {name, entidad_id}).then(res =>res.data);
                    this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.map(item => {
                        if ( item.id === entidad_id ) {
                            item.attributes = [...item.attributes, new_attribute];
                        }
                        return item;
                    });
                    this.NEW_ATTRIBUTE_NAME = "";
                },

                addNewAtributoValido(nombre) {
                    this.SELECTED_ENTITY.attributes.push({
                        name: nombre,
                        valores: []
                    });
                    this.newAtributo.nombre = "";
                },

                async removeAtributo(attribute_id) {
                    let entity = await axios.delete("{{ route('removeAttributeFromEntity') }}", {data: {attribute_id}}).then(res => res.data);
                    this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.map(item => {
                        if ( item.id === entity.id ) {
                            return entity;
                        }
                        return item;
                    });
                    this.SELECTED_ENTITY = entity;
                },

                async handleNewValor(request) {
                    let entity = await axios.post("{{ route('addNewValueToPossibleAttribute') }}", request).then(res => res.data);
                    this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.map(item => {
                        if ( item.id === entity.id ) {
                            return entity;
                        }
                        return item;
                    });
                    this.SELECTED_ENTITY = entity;
                },

                async removeValueFromAttributeInDataBase(request) {
                    let entity = await axios.delete("{{ route('removeValueFromAttributeInDatabase') }}", {data: {value_id: request}}).then(res => res.data);
                    this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.map(item => {
                        if ( item.id === entity.id ) {
                            return entity;
                        }
                        return item;
                    });
                    this.SELECTED_ENTITY = entity;
                },

                async changeAttributeName(request){
                    let entity = await axios.post("{{ route('updateAttributeInEntity') }}", request).then(res => res.data)
                    this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.map(item => {
                        if ( item.id === entity.id ) {
                            return entity;
                        }
                        return item;
                    });
                    this.SELECTED_ENTITY = entity;
                },

                async removeEntityFromDatabase() {
                    let entidad_id = this.SELECTED_ENTITY.id;
                    let response = await axios.delete("{{ route('borrarEntidadExistente') }}", {data: {entidad_id}})
                    if ( response.statusText === "OK" ) {
                        this.ENTITIES_IN_DATABASE = this.ENTITIES_IN_DATABASE.filter(item => item.id !== entidad_id);
    
                        this.SELECTED_ENTITY = {
                            id: null,
                            name: '',
                            attributes: []
                        };
    
                        this.SHOW_REGISTERED_ENTITY = false;
                    }

                },

                // antiRebote: _.debounce(function (callback, args) {
                //   callback(args);
                // }, 3000),

                async getEntitiesFromDataBase() {
                    this.ENTITIES_IN_DATABASE = await axios.get("{{ route('entidadesRegistradas') }}")
                        .then(res => res.data.entidades_registradas)
                        .catch(err => {console.error(err)});
                },

            }, // end methods

            mounted: async function() {
                await this.getEntitiesFromDataBase();
            },

        })






        application.component('TarjetaDeAtributo', {
            template: /* vue-html */ `
            <div>
                <div class="card m-2" style="width: 18rem;">
                    <div class="card-body">
                        <div class="row" v-if="!atributoEnEdicion">
                            <div class="col">
                                <strong>@{{ atributo.name }}</strong>
                            </div>
                            <div class="col text-right">
                                <a @click.prevent="atributoEnEdicion = !atributoEnEdicion" href="#" class="btn btn-outline-info btn-sm"><i class="fas fa-edit"></i></a>
                                <a @click.prevent="removeAtributo(atributo.id)" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                            </div>
                        </div>

                        <div class="row" v-else-if="atributoEnEdicion">
                            <div class="col">
                                <form>
                                    <div class="form-group text-center">
                                    <div class="input-group mb-2">
                                        <input @change="handleAttributeInput($event, atributo)" type="text" class="form-control" :value="atributo.name" >
                                        <div class="input-group-append">
                                            <button @click.prevent="atributoEnEdicion = !atributoEnEdicion" class="input-group-text btn btn-outline-danger"><i class="fas fa-times-circle"></i></button>
                                        </div>
                                    </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item" v-for="(valor, pos) in atributo.values" :key="pos">
                            <div class="row">
                                <div class="col">
                                    @{{ valor.name }}
                                </div>
                                <div class="col text-right">
                                    <a @click.prevent="removeValueInCard(valor.id)" href="#" class="btn btn-outline-danger btn-sm"><i class="fas fa-times-circle"></i></a>
                                </div>
                            </div>
                        </li>
                        <li class="list-group-item">
                            <form>
                                <div class="form-group text-center">
                                    <div class="input-group mb-2">
                                        <input v-model="newValor" type="text" class="form-control" placeholder="Nuevo Valor...">
                                        <div class="input-group-append">
                                            <button @click.prevent="handleNewValueInCard(atributo.id)" class="input-group-text btn btn-outline-success"><i class="fa fa-plus"></i></button>
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
                    newValor: "",
                    attributeName: this.atributo.name,
                }
            },

            props: ['atributo', 'removeAtributo'],

            methods: {
                handleNewValueInCard(attr_id) {
                    if (this.newValor === "") {return;}
                    let newValue = this.newValor;

                    this.$emit('new-valor', {attr_id, newValue});
                    this.newValor = "";
                },

                removeValueInCard(value_id) {
                    this.$emit('remove-valor', value_id);
                },
                handleAttributeInput(e, attr){
                    let obj = {
                        new_value: e.target.value,
                        attribute_id: attr.id,
                    }
                    this.$emit('change-attribute-name', obj);
                },

            }, // end Methods

        })


        application.mount('#appVue')
    </script>
@stop
