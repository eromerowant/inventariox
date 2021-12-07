@extends('adminlte::page')

@section('title', 'Compras')

@section('css')
@stop

@section('content')
   <div id="appVue">

        {{-- nueva-venta --}}
        <div class="container-fluid">
            <div class="row text-center">
                <div class="col">
                    <h3>Registra una Nueva Venta:</h3>
                </div>
            </div>
            <div class="row text-center">
                <div class="col">
                    <label for="entity">Escoge el nombre del producto: </label>
                    <input @input="handle_selected_entity" list="entities" name="entity" id="entity">

                    <datalist id="entities">
                        <option v-for="entity in ENTITIES_IN_DATABASE" :key="entity.id" :value="entity.name"></option>
                    </datalist>
                </div>
            </div>

            <div class="row">
                <div class="col-3" style="max-height: 60vh; overflow-y:auto;">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="h5">Atributos</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" v-for="(attribute, index) in AVAILABLE_ATTRIBUTES" :key="attribute.id">
                                    <label :for="`atributo_${attribute.id}`">
                                        @{{ attribute.name }} 
                                        <select :data-attribute_name="attribute.name" :name="attribute.name" class="attribute form-control" :id="`atributo_${attribute.id}`">
                                            <option value="">Todos</option>
                                            <option v-for="value in attribute.values" :value="value.name">@{{ value.name }}</option>
                                        </select>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-9">
                    <div class="card" style="max-height: 60vh; overflow-y:auto;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="h5">Disponibilidad:</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12" v-for="combination in ATTRIBUTE_COMBINATIONS">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>@{{ combination }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="h5">Cesta</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        {{-- /nueva-venta --}}

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
        
        const application = createApp({
            el: '#appVue',
            data() {
                return {
                    ENTITIES_IN_DATABASE: [],
                    AVAILABLE_ATTRIBUTES: [],
                    ATTRIBUTE_COMBINATIONS: [],
                    
                }

            },

            methods: {
                async handle_selected_entity(e){
                    let entity_selected = this.ENTITIES_IN_DATABASE.find( item => item.name === e.target.value );
                    this.AVAILABLE_ATTRIBUTES = entity_selected ? entity_selected.attributes : [];
                },

                async get_entities_from_database() {
                    this.ENTITIES_IN_DATABASE = await axios.get("{{ route('entities.get_entities') }}").then(res => res.data.entities);
                    console.log( this.ENTITIES_IN_DATABASE )
                },
            },

            mounted: async function() {
                await this.get_entities_from_database();
            },

        })


        application.mount('#appVue')
    </script>
@stop
