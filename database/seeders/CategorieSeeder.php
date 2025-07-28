<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorieSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Tuyau',
            'Coude',
            'Robinet',
            'Gyproc',
            'Clou',
            'Pompe Hydrofort',
            'Lavabo',
            'Lave mains',
            'Clapet',
            'Téléphone douche',
            'Passoire',
            'Siphon magique',
            'Bac de douche',
            'Évier',
            'Cabine douche',
            'Ampoules',
            'Manchons',
            'Tée',
            'Vanne',
            'Bouchons',
            'Réducteur',
            'WC',
            'Urinoir',
            'Baignoire',
            'Nipple',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name' => ucfirst(strtolower($name)),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}