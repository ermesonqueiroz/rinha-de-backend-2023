<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePessoaRequest;
use App\Http\Resources\PessoaResource;
use App\Models\Pessoa;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;

class PessoaController extends Controller
{
    public function store(StorePessoaRequest $storePessoaRequest): RedirectResponse
    {
        $data = $storePessoaRequest->validated();
        $pessoa = Pessoa::create($data);

        return redirect("/api/pessoas/$pessoa->id", Response::HTTP_CREATED);
    }

    public function details(Request $request, string $id): JsonResponse
    {
        $pessoa = Pessoa::find($id);

        abort_if(!$pessoa, Response::HTTP_NOT_FOUND, 'Não foi possível encontrar um resultado.');
        return PessoaResource::make($pessoa)
            ->toResponse($request)
            ->setStatusCode(Response::HTTP_OK);
    }
}
