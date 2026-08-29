@extends('layouts.admin')

@section('title', 'Editar producto')
@section('breadcrumb', 'Productos / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Inventario</p>
            <h1>Editar producto</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.productos.update', $producto) }}">
        @method('PUT')
        @include('admin.productos._form')
    </form>
@endsection
