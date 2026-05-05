<?php

namespace App\Filament\Internal\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'SKS Internal Portal';
    }

    public function getSubheading(): ?string
    {
        return 'Masuk dengan akun panitia SKS kamu';
    }
}
