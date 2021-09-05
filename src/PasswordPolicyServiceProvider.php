<?php

namespace DDTech\PasswordPolicy;

use Illuminate\Support\ServiceProvider;

class PasswordPolicyServiceProvider extends ServiceProvider {

    public function boot(){
        $this->publishes([
            __DIR__.'/../config/password-policy.php' => config_path('password-policy.php'),
        ]);

        if (! class_exists('CreatePasswordRecordsTable')) {
            $this->publishes([
                __DIR__ . '/../database/migrations/create_password_records_table.php.stub' => database_path('migrations/' . date('Y_m_d_His', time()) . '_create_password_records_table.php'),
            ], 'migrations');
        }

        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
    }

    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/password-policy.php', 'password-policy');
    }

    public function registerPublishables(): void {
        if (! class_exists('CreatePasswordRecordsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/create_password_records_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_password_records_table.php'),
            ], 'migrations');
        }
    }
}
