<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ConfirmTwoFactor extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = '2fa:confirm {email}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Confirmar 2FA para un usuario específico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("Usuario con email {$email} no encontrado.");
            return 1;
        }
        
        if (empty($user->two_factor_secret)) {
            $this->error("El usuario {$email} no tiene 2FA activado.");
            return 1;
        }
        
        if (!empty($user->two_factor_confirmed_at)) {
            $this->info("El usuario {$email} ya tiene 2FA confirmado.");
            return 0;
        }
        
        // Confirmar 2FA
        $user->two_factor_confirmed_at = now();
        $user->save();
        
        $this->info("2FA confirmado exitosamente para el usuario {$email}.");
        
        return 0;
    }
} 