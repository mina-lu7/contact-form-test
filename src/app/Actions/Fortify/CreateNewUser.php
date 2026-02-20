<?php

namespace App\Actions\Fortify;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        $form = new RegisterRequest();

        Validator::make(
            $input,
            [
                'name' => $form->rules()['name'],
                'email' => array_merge(
                    $form->rules()['email'],
                    [Rule::unique(User::class)]
                ),
                'password' => $form->rules()['password'],
            ],
            array_merge(
                $form->messages(),
                [
                    'email.unique' => 'このメールアドレスは既に使用されています',
                ]
            )
        )->validate();

        return User::create([
            'name' => $input['name'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);
    }
}
