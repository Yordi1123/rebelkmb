@extends('layouts.admin')

@section('title', 'Nueva categoría')
@section('breadcrumb', 'Productos / Categorías / Nueva')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Nueva categoría</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.categorias.store') }}">
        @include('admin.categorias._form')
    </form>
@endsection
