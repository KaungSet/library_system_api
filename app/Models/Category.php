<?php

namespace App\Models;

use App\Actions\GlobalActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, GlobalActivity;
    protected $table = 'categories';
    protected $fillable = [
        'name',
        'description',
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
