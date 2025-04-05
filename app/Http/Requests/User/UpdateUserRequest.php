<?php

namespace App\Http\Requests\User;

use App\Models\Anagrafica;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class UpdateUserRequest extends FormRequest
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
            'name'        => 'required|string|max:255',
            'email'       => ['required','string','lowercase','max:255','email', Rule::unique('users')->ignore($this->utenti, 'email')],
            'roles'       => ['required'],
            'permissions' => ['sometimes', 'array'],
            'anagrafica' => [
                'nullable',
                Rule::exists('anagrafiche', 'id'), 
                function ($attribute, $value, $fail) {

                    $anagrafica = Anagrafica::with('user')->find($value);

                    if ($anagrafica && $anagrafica->user == $this->utenti) {
                        return;
                    }

                    if ($anagrafica && $anagrafica->user) {
                        $fail("Questa anagrafica è già associata all'utente: " . $anagrafica->user->name);
                    }

                }
            ],
        ];
    }

    /**
    * Get custom attributes for validator errors.
    *
    * @return array<string, string>
    */
    public function attributes()
    {
        return [
            'roles' => __('validation.attributes.user.roles'),
        ];
    }
}
