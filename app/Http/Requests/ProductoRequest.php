<?php

namespace App\Http\Requests;

use App\Models\Categoria;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $categoriaId = $this->input('categoria_id');
        $categoria = Categoria::find($categoriaId);
        $presentacionesValidas = $categoria ? $categoria->presentaciones : [];

        return [
            'nombre'        => ['required', 'string', 'max:255'],
            'categoria_id'  => ['required', 'exists:categorias,id'],
            'tipo_id'       => ['required', 'exists:tipos,id'],
            'sabor_id'      => ['nullable', 'exists:sabores,id'],
            'presentacion'  => ['required', 'string', Rule::in($presentacionesValidas)],
            'activo'        => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'        => 'El nombre del producto es obligatorio.',
            'categoria_id.required'  => 'Selecciona una categoría.',
            'categoria_id.exists'    => 'La categoría seleccionada no existe.',
            'tipo_id.required'       => 'Selecciona un tipo.',
            'tipo_id.exists'         => 'El tipo seleccionado no existe.',
            'sabor_id.exists'        => 'El sabor seleccionado no existe.',
            'presentacion.required'  => 'Selecciona una presentación.',
            'presentacion.in'        => 'La presentación seleccionada no es válida para la categoría seleccionada.',
        ];
    }
}

