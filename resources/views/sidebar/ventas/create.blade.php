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
                    <input @input="handle_search_entity" list="entities" name="entity" id="entity">

                    <datalist id="entities">
                        @foreach ($entities as $entity)
                            <option value="{{ $entity->name }}">{{ $entity->name }}</option>
                        @endforeach
                    </datalist>
                </div>
            </div>
            <div class="row">
                <div class="col-3" style="max-height: 60vh; overflow-y:auto;">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12" v-for="(values, attribute) in AVAILABLE_ATTRIBUTES" :key="attribute">
                                    <label :for="`atributo_${attribute}`">
                                        @{{ attribute }}
                                        <select :data-attribute_name="attribute" :name="attribute" class="attribute form-control" :id="`atributo_${attribute}`">
                                            <option value="">Todos</option>
                                            <option v-for="value in values" :value="value">@{{ value }}</option>
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
                                <div class="col-12" v-for="product in FILTERED_PRODUCTS">
                                    <div class="card">
                                        <div class="card-body">
                                            <p>@{{ product }}</p>
                                        </div>
                                    </div>
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
                    AVAILABLE_PRODUCTS: [],
                    AVAILABLE_ATTRIBUTES: [],
                    FILTERED_PRODUCTS: [],
                }

            },

            methods: {
                async handle_search_entity(e){
                    await this.get_products_by_entity( e.target.value );
                },
                async get_products_by_entity( entity_name ){
                    let response = await axios.post("{{ route('entities.get_available_products_by_entity_name') }}", {entity_name}).then(res => res.data);
                    console.log( response )
                    this.AVAILABLE_PRODUCTS   = response.available_products;
                    this.FILTERED_PRODUCTS    = response.available_products;
                    this.AVAILABLE_ATTRIBUTES = response.attributes;
                }
            },

        })


        application.mount('#appVue')
    </script>
@stop
