<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory;
    protected $table = 'books';
    protected $fillable = [
        'title',
        'isbn',
        'price',
        'rent_fees',
        'quantity',
        'author_id',
        'published_date',
        'is_available',
        'created_by',
    ];
}
