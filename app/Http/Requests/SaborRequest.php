<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SaborRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->has('nombre')) {
            // Elimina espacios extra y pone la primera letra en mayúscula (Title Case)
            // MB_CASE_TITLE para manejar correctamente acentos (ej. maracuyá -> Maracuyá)
            $nombre = trim($this->input('nombre'));
            $nombre = mb_convert_case($nombre, MB_CASE_TITLE, 'UTF-8');

            $this->merge([
                'nombre' => $nombre,
            ]);
        }
    }

    public function rules(): array
    {
        $saborId = $this->route('sabor') ? $this->route('sabor')->id : null;

        return [
            'nombre' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sabores', 'nombre')
                    ->where('categoria_id', $this->categoria_id)
                    ->ignore($saborId)
            ],
            'categoria_id' => ['required', 'exists:categorias,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.unique' => 'Ese sabor ya existe en esta categoría.',
        ];
    }
}
