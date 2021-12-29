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
                                    <h1 class="h5">Selecciona Los Atributos</h1>
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
                                    <h2 class="h3 text-center"><strong>Cesta</strong></h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="card" v-for="(entity, index) in CESTA" :key="entity.entity_name">
                                        <div class="card-body" v-if="index != 0">
                                            <div class="row mb-3">
                                                <div class="col-6">
                                                    <p class="h5"><strong class="bg-success">@{{ entity.entity_name }}</strong></p>
                                                </div>
                                                <div class="col-6 text-right">
                                                    <button @click="eliminar_entidad_de_la_cesta(index)" type="button" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i></button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card" v-for="(combination, pos_combination) in entity.combinations">
                                                        <div class="card-body bg-primary">
                                                            <div class="row mb-2">
                                                                <div class="col-6">
                                                                    <span><strong>@{{ combination.name+", " }}</strong></span>
                                                                </div>
                                                                <div class="col-6 text-right">
                                                                    <button @click="eliminar_combinacion_de_la_cesta(pos_combination, entity.entity_name)" type="button" class="btn btn-danger btn-sm"><i class="fas fa-times-circle"></i></button>
                                                                </div>
                                                            </div>
                                                            <div class="row" style="overflow-y: auto; max-height: 100px;">
                                                                <div class="col-12">
                                                                    <p class="h5">Cantidad de productos: <strong>@{{ combination.products.length }}</strong></p>
                                                                    <p v-for="(product, indice) in combination.products" :title="`id: ${product.id}`">
                                                                        @{{ indice+1 }}) 
                                                                        Costo Unitario: <strong>@{{ product.single_cost_when_bought }}</strong>, 
                                                                        Precio Sugerido: <strong>@{{ product.suggested_price }}</strong>
                                                                    </p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="row">
                                                                <div class="col-3 text-center">
                                                                    <p>Total Unitario: <strong>@{{ combination.total_unitario }}</strong> </p>
                                                                </div>
                                                                <div class="col-3 text-center">
                                                                    <p>Total Ideal: <strong>@{{ combination.total_sugerido }}</strong> </p>
                                                                </div>
                                                                <template v-if="combination.precio_final">
                                                                    <div class="col-3 text-center">
                                                                        <span class="bg-success p-1 rounded">PRECIO FINAL: <strong>@{{ combination.precio_final }}</strong></span>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button @click="quitar_precio_de_venta_a_la_combinacion(index, pos_combination)" type="button" class="btn btn-danger">Cambiar Precio</button>
                                                                    </div>
                                                                </template>
                                                                <template v-else>
                                                                    <div class="col-3 text-center">
                                                                        <input type="text" :id="`entity_${index}_combination_${pos_combination}`" class="form-control" placeholder="Precio Final...">
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <button @click="agregar_precio_de_venta_a_la_combinacion(`entity_${index}_combination_${pos_combination}`, index, pos_combination)" type="button" class="btn btn-success"><i class="fas fa-plus-circle"></i></button>
                                                                    </div>
                                                                </template>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="CESTA.length > 1">
                                <div class="col-3">
                                    <p>CESTA (Costo Total): <strong>@{{ TOTAL_UNITARIO_CESTA }}</strong></p>
                                </div>
                                <div class="col-3">
                                    <p>CESTA (Precio Ideal): <strong>@{{ TOTAL_SUGERIDO_CESTA }}</strong></p>
                                </div>
                                <div class="col-3 text-right">
                                    <span class="p-2 bg-primary rounded">CESTA PRECIO FINAL: <strong>@{{ PRECIO_FINAL_CESTA }}</strong></span>
                                </div>
                                <div class="col-3 text-right">
                                    <button @click="registrar_compra_en_db" class="btn btn-success" type="button">REGISTRAR VENTA <i class="fas fa-check"></i></button>
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
                                    total_unitario: [...productos].reduce( (prev, next) => ({single_cost_when_bought: prev.single_cost_when_bought + next.single_cost_when_bought }) ).single_cost_when_bought,
                                    total_sugerido: [...productos].reduce( (prev, next) => ({suggested_price: prev.suggested_price + next.suggested_price }) ).suggested_price,
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
                                        com.products = [...com.products, ...productos];
                                        com.total_unitario = com.products.reduce( (prev, next) => ({single_cost_when_bought: prev.single_cost_when_bought + next.single_cost_when_bought }) ).single_cost_when_bought;
                                        com.total_sugerido = com.products.reduce( (prev, next) => ({suggested_price: prev.suggested_price + next.suggested_price }) ).suggested_price;
                                        
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
                                        total_unitario: [...productos].reduce( (prev, next) => ({single_cost_when_bought: prev.single_cost_when_bought + next.single_cost_when_bought }) ).single_cost_when_bought,
                                        total_sugerido: [...productos].reduce( (prev, next) => ({suggested_price: prev.suggested_price + next.suggested_price }) ).suggested_price,
                                    }
                                ]
                            }

                            return entity;
                           
                        })
                    }
                },
                agregar_precio_de_venta_a_la_combinacion( div, firstIndex, secondIndex ){
                    let precio = document.getElementById(div).value;
                    if ( !precio ) {return;}
                    this.CESTA[firstIndex].combinations[secondIndex] = {...this.CESTA[firstIndex].combinations[secondIndex], precio_final: parseInt(precio)};
                },
                quitar_precio_de_venta_a_la_combinacion( firstIndex, secondIndex ){
                    this.CESTA[firstIndex].combinations[secondIndex] = {...this.CESTA[firstIndex].combinations[secondIndex], precio_final: null};
                },
                eliminar_entidad_de_la_cesta(indice){
                    this.CESTA = this.CESTA.filter((entity, index) => index !== indice);
                },
                eliminar_combinacion_de_la_cesta(indice, entityName){
                    this.CESTA = this.CESTA.map(entity => {
                        if ( entity.entity_name == entityName ) {
                            entity.combinations = entity.combinations.filter((combination, position) => position !== indice);
                        }
                        return entity;
                    });
                },
                async registrar_compra_en_db(){
                    let is_ok=true;
                    this.CESTA.map(entity => {
                        if ( entity.hasOwnProperty('combinations') ) {
                            entity.combinations.map((combination, index) => {
                                if ( combination.total_sugerido  ) {
                                    if ( combination.precio_final === null || combination.precio_final == undefined) {
                                        console.log( 'falta agregar el precio final' );
                                        is_ok = false;
                                    }
                                }

                            });
                        }
                    })
                    if ( is_ok ) {
                        console.log('is ok, time to register sale in database');
                        let obj = {
                            cesta: this.CESTA,
                            precio_final_toda_la_cesta: this.PRECIO_FINAL_CESTA,
                            total_unitario_cesta: this.TOTAL_UNITARIO_CESTA,
                            total_ganancia: this.PRECIO_FINAL_CESTA - this.TOTAL_UNITARIO_CESTA,
                        };
                        let response = await axios.post("{{ route('sales.register_new_sale') }}", obj).then(res => res.data);
                        let new_a_element = document.createElement("a");
                        new_a_element.href = response.ruta;
                        new_a_element.click();
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
                },
                TOTAL_UNITARIO_CESTA(){
                    if ( this.CESTA.length > 1 ) {
                        let total = 0
                        this.CESTA.map(entity => {
                            if ( entity.hasOwnProperty('combinations') ) {
                                entity.combinations.map(com => {
                                    com.products.map(prod => {
                                        total += prod.single_cost_when_bought;
                                    })
                                })
                            }
                        })
                        return total;
                    }
                },
                TOTAL_SUGERIDO_CESTA(){
                    if ( this.CESTA.length > 1 ) {
                        let total = 0
                        this.CESTA.map(entity => {
                            if ( entity.hasOwnProperty('combinations') ) {
                                entity.combinations.map(com => {
                                    com.products.map(prod => {
                                        total += prod.suggested_price;
                                    })
                                })
                            }
                        })
                        return total;
                    }
                },
                PRECIO_FINAL_CESTA(){
                    if ( this.CESTA.length > 1 ) {
                        let total = 0
                        this.CESTA.map(entity => {
                            if ( entity.hasOwnProperty('combinations') ) {
                                entity.combinations.map(com => {
                                    if ( com.hasOwnProperty('precio_final') ) {
                                        total += com.precio_final;
                                    }
                                })
                            }
                        })
                        return total;
                    }
                },

            },

        })


        application.mount('#appVue')
    </script>
@stop
