<?php

namespace App\Http\Requests;

use App\Models\Insumo;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InsumoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $insumoId = $this->route('insumo')?->id;

        return [
            'codigo' => [
                'required',
                'string',
                'max:20',
                Rule::unique('materiales', 'codigo')->ignore($insumoId),
            ],
            'nombre' => ['required', 'string', 'max:255'],
            'categoria_insumo_id' => ['required', 'exists:categorias_insumo,id'],
            'proveedor_id' => ['nullable', 'exists:proveedores,id'],
            'unidad_medida' => ['required', Rule::in(Insumo::UNIDADES)],
            'stock_actual' => ['required', 'numeric', 'min:0'],
            'stock_minimo' => ['required', 'numeric', 'min:0'],
            'stock_seguridad' => ['nullable', 'numeric', 'min:0', 'lte:stock_minimo'],
            'activo' => ['nullable', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'codigo.required' => 'El código es obligatorio.',
            'codigo.unique' => 'Ya existe un insumo con ese código.',
            'nombre.required' => 'El nombre es obligatorio.',
            'categoria_insumo_id.required' => 'Selecciona una categoría.',
            'unidad_medida.required' => 'Selecciona una unidad de medida.',
            'unidad_medida.in' => 'Esa unidad de medida no es válida.',
            'stock_seguridad.lte' => 'El stock de seguridad no puede ser mayor que el stock mínimo.',
        ];
    }
}
