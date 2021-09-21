# Laravel Password Policy

This package ensures that the last used (n) password/s are not entered.

## Requirements

Laravel Fortify or Jetstream has to be installed. 

## Installation

```bash
composer require ddtech/laravel-password-policy
```

```bash
php artisan vendor:publish --tag=migrations
php artisan migrate
```

## Usage

Add PasswordRecords Traits to User Model

```
use PasswordRecords;
```

You need to change Fortify, ResetUserPassword's reset function

```  
Validator::make($input, [
  'password' => $this->passwordRules(),
])->validate();
```

```
Validator::make($input, [
    'password' => $this->passwordRules(),
])->after(function ($validator) use ($user, $input) {
    $user->oldPasswordRules($validator, $user, $input, 3);
})->validate();

$user->triggerPasswordRecord($user->password);
```

You need to change Fortify, UpdateUserPassword's update function

```
Validator::make($input, [
    'current_password' => ['required', 'string'],
    'password' => $this->passwordRules(),
])->after(function ($validator) use ($user, $input) {
    if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
        $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
    }
})->validateWithBag('updatePassword');
```

```
Validator::make($input, [
    'current_password' => ['required', 'string'],
    'password' => $this->passwordRules(),
])->after(function ($validator) use ($user, $input) {
    if (! isset($input['current_password']) || ! Hash::check($input['current_password'], $user->password)) {
        $validator->errors()->add('current_password', __('The provided password does not match your current password.'));
    }
    $user->oldPasswordRules($validator, $user, $input, 3);
})->validateWithBag('updatePassword');

$user->triggerPasswordRecord($user->password);
```
