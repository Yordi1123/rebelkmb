@extends('layouts.admin')

@section('title', 'Editar categoría de insumo')
@section('breadcrumb', 'Insumos / Categorías / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Editar categoría de insumo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categorias-insumo.update', $categoria) }}">
        @method('PUT')
        @include('admin.categorias_insumo._form')
    </form>
@endsection
