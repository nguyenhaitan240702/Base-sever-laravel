<?php

namespace App\Http\Requests\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors()->all();
        $message = implode(', ', $errors);
        throw new HttpResponseException(
            (new Controller)->sendError(HttpResponse::HTTP_UNPROCESSABLE_ENTITY, $message, array(), HttpResponse::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => trans('messages.validation.empty', ['data' => 'Email']),
            'email.email' => trans('messages.validation.invalid', ['data' => 'Email']),
            'password.required' => trans('messages.validation.empty', ['data' => 'Password']),
        ];
    }
}
