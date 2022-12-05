<?php

namespace App\Application\Posts\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePostRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
					'name' => 'required|max:255',
					'description' => 'required|max:255',
					'tags' => 'required',
					'upload' => 'sometimes',
					'type' => 'required',
        ];
    }

		public function failedValidation(Validator $validator): void
		{
			throw new HttpResponseException(response()->json([
				'success'   => false,
				'message'   => 'Validation errors',
				'data'      => $validator->errors()
			]));
		}
}
