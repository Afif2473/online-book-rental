<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Http\Requests\BookRequest;

class BookController extends Controller
{
    public function store(BookRequest $request)
    {
        $validated = $request->validated();
        $book = Book::create($validated);

        return response()->json([
            'status' => 'success',
            'message' => 'Book Added to collection successfully!',
            'data' => $book
        ], 201);
    }
}
