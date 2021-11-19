@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
@stop

@section('css')
    <style>
        a {
            border: 2px solid black;
        }
    </style>
@stop

@section('content')
    <a target="blank" href="https://www.facebook.com">Este es un enlace</a>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script> console.log('Hi!'); </script>
@stop