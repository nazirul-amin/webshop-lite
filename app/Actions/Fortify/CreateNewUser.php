<?php

namespace App\Actions\Fortify;

use App\Models\PersonalInformation;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array  $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['required', 'accepted'] : '',
        ])->validate();

        return DB::transaction(function() use ($input) {
            $info = PersonalInformation::create([
                'name' => $input['name'],
                'identity_no' => $input['identity_no'],
                'phone_no' => $input['phone_no'],
                'age' => $input['age'],
            ]);

            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'role_id' => Role::where('name', 'Customer')->first()->id,
                'info_id' => $info->id,
                'password' => Hash::make($input['password']),
            ]);

            return $user;
        });
    }
}
