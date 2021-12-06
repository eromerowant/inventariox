@extends('adminlte::page')

@section('title', 'Productos')

@section('css')
@stop

@section('content')
    <div id="appVue">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h1 class="text-center m-2">Nombre de la Entidad: {{ $entity->name }}</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row" v-for="attribute in ATRIBUTOS" :key="attribute.id">

                                                <div class="col-12">
                                                    <label>
                                                        @{{ attribute.name }}
                                                        <select :data-id="attribute.id" class="atributte_class" @change="filtrar_productos" :name="attribute.name" class="form-control">
                                                            <option value="">Todos</option>
                                                            <option v-for="value in attribute.values" :value="value.name">@{{ value.name }}</option>
                                                        </select>
                                                    </label>
                                                </div>
                                                    
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="card">
                                        <div class="card-body">
                                            <p class="text-center">Cantidad de productos: <b>@{{ FILTERED_PRODUCTS.length }}</b></p>
                                            <div class="row" v-for="(producto, index) in FILTERED_PRODUCTS" :key="producto.id">
                                                <div class="col-12">
                                                    <p>
                                                        <span v-for="valor in producto.values">@{{ index+1 }} - @{{ valor.attribute.name }}: <b>@{{ valor.name }}</b></span>
                                                        (Compra: @{{ producto.purchase.created_at }})
                                                    </p>
                                                    <hr class="hr">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
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
        
        const application = createApp({
            el: '#appVue',
            data() {
                return {
                    ATRIBUTOS: {!! $atributos !!},
                    PRODUCTOS: {!! $productos !!},
                    FILTERED_PRODUCTS: {!! $productos !!},
                }

            },

            methods: {
                filtrar_productos(){
                    let elementos = document.getElementsByClassName('atributte_class');
                    let fitered_products_temp = this.PRODUCTOS;
                    for (let i = 0; i < elementos.length; i++) {
                        const el = elementos[i];
                        const selector_id    = el.dataset.id;
                        const selector_value = el.value;

                        if ( selector_value ) {
                            fitered_products_temp = fitered_products_temp.filter(item => {
                                let response = item.values.filter( val => val.name === selector_value );
                                if ( response.length ) {
                                    return true;
                                } else {
                                    return false;
                                }
                            })
                        }
                        
                    }
                    this.FILTERED_PRODUCTS = fitered_products_temp;
                },
            },

        })


        application.mount('#appVue')
    </script>
@stop
