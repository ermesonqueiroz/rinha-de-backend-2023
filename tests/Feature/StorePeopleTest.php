<?php

use App\Models\Pessoa;
use Carbon\Carbon;
use function Pest\Laravel\postJson;

describe('Store people endpoint', function () {
    it('should be able to create a new people', function () {
        $data = [
            'apelido' => 'sampaio',
            'nome' => 'Ermeson Sampaio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => ['PHP', 'JavaScript', 'Ruby', 'C++', 'Java']
        ];

        $response = postJson('/api/pessoas', $data);
        $pessoa = Pessoa::where('apelido', $data['apelido'])->first();

        $response->assertCreated(201);
        $response->assertLocation("/api/pessoas/$pessoa->id");
    });

    it('should not be able to create a new people with duplicated a.k.a', function () {
        $data = [
            'apelido' => 'sampaio',
            'nome' => 'Ermeson Sampaio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => ['PHP', 'JavaScript', 'Ruby', 'C++', 'Java']
        ];

        Pessoa::create([
            'apelido' => $data['apelido'],
            'nome' => 'Marcos Aurélio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => null
        ]);

        $response = postJson('/api/pessoas', $data);
        $response->assertUnprocessable();
    });

    it('should not be to create a new people without name', function () {
        $response = postJson('/api/pessoas', [
            'apelido' => 'sampaio',
            'nome' => null,
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => ['PHP', 'JavaScript', 'Ruby', 'C++', 'Java']
        ]);

        $response->assertUnprocessable();
    });

    it('should not be to create a new people without a.k.a', function () {
        $response = postJson('/api/pessoas', [
            'apelido' => null,
            'nome' => 'Ermeson Sampaio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => ['PHP', 'JavaScript', 'Ruby', 'C++', 'Java']
        ]);

        $response->assertUnprocessable();
    });

    it('should not be to create a new people with a non-string name value', function () {
        $response = postJson('/api/pessoas', [
            'apelido' => 'sampaio',
            'nome' => 1,
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => ['PHP', 'JavaScript', 'Ruby', 'C++', 'Java']
        ]);

        $response->assertBadRequest();
    });

    it('should not be to create a new people with a non-string stack item value', function () {
        $response = postJson('/api/pessoas', [
            'apelido' => 'sampaio',
            'nome' => 'Ermeson Smpaio',
            'nascimento' => Carbon::now()->format('Y-m-d'),
            'stack' => [1, 'PHP']
        ]);

        $response->assertBadRequest();
    });
});

