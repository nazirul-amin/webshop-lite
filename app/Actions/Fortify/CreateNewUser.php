<?php

namespace App\Actions\Fortify;

use App\Models\CustomerInformation;
use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
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
            $currentUserCount = User::where('role_id', Role::where('name', 'Customer')->first()->id)->count();
            $userNo = 'CUST'.Carbon::now()->format('Y').Carbon::now()->format('m').sprintf('%05d', $currentUserCount + 1);

            $user = User::create([
                'user_no' => $userNo,
                'name' => $input['name'],
                'email' => $input['email'],
                'role_id' => Role::where('name', 'Customer')->first()->id,
                'password' => Hash::make($input['password']),
            ]);

            CustomerInformation::create([
                'name' => $input['name'],
                'identity_no' => $input['identity_no'],
                'phone_no' => $input['phone_no'],
                'age' => $input['age'],
                'user_id' => $user->id,
            ]);

            return $user;
        });
    }
}
