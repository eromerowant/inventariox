@extends('adminlte::page')

@section('title', 'Compras')

@section('css')
@stop

@section('content')
   <div id="appVue">

        {{-- nueva-compra --}}
        <div class="container-fluid">

            <div class="row mt-3">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-center">Registra una Nueva Compra:</h3>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Selecciona el Producto:</label>
                                        <select @change="traerLaEntidadDeBaseDeDatos()" v-model="NUEVA_COMPRA.entidadSeleccionada" class="form-control" required>
                                            <option value="" disabled selected>-- Seleccione --</option>
                                            @foreach ($entidades as $entidad)
                                                <option value="{{ $entidad->name }}">{{ $entidad->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-for="atributo in ATRIBUTOS" :key="atributo.id">
    
                                <div class="col">
                                    <div class="form-group">
                                        <label>@{{ atributo.name }}</label>
                                        <select v-model="NUEVA_COMPRA.atributos_selected[atributo.name]" class="form-control" required>
                                            <option v-for="valor in atributo.values" :key="valor.id" :value="valor.name">@{{ valor.name }}</option>
                                        </select>
                                    </div>
                                </div>
    
                            </div>
                            <hr class="bg-dark">
                            <br>
    
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Cantidad de Unidades</label>
                                        <input v-model="NUEVA_COMPRA.cantidad_de_unidades" type="number" class="form-control" min="1" step="1" required>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Monto Total Pagado</label>
                                        <input v-model="NUEVA_COMPRA.monto_total_pagado" type="number" class="form-control" min="0" step="50" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label>Monto Unitario (c/u)</label>
                                        <input v-model="monto_unitario" type="number" class="form-control" readonly>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label>Precio Sugerido (c/u)</label>
                                        <input v-model="NUEVA_COMPRA.precio_sugerido" type="number" class="form-control" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <button @click.prevent="registrarNuevaCompraEnBaseDeDatos()" class="btn btn-outline-success">Registrar Compra</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- /nueva-compra --}}

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
                    ATRIBUTOS: [],

                    NUEVA_COMPRA: {
                        entidadSeleccionada: null,
                        cantidad_de_unidades: null,
                        monto_total_pagado: null,
                        precio_sugerido: null,
                        enlace_url: null,
                        atributos_selected: {},
                    }
                }

            },

            methods: {
                async traerLaEntidadDeBaseDeDatos(){
                    if ( !this.NUEVA_COMPRA.entidadSeleccionada ) {
                        this.ATRIBUTOS = [];
                        return;
                    }
                    let obj = {
                        entityName: this.NUEVA_COMPRA.entidadSeleccionada
                    };
                    this.ATRIBUTOS = await axios.post("{{ route('get_entidad') }}", obj).then(res => res.data);
                },
                registrarNuevaCompraEnBaseDeDatos: async function(){
                    if ( this.NUEVA_COMPRA.entidadSeleccionada === null ||
                         this.NUEVA_COMPRA.cantidad_de_unidades === null ||
                         this.NUEVA_COMPRA.monto_total_pagado === null || 
                         this.NUEVA_COMPRA.precio_sugerido === null ) {
                        console.log( 'por rellena todos los campos' );
                        return;
                    }

                    let nueva_compra = {
                        ...this.NUEVA_COMPRA,
                        costoPorUnidad: this.monto_unitario,
                    };
                    let ok = await axios.post( "{{route('registrarNuevaCompra')}}", nueva_compra)
                        .then(res => res.data);
                        if ( ok ) {
                            this.NUEVA_COMPRA = {
                                entidadSeleccionada: null,
                                cantidad_de_unidades: null,
                                monto_total_pagado: null,
                                precio_sugerido: null,
                                enlace_url: null,
                                atributos_selected: {},
                            };
                            console.log('compra registrada exitosamente');
                            alert('compra registrada exitosamente');
                        }
                },
            },
            computed: {
                monto_unitario(){
                    if ( this.NUEVA_COMPRA.cantidad_de_unidades && this.NUEVA_COMPRA.monto_total_pagado ) {
                        let monto_unitario = this.NUEVA_COMPRA.monto_total_pagado/this.NUEVA_COMPRA.cantidad_de_unidades;
                        return monto_unitario; // Recuerda formatear el numero
                    }
                }
            }

        })


        application.mount('#appVue')
    </script>
@stop
