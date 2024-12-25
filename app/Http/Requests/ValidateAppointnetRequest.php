<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateAppointnetRequest extends FormRequest
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
            'name'=>['required','string','max:255'],
            'email'=>['required','string','email','max:255'],
            'phone'=>['required','string','max:255'],
            'date'=>['required','string','max:255','date_format:Y-m-d'],
            'description'=>['required','string','max:255'],
            'location'=>['nullable','string','max:255'],
            'address'=>['required','string','max:255'],
        ];
    }
}
