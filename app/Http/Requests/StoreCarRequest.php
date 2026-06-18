<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as Status;

class StoreCarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'brand' => 'required|string',
            'model' => 'required|string',
            'age' => 'required|integer|min:2019|max:2024',
            'price' => 'required|numeric|min:50'
        ];
    }

    public function messages(): array
    {
        return [
            'brand' => [
                'required' => 'O campo `brand` é obrigatório',
                'string' => 'O campo `brand` deve ser do tipo texto (string)'
            ],            
            'model' => [
                'required' => 'O campo `model` é obrigatório',
                'string' => 'O campo `model` deve ser do tipo texto (string)',
            ],
            'age' => [
                'required' => 'O campo `age` é obrigatório',
                'integer' => 'O campo `age` deve ser do tipo inteiro (integer)',
                'min' => 'O ano do carro deve ser entre 2019 e 2024',
                'max' => 'O ano do carro deve ser entre 2019 e 2024'
            ],
            'price' => [
                'required' => 'O campo `price` é obrigatório',
                'numeric' => 'O campo `price` deve ser do tipo numérico (numeric)',
                'min' => 'O valor mínimo do aluguel do carro é de R$ 50',
            ]
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'errors' => $validator->errors()->all()
        ], Status::HTTP_UNPROCESSABLE_ENTITY));
    }
}
