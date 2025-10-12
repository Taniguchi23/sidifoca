<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class CheckMenuParent implements Rule
{
    protected $id_menu;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($id_menu)
    {
        $this->id_menu = $id_menu;
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
        return $this->id_menu != $value;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'El campo padre debe ser diferente.';
    }
}
