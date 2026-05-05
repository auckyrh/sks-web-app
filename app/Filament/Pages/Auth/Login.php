<?php

namespace App\Filament\Pages\Auth;

use Filament\Pages\Auth\Login as BaseLogin;

class Login extends BaseLogin
{
    public function getHeading(): string
    {
        return 'SKS Santo Yakobus';
    }

    public function getSubheading(): ?string
    {
        return 'Admin & superadmin access only';
    }

    protected function getRedirectUrl(): string
    {
        // Members who land on /admin/login get sent to /internal instead
        if (auth()->user()?->isMember()) {
            return '/internal';
        }

        return parent::getRedirectUrl();
    }
}
