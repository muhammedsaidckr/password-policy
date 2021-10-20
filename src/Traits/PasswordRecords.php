<?php

namespace DDTech\PasswordPolicy\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;

trait PasswordRecords
{
    /**
     * A model may have multiple direct permissions.
     */
    public function passwords()
    {
        return $this->hasMany(
            config('password-policy.models.password_records')
        );
    }

    public function passwordRecords($lim = 3)
    {
        return $this->hasMany(
            config('password-policy.models.password_records')
        )->limit($lim)->get();
    }

    public function triggerPasswordRecord($password) {
        $this->passwords()->create(['password' => $password, 'created_at'=> Date::now()]);

        return $this;
    }

    public function oldPasswordRules($validator, $user, $input, $limit) {
        foreach ($user->passwordRecords($limit) as $key => $old_password) {
            if (!isset($input['password']) || Hash::check($input['password'], $old_password->password) ||
                Hash::check($input['password'], $user->password)) {
                $validator->errors()
                    ->add('password', __('The provided new password has to be different from last 3 passwords'));
            }
        }

    }
}