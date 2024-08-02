<?php

namespace App\Rules;
use Illuminate\Contracts\Validation\Rule;

class Name implements Rule
{
    public function __construct()
    {

    }
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[a-zA-Z]+$/', $value);
    }
    public function message(): string
    {
        return 'The :attribute must contain only letters.';
    }
}
