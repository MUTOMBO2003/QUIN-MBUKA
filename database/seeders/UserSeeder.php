<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 5 Admins (matricule commence par 2020)
        $adminMatricules = [
            '2020123456',
            '2020987654',
            '2020012345',
            '2020765432',
            '2020345678',
        ];

        foreach ($adminMatricules as $matricule) {
            User::create([
                'matricule' => $matricule,
                'nom' => null,
                'postnom' => null,
                'prenom' => null,
                'email' => null,
                'password' => null,
                'role' => 'admin',
            ]);
        }

        // 5 Secrétaires (matricule commence par 2021)
        $secretaireMatricules = [
            '2021123456',
            '2021987654',
            '2021012345',
            '2021765432',
            '2021345678',
        ];

        foreach ($secretaireMatricules as $matricule) {
            User::create([
                'matricule' => $matricule,
                'nom' => null,
                'postnom' => null,
                'prenom' => null,
                'email' => null,
                'password' => null,
                'role' => 'secretaire',
            ]);
        }
    }
}
