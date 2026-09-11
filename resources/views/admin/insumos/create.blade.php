@extends('layouts.admin')

@section('title', 'Nuevo insumo')
@section('breadcrumb', 'Insumos / Nuevo')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Insumos</p>
            <h1>Nuevo insumo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.insumos.store') }}">
        @include('admin.insumos._form')
    </form>
@endsection
