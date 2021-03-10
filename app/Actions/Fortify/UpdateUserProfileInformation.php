<?php

namespace App\Actions\Fortify;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {

        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'photo' => ['nullable', 'image', 'max:1024'],
            'filled_pay_form' => ['boolean'],
        ])->validateWithBag('updateProfileInformation');
        
        if (isset($input['photo']) && $user->role === 'admin') {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($user->role !== 'admin'){
            $input['name'] = $user->name;
        }

        if ($input['email'] !== $user->email &&
            $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        } else if ($input['filled_pay_form'] === true) {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
                'filled_pay_form' => $input['filled_pay_form'],
            ])->save();
        } else {
            $user->forceFill([
                'name' => $input['name'],
                'email' => $input['email'],
            ])->save();
        }
        Log::info("[Log::UpdateUserProfileInformation]", [
            'username' => $user->username
        ]);
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
