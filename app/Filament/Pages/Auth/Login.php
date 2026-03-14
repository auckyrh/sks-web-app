<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'SKS Santo Yakobus'; // atur heading di admin Login Page
    }

    public function getSubheading(): ?string
    {
        return 'Sign in to your account'; // atur subheading di admin Login Page
    }
}
