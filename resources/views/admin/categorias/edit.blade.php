@extends('layouts.admin')

@section('title', 'Editar categoría')
@section('breadcrumb', 'Productos / Categorías / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Editar categoría</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categorias.update', $categoria) }}">
        @method('PUT')
        @include('admin.categorias._form')
    </form>
@endsection
