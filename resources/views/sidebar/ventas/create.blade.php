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


@stop
