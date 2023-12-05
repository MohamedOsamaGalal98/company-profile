<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'category'          => 'required|string|max:100',
            'client_name'       => 'required|string|max:255',
            'demo_email'     => 'nullable|string|max:255',
            'demo_password'     => 'nullable|string|max:255',
            'demo_link'         => 'nullable|url|max:255',
            'dashboard_email' => 'nullable|string|max:255',
            'dashboard_password' => 'nullable|string|max:255',
            'dashboard_link'    => 'nullable|url|max:255',
            'image' => 'required|array',
            'image.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }
}
