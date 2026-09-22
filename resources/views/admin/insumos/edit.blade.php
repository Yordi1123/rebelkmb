@extends('layouts.admin')

@section('title', 'Editar insumo')
@section('breadcrumb', 'Insumos / Editar')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Insumos</p>
            <h1>Editar insumo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.insumos.update', $insumo) }}">
        @method('PUT')
        @include('admin.insumos._form')
    </form>
@endsection
