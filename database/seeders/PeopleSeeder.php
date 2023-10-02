<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    public function run(): void
    {
        People::create([
            'apelido' => 'sampaio',
            'nome' => 'Ermeson Sampaio',
            'nascimento' => '2006-10-02',
            'stack' => ['PHP', 'JavaScript']
        ]);

        People::create([
            'apelido' => 'marcos',
            'nome' => 'Marcos Aurélio',
            'nascimento' => '2004-02-01',
            'stack' => null
        ]);
    }
}
