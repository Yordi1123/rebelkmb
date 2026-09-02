@extends('layouts.admin')

@section('title', 'Nuevo sabor')
@section('breadcrumb', 'Productos / Sabores / Nuevo')

@section('content')
    <div class="ap-page-heading">
        <div>
            <p class="ap-eyebrow">Catálogo</p>
            <h1>Nuevo sabor</h1>
        </div>
    </div>

    <form method="POST" action="{{ route('admin.sabores.store') }}">
        @include('admin.sabores._form')
    </form>
@endsection
