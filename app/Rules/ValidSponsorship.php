<?php

namespace App\Rules;

use App\Models\Sponsorship;
use Illuminate\Contracts\Validation\Rule;

class ValidSponsorship implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $sponsorship = Sponsorship::find($value);
        if(Sponsorship::find($value)){
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Il prodotto non esiste!';
    }
}
