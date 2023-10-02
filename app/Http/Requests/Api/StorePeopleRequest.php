<?php

namespace App\Http\Requests\Api;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class StorePeopleRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function rules(): array
    {
        return [
            'apelido' => ['required', 'max:32', 'unique:peoples', 'string'],
            'nome' => ['required', 'max:100', 'string'],
            'nascimento' => ['required', 'date', 'date_format:Y-m-d'],
            'stack' => ['nullable', 'array'],
            'stack.*' => ['nullable', 'string', 'distinct']
        ];
    }

    public function messages(): array
    {
        return [
            'apelido.required' => 'O campo apelido é obrigatório',
            'apelido.max' => 'Um apelido pode só contar até 32 caracteres',
            'apelido.unique' => 'Esse apelido já existe',
            'apelido.string' => 'O apelido deve estar no formato de texto',
            'nome.required' => 'O campo nome é obrigatório',
            'nome.max' => 'Um nome pode só contar até 100 caracteres',
            'nome.string' => 'O nome deve estar no formato de texto',
            'stack.array' => 'O capmo stack deve ser uma lista',
            'stack.*.string' => 'O campo stack deve ser uma lista de textos',
            'stack.*.distinct' => 'O campo stack não pode conter itens repetidos'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (strpos($validator->errors()->first(), 'deve')) {
            throw (new ValidationException(($validator)))
                ->errorBag($this->errorBag)
                ->redirectTo($this->getRedirectUrl())
                ->status(Response::HTTP_BAD_REQUEST);
        }

        throw (new ValidationException($validator))
            ->redirectTo($this->getRedirectUrl())
            ->errorBag($this->errorBag);
    }
}
