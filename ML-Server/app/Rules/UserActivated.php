<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UserActivated implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function passes(string $attribute, mixed $value)
    {
        $user = User::where('email', $value)->first();
        return $user->is_active && $user;
    }

    public function validate($attribute, $value, $fail): void
    {
        $user = User::where('email', $value)->first();
        if (!$user) {
            $fail('Your account has not been activated by the admin team!');
        } else {
            if (!$user->is_active) {
                $fail('Your account has not been activated by the admin team!');
            }
        }
    }
}
