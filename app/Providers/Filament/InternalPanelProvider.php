<?php

namespace App\Providers\Filament;

use App\Filament\Internal\Pages\Auth\Login as InternalLogin;
use App\Filament\Internal\Pages\Dashboard as InternalDashboard;
use App\Filament\Internal\Pages\MyDivision as InternalMyDivision;
use App\Filament\Internal\Pages\Profile as InternalProfile;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class InternalPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('internal')
            ->path('internal')
            ->login(InternalLogin::class)
            ->brandName('SKS Intrenal Crew')
            ->brandLogo(asset('images/LOGO-SKS.png'))
            ->brandLogoHeight('2.75rem')
            ->colors([
                'primary' => Color::Amber,
            ])
            ->favicon(asset('images/LOGO-SKS.png'))
            ->sidebarCollapsibleOnDesktop()
            ->renderHook(
                name: PanelsRenderHook::BODY_END,
                hook: fn () => new HtmlString(view('filament.internal.bottom-nav')->render()),
            )
            ->pages([
                InternalDashboard::class,
                InternalProfile::class,
                InternalMyDivision::class,
            ])
            ->navigationItems([
                NavigationItem::make('Admin Panel')
                    ->url('/admin')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->group('Admin')
                    ->sort(99)
                    ->visible(fn () => auth()->user()?->isAdmin() || auth()->user()?->isSuperAdmin()),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
