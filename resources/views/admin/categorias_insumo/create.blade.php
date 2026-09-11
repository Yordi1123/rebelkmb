@extends('layouts.admin')

@section('title', 'Nueva categoría de insumo')
@section('breadcrumb', 'Insumos / Categorías / Nueva')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Nueva categoría de insumo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categorias-insumo.store') }}">
        @include('admin.categorias_insumo._form')
    </form>
@endsection
