@extends('layouts.admin')

@section('title', 'Editar sabor')
@section('breadcrumb', 'Productos / Sabores / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Editar sabor</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sabores.update', $sabor) }}">
        @method('PUT')
        @include('admin.sabores._form')
    </form>
@endsection
