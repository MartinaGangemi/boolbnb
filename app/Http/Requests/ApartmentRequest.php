<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApartmentRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        // Validazione dati appartamento inseriti dall'utente
        return [
            'summary' => 'required|string|min:15|max:150',
            'rooms' => 'required|numeric|min:1',
            'beds' => 'required|numeric|min:1',
            'bathrooms' => 'required|numeric|min:1',
            'square_meters' => 'required|numeric|min:9',
            'cover_img' => 'image|mimes:jpeg,jpg,png',
            'description' => 'required|min:50|max:255',
            'city' => 'required|string|min:3',
            'address' => 'required|string|min:6',
            'number' => 'required|numeric|min:1',
        ];
    }

    public function messages()
    {
        return [
            'required' => ': é richiestp.',
            'numeric' => ':Deve essere un numero.',
            'summary.min' => 'Il titolo descrittivo deve essere lungo almeno 15 caratteri.',
            'summary.max' => 'Il titolo descrittivo non deve superare 150 caratteri.',
            'rooms.min' => 'Deve esserci almeno una stanza.',
            'cover_img.image' => 'l\'\ immagine deve essere un immagine.',
            'cover_img.required' => 'è richiesta un immagine.',
            'cover_img.mimes' => 'Il file immagine deve essere nel formato .jpeg, .jpg or a .png.',
            'beds:min' => 'Deve esserci almeno un letto.',
            'bathrooms.min' => 'Deve esserci alemeno un bagno.',
            'square_meters' => 'Deve avere almeno 9 metriquadri.',
            'description.min' => 'La descrizzione deve essere di almeno 50 caratteri.',
            'description.max' => 'La descrizzione non può superare i 255 caratteri.',
            'city.min' => 'La Citta deve essere lunga almeno 3 caratteri ',
            'address.min' => 'La via deve essere lunga almeno 6 caratteri ',
            'number.min' => 'Il numero deve essere maggiore di 0',
        ];
    }
}
