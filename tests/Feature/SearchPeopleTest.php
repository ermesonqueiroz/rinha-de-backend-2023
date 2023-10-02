<?php

use App\Models\People;
use function Pest\Laravel\getJson;

describe('Search people endpoint', function () {
    it('should be return a people list', function () {
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
            'stack' => ['PHP', 'Laravel', 'Nova']
        ]);

        $response = getJson('/api/pessoas?t=' . 'php');
        $data = $response->json('data');

        $response->assertOk(200);
        expect(count($data))->toBe(2);
    });

    it('should be return an empty list', function () {
        $response = getJson('/api/pessoas?t=' . 'php');
        $data = $response->json('data');

        $response->assertOk();
        expect(count($data))->toBe(0);
    });

    it('should not be return an empty list without t parameter', function () {
        $response = getJson('/api/pessoas');

        $response->assertBadRequest(200);
    });
});
