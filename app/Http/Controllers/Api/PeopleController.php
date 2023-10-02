<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StorePeopleRequest;
use App\Http\Resources\Api\PeopleResource;
use App\Models\People;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PeopleController extends Controller
{
    public function store(StorePeopleRequest $storePeopleRequest): RedirectResponse
    {
        $data = $storePeopleRequest->validated();
        $people = People::create($data);

        return redirect("/api/pessoas/$people->id", Response::HTTP_CREATED);
    }

    public function details(Request $request, string $id): JsonResponse
    {
        $people = People::find($id);

        abort_if(!$people, Response::HTTP_NOT_FOUND, 'Não foi possível encontrar um resultado.');
        return PeopleResource::make($people)
            ->toResponse($request)
            ->setStatusCode(Response::HTTP_OK);
    }

    public function search(Request $request): JsonResponse
    {
        $term = $request->query('t');
        abort_if(empty($term), Response::HTTP_BAD_REQUEST, 'O termo de pesquisa é obrigatório');

        $peoples = People::query()
            ->where('apelido', 'LIKE', "%$term%")
            ->orWhere('nome', 'LIKE', "%$term%")
            ->orWhere('stack', 'LIKE', "%$term%")
            ->limit(50)
            ->get();

        return PeopleResource::collection($peoples)
            ->toResponse($request)
            ->setStatusCode(200);
    }

    public function count(): int
    {
        return People::all()->count();
    }
}
