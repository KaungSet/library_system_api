<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $table = 'members';
    protected $fillable = [
        'user_id',
        'card_number',
        'id_number',
        'type_id',
        'photo',
        'start_date',
        'expiration_date',
    ];
}
