<?php

namespace App\Filament\Superadmin\Pages\Auth;

use Filament\Auth\Http\Responses\Contracts\LoginResponse;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Facades\Filament;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
        protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => __('filament-panels::auth/pages/login.messages.failed'),
        ]);
    }

    public function authenticate(): ?LoginResponse{
        $data = $this->form->getState();
        
        $authGuard    = Filament::auth();
        $authProvider = $authGuard->getProvider();
        $credentials  = ['email' => $data['email'], 'password' => $data['password']];
        $user         = $authProvider->retrieveByCredentials($credentials);

        if (! $user || ! $authProvider->validateCredentials($user, $credentials)) {
            $this->throwFailureValidationException();
        }

        if (! $user->is_active) {
            throw ValidationException::withMessages([
                'data.email' => 'Akun Anda tidak aktif. Hubungi administrator.',
            ]);
        }

        if(!$user->is_superadmin)
        {
            throw ValidationException::withMessages([
                'data.email' => 'Anda tidak memiliki akses ke panel superadmin.',
            ]);
        }
        $authGuard->login($user,$data['remember'] ?? false);
        session()->regenerate();

    return app(LoginResponse::class);
    }
}
