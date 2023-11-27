<?php

namespace App\Models;

use App\Actions\GlobalActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    use HasFactory, GlobalActivity;
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

    protected static function booted()
    {
        static::bootAction();
    }

    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'loggable');
    }

    public function author()
    {
        $this->belongsTo(Author::class, 'author_id', 'id');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class)->withTimestamps();
    }
}
