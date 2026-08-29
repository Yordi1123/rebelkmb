<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // La autorización de acceso ya la maneja el middleware 'auth' en las rutas
    }

    public function rules(): array
    {
        // route('producto') existe solo en las rutas edit/update; será null al crear
        $productoId = $this->route('producto')?->id;

        return [
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('productos', 'codigo')->ignore($productoId),
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'tipo' => ['nullable', 'string', 'max:100'],
            'sabor' => ['nullable', 'string', 'max:100'],
            'presentacion' => ['nullable', 'string', 'max:100'],
            'unidad_medida' => ['nullable', 'string', 'max:50'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Ya existe un producto con ese código.',
            'nombre.required' => 'El nombre es obligatorio.',
            'categoria_id.required' => 'Selecciona una categoría.',
            'categoria_id.exists' => 'La categoría seleccionada no es válida.',
        ];
    }
}
