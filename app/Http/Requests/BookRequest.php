<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Gate;

class BookRequest extends FormRequest
{
    protected const numRegex = 'regex:/^\d+$/';    

    public function authorize()
    {
        return Gate::authorize('admin');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'isbn' => ['required', self::numRegex, 'unique:books,isbn'],
            'description' => 'required|string',
            'quantity' => 'required|integer|min:1',
            'book_cover' => 'nullable|image|mimes:jpeg,png,jpg,gift|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'isbn.unique' => 'Error for ISBN: A book with this exact ISBN already exists in the library.',
            'isbn.regex'  => 'Error for ISBN: Please enter a valid number without dashes or spaces.',
            'quantity.min' => 'Error for Quantity: You must add at least 1 book to the stock.',
            'title.required' => 'Error for Title: You cannot leave the book title blank.',
        ];
    }
}
