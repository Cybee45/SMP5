<?php

namespace App\Filament\Pages\Auth;

use Filament\Forms\Components\Component;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Pages\Auth\Login as BaseLogin;
use Illuminate\Validation\ValidationException;

class Login extends BaseLogin
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                $this->getEmailFormComponent()
                    ->label('Email'),
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
            ->email()
            ->required()
            ->autocomplete()
            ->autofocus()
            ->placeholder('Masukkan email Anda')
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
            'data.email' => 'Email atau password yang Anda masukkan salah.',
        ]);
    }

    public function getTitle(): string
    {
        return 'Masuk ke CMS Sekolah';
    }

    public function getHeading(): string
    {
        return 'Sistem Manajemen Konten Sekolah';
    }

    public function getSubHeading(): string
    {
        return 'Masuk dengan akun yang telah terdaftar';
    }
}
