# Laravel Password Policy

This package ensures that the last used (n) password/s are not entered. 

## Installation

```bash
composer require ddtech/laravel-password-policy
```

## Usage

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
