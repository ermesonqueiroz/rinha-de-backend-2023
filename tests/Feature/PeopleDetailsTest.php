<?php

use App\Models\Pessoa;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

use function Pest\Laravel\getJson;

describe('People details endpoint', function () {
    it('should be to return the details from a people', function () {
        $people = Pessoa::create([
            'apelido' => 'marcos',
            'nome' => 'Marcos Aurélio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => null
        ]);

        $response = getJson("/api/pessoas/$people->id");
        $response->assertOk();
    });


    it('should not to be return the details from an inexistent people', function () {
        $fakeId = fake()->uuid();

        $response = getJson("/api/pessoas/$fakeId");
        $response->assertNotFound();
    });
});

