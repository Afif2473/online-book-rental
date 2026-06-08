<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['title', 'author', 'isbn', 'description', 'quantity', 'book_cover'])]
class Book extends Model
{
    use HasFactory;

    public function rentals()
    {
        return $this->hasMany(Rental::class);
    }
}
