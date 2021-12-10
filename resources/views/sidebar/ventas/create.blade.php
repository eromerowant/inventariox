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
                                        <select @change="show_attributes_selected" :data-attribute_name="attribute.name" :name="attribute.name" class="attribute form-control" :id="`atributo_${attribute.id}`">
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
                                    <h2 class="h5">Combinaciones Disponibles:</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-12">
                                                    <span v-for="valor in ATTRIBUTES_COMBINATION.combinacion"><strong> @{{ valor+", " }}</strong> </span>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <h2 class="h4 text-center">
                                                        Cantidad Disponible: <strong>@{{ ATTRIBUTES_COMBINATION.cantidad }}</strong>
                                                    </h2>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <p>¿Cuántos deseas agregar a la cesta?</p>
                                                </div>
                                                <div class="col-3">
                                                    <input id="cantidad_de_productos" class="form-control" type="number" min="0">
                                                </div>
                                                <div class="col-3">
                                                    <button @click="handle_cesta" type="button" class="btn btn-success">+</button>
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

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <h2 class="h5">Cesta</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" v-for="(entity, index) in CESTA" :key="entity.entity_name">
                                        <div class="card-body" v-if="index != 0">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="h6"><strong>@{{ entity.entity_name }}</strong></p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card" v-for="combination in entity.combinations">
                                                        <div class="card-body">
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <span><strong>@{{ combination.name+", " }}</strong></span>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-12">
                                                                    <p>Cantidad de productos: <strong>@{{ combination.products.length }}</strong></p>
                                                                    <p v-for="(product, indice) in combination.products" :title="`id: ${product.id}`">
                                                                        @{{ indice+1 }}) 
                                                                        Costo Unitario: @{{ product.single_cost_when_bought }}, 
                                                                        Precio Sugerido: @{{ product.suggested_price }}
                                                                    </p>
                                                                    <hr>
                                                                    <p>Total Unitario: @{{ combination.products }}</p>
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
                    SELECTED_COMBINATION: [],
                    CESTA: [
                        {
                            entity_name: "",
                            combinations: [
                                {
                                    name: "",
                                    products: [],
                                },
                            ]
                        }
                    ],
                    FILTERED_AVAILABLE_PRODUCTS: [],
                    
                }

            },

            methods: {
                async handle_selected_entity(e){
                    let entity_selected = this.ENTITIES_IN_DATABASE.find( item => item.name === e.target.value );
                    this.AVAILABLE_ATTRIBUTES = entity_selected ? entity_selected.attributes : [];
                    this.SELECTED_COMBINATION = [];
                    this.FILTERED_AVAILABLE_PRODUCTS = [];
                },

                async get_entities_from_database() {
                    this.ENTITIES_IN_DATABASE = await axios.get("{{ route('entities.get_entities') }}").then(res => res.data.entities);
                    // console.log( this.ENTITIES_IN_DATABASE )
                },

                async show_attributes_selected(){
                    let entity_selected = document.getElementById('entity').value;
                    let selectores = document.getElementsByClassName("attribute");
                    for (var i = 0; i < selectores.length; i++) {
                        selectores.item(i).classList.remove('bg-danger')
                        selectores.item(i).classList.add('bg-success')
                        if ( !selectores.item(i).value ) {
                            selectores.item(i).classList.remove('bg-success')
                            selectores.item(i).classList.add('bg-danger')
                            return;
                        }
                    }

                    let obj = {
                        combination: [],
                        entity_selected: entity_selected,
                        product_ids: [],
                    };
                    for (var i = 0; i < selectores.length; i++) {
                        obj.combination.push( selectores.item(i).value );
                    }
                    this.SELECTED_COMBINATION = obj.combination;
                    this.CESTA.map(entity => {
                        console.log('revisemos las entidades en la cesta:')
                        if ( entity.entity_name === entity_selected ) {
                            console.log(`la entidad existe ${entity_selected} en la cesta`);
                            entity.combinations.map(com => {
                                console.log(`combinacion: ${JSON.stringify(com.name.sort())}`);
                                console.log(`combinacion: ${JSON.stringify(this.SELECTED_COMBINATION.sort())}`);
                                if ( JSON.stringify(com.name.sort()) == JSON.stringify(this.SELECTED_COMBINATION.sort()) ) {
                                    console.log(`combinacion IDENTICA: ${com.name}`);
                                    com.products.map(prod => {
                                        console.log(`producto en cesta: ${prod.id}`);
                                        obj.product_ids.push( prod.id );
                                    })
                                }
                            })
                        }
                    })
                    this.FILTERED_AVAILABLE_PRODUCTS = await axios.post("{{ route('products.get_filtered_available_products') }}", obj).then(res => res.data);

                },

                async handle_cesta(){
                    let selected_quantity = document.getElementById('cantidad_de_productos').value;
                    if ( !selected_quantity ) { console.log('sin valor'); return;}
                    if ( selected_quantity > this.FILTERED_AVAILABLE_PRODUCTS.length) {console.log('la cantidad es mayor a la disponible');return;}
                    
                    let entity = document.getElementById('entity').value;
                    let products = this.FILTERED_AVAILABLE_PRODUCTS.splice(0, selected_quantity);
                    await this.agregar_a_la_cesta( products, entity );
                    document.getElementById('cantidad_de_productos').value = null;
                },

                async agregar_a_la_cesta( productos, nombre_entidad ){
                    let has_entity = this.CESTA.filter( item => item.entity_name.includes(nombre_entidad) )
                    if ( !has_entity.length ) {
                        console.log( 'la entida ', nombre_entidad, ' no existe, y se crea.' );
                        let new_obj = {
                            entity_name: nombre_entidad,
                            combinations: [
                                {
                                    name: [...this.SELECTED_COMBINATION].sort(),
                                    products: [...productos],
                                }
                            ]
                        }
                        this.CESTA.push( new_obj );
                    } else {
                        console.log( 'la entida ', nombre_entidad, ' ya existe.' )
                        this.CESTA = this.CESTA.map(entity => {
                            if ( !entity.entity_name.includes(nombre_entidad) ) {
                                console.log("la entidad ya existe, pero no está en esta iteración, así que sus combinaciones no se cambiaron: ", entity.entity_name);
                                return entity;
                            }
                            console.log( "ahora si estamos en la iteracion con la entidad correcta ", nombre_entidad );
                            let has_combination = entity.combinations.filter(com => JSON.stringify(com.name.sort()) == JSON.stringify([...this.SELECTED_COMBINATION].sort()) )

                            if ( has_combination.length ) {
                                console.log( 'la combinación ya existe, procedemos a agregar los productos en esta combinación.' )
                                entity.combinations = entity.combinations.map(com => {
                                    if ( JSON.stringify(com.name.sort()) == JSON.stringify([...this.SELECTED_COMBINATION].sort()) ) {
                                        console.log( 'se agregan los productos en la combinacion ', com.name );
                                        com.products = [...com.products, ...productos]
                                    }
                                    return com;
                                })
                            } else {
                                console.log( 'la combinación NO existe, la creamos como nueva.' )
                                // creamos la nueva combinación con sus productos
                                entity.combinations = [
                                    ...entity.combinations,
                                    {
                                        name: [...this.SELECTED_COMBINATION].sort(),
                                        products: [...productos],
                                    }
                                ]
                            }

                            return entity;
                           
                        })
                    }
                },
            },

            mounted: async function() {
                await this.get_entities_from_database();
            },

            computed: {
                ATTRIBUTES_COMBINATION(){
                    return {
                        cantidad: this.FILTERED_AVAILABLE_PRODUCTS.length,
                        combinacion: this.SELECTED_COMBINATION,
                    };
                }
            },

        })


        application.mount('#appVue')
    </script>
@stop
