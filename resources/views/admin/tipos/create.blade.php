@extends('layouts.admin')

@section('title', 'Nuevo tipo')
@section('breadcrumb', 'Productos / Tipos / Nuevo')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Nuevo tipo</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.tipos.store') }}">
        @include('admin.tipos._form')
    </form>
@endsection
