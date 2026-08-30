<?php

namespace App\Http\Requests;

use App\Models\Sabor;
use App\Models\Tipo;
use Illuminate\Foundation\Http\FormRequest;

class ProductoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_id' => ['required', 'exists:categorias,id'],
            'tipo_id' => [
                'required',
                'exists:tipos,id',
                function ($attribute, $value, $fail) {
                    $tipo = Tipo::find($value);
                    if ($tipo && (int) $tipo->categoria_id !== (int) $this->categoria_id) {
                        $fail('El tipo seleccionado no pertenece a la categoría elegida.');
                    }
                },
            ],
            'sabor_id' => [
                'nullable',
                'exists:sabores,id',
                function ($attribute, $value, $fail) {
                    if (! $value) {
                        return;
                    }
                    $sabor = Sabor::find($value);
                    if ($sabor && (int) $sabor->categoria_id !== (int) $this->categoria_id) {
                        $fail('El sabor seleccionado no pertenece a la categoría elegida.');
                    }
                },
            ],
            'presentacion' => ['nullable', 'string', 'max:100'],
            'unidad_medida' => ['nullable', 'string', 'max:50'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'categoria_id.required' => 'Selecciona una categoría.',
            'tipo_id.required' => 'Selecciona un tipo.',
        ];
    }
}
