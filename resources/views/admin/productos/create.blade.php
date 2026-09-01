@extends('layouts.admin')

@section('title', 'Nuevo producto')
@section('breadcrumb', 'Productos / Nuevo')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Inventario</p>
            <h1>Nuevo producto</h1>
        </div>
    </div>

    @include('admin.productos._form')
@endsection
