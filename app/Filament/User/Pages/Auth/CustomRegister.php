<?php

namespace App\Filament\User\Pages\Auth;

use App\Models\User;
use Filament\Pages\Auth\Register;
use Illuminate\Support\Facades\DB;
use Filament\Notifications\Notification;
use Filament\Http\Responses\Auth\RegistrationResponse;
use Illuminate\Support\Facades\Auth;

class CustomRegister extends Register
{
    public function register(): ?RegistrationResponse
    {
        $data = $this->form->getState();
        
        // Begin transaction
        DB::beginTransaction();
        try {
            // Create user
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => $data['password'],
            ]);
            
            // Assign mentee role
            $user->assignRole('user');
            
            DB::commit();

            Notification::make()
                ->title('Registrasi Berhasil')
                ->body('Selamat datang ' . $user->name)
                ->success()
                ->send();

            Auth::login($user);
            // Hapus parent::register() karena kita sudah menangani registrasi secara manual
            return app(RegistrationResponse::class);
            
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

}
