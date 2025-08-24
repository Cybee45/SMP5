<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Filament\Http\Responses\Auth\Contracts\LoginResponse;

class Login extends BaseLogin
{
    protected function getCredentialsFromFormData(array $data): array
    {
        return [
            'username' => $data['email'], // Field name is 'email' but contains username
            'password' => $data['password'],
        ];
    }

    public function authenticate(): ?LoginResponse
    {
        try {
            $data = $this->form->getState();
            $credentials = $this->getCredentialsFromFormData($data);
            
            if (!Auth::attempt($credentials, $data['remember'] ?? false)) {
                $this->throwFailureValidationException();
            }
            
            $user = Auth::user();
            
            // Check if user is active
            if (!$user->is_active) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'data.email' => 'Akun Anda tidak aktif. Silakan hubungi administrator.',
                ]);
            }
            
            // Check if user can access panel
            if (!$user->canAccessPanel()) {
                Auth::logout();
                throw ValidationException::withMessages([
                    'data.email' => 'Anda tidak memiliki akses ke panel admin.',
                ]);
            }
            
        } catch (ValidationException $exception) {
            throw $exception;
        }

        session()->regenerate();

        return app(LoginResponse::class);
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent()
                    ->label('Username'),
                $this->getPasswordFormComponent()
                    ->label('Password'),
                $this->getRememberFormComponent()
                    ->label('Ingat Saya'),
            ])
            ->statePath('data');
    }

    protected function getEmailFormComponent(): Component
    {
        return TextInput::make('email')
            ->label('Username')
            ->required()
            ->autocomplete()
            ->autofocus()
            ->placeholder('Masukkan username Anda')
            ->extraInputAttributes(['tabindex' => 1]);
    }

    protected function getPasswordFormComponent(): Component
    {
        return TextInput::make('password')
            ->password()
            ->required()
            ->placeholder('Masukkan password Anda')
            ->extraInputAttributes(['tabindex' => 2]);
    }

    protected function throwFailureValidationException(): never
    {
        throw ValidationException::withMessages([
            'data.email' => 'Username atau password yang Anda masukkan salah.',
        ]);
    }

    public function getTitle(): string
    {
        return 'Masuk ke CMS Sekolah';
    }

    public function getHeading(): string
    {
        return 'Selamat Datang Admin';
    }

    public function getSubHeading(): string
    {
        return 'Masuk dengan akun yang telah terdaftar';
    }
}
