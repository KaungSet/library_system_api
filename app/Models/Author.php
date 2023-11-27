<?php

namespace App\Models;

use App\Actions\GlobalActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
    use HasFactory, GlobalActivity;
    protected $table = 'authors';
    protected $fillable = [
        'name',
        'bio',
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
}
