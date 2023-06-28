<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => ['required', Rule::unique('projects')->ignore($this->project)],
            'description' => ['required'],
            'client' => ['nullable'],
            'cover_image' => ['nullable', 'image', 'max:2000'],
            'category_id' => ['nullable', 'exists:types,id'],
            'technologies' => ['exists:technologies,id'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Il campo Name deve essere compilato',
            'name.unique' => 'Esiste già un project con quel nome',
            'description.required' => 'Il campo Description deve essere compilato',
            'cover_image.image' => 'Devi caricare un file image',
            'cover_image.max' => 'Il file caricato non deve superare i 2000 KB',
            'category_id.exist' => 'Il Type non esiste',
            'technologies.exist' => 'La Technology non esiste',
        ];
    }
}
