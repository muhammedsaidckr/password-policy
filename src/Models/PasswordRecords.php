<?php

namespace DDTech\PasswordPolicy\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PasswordRecords extends Model
{
    protected $fillable = ['password', 'user_id'];

    public $timestamps = false;

    public function __construct(array $attributes = [])
    {
        $attributes['guard_name'] = $attributes['guard_name'] ?? config('auth.defaults.guard');

        parent::__construct($attributes);
    }
    public function getTable()
    {
        return config('password-policy.table_names.password_records', parent::getTable());
    }
}