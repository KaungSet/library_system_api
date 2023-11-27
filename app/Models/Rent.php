<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rent extends Model
{
    use HasFactory;
    protected $table = 'rents';
    protected $fillable = [
        'user_id',
        'checkout_date',
        'return_date',
        'description',
        'created_by',
    ];

    public function books()
    {
        return $this->belongsToMany(Book::class)->withTimestamps();
    }
}
