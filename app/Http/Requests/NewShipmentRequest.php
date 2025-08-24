<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class NewShipmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:128',
            'from_city' => 'required|string|max:64',
            'from_country' => 'required|string|max:64',
            'to_city' => 'required|string|max:64',
            'to_country' => 'required|string|max:64',
            'price' => 'required|integer|min:0',
            'status' => 'required|in:in_progress,unassigned,completed,problem',
            'details' => 'required|string',
            'documents' => 'required|array',
            'document.*' => 'file|mimes:jpg,jpeg,png,webp,pdf,doc,docx|max:10240'
        ];
    }
}
