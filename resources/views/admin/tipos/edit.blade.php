@extends('layouts.admin')

@section('title', 'Editar tipo')
@section('breadcrumb', 'Productos / Tipos / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Editar tipo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tipos.update', $tipo) }}">
        @method('PUT')
        @include('admin.tipos._form')
    </form>
@endsection
