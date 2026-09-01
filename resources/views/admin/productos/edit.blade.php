@extends('layouts.admin')

@section('title', 'Editar producto')
@section('breadcrumb', 'Productos / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Editar producto</h1>
        </div>
    </div>

    @include('admin.productos._form')
@endsection
