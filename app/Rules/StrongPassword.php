<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class StrongPassword implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    protected array $messages = [];
    
  
           public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         // Reset in case reused

        if (!preg_match('/[A-Z]/', $value)) {
            $fail('Must contain at least one uppercase letter.');
        }

        if (!preg_match('/\d/', $value)) {
             $fail('Must contain at least one number.');
        }

        if (!preg_match('/[!@#$%^&*(),.?":{}|<>]/', $value)) {
             $fail('Must contain at least one special character.');
        }

        
    }

    }

