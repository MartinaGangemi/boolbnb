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
            'cover_img' => 'required|image|mimes:jpeg,jpg,png',
            'description' => 'required|min:50|max:255',
            'address' => 'required|string|min:4',
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute is required.',
            'numeric' => ':attribute should be a number.',
            'summary.min' => 'Descriptive title must be longer than 15 characters.',
            'summary.max' => 'Descriptive title should not exceed 150 characters.',
            'rooms.min' => 'The apartment should have at least 1 room.',
            'cover_img.image' => 'The apartment image should be an image.',
            'cover_img.required' => 'A cover image of the apartment is required.',
            'cover_img.mimes' => 'Image file format should be a .jpeg, .jpg or a .png.',
            'beds:min' => 'The apartment should have at least 1 bed.',
            'bathrooms.min' => 'The apartment should have at least 1 bathroom.',
            'square_meters' => 'The apartment should be bigger than 9 meters.',
            'description.min' => 'Apartment description should be longer than 50 characters to increase attractiveness.',
            'description.max' => 'Apartment description should not be longer than 255 characters.',
            'address.min' => 'Address attribute should be long at least 4 characters.',
        ];
    }
}
