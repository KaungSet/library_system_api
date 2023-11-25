<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberRenewalHistory extends Model
{
    use HasFactory;
    protected $table = 'member_renewal_histories';
    protected $fillable = [
        'loggable_type',
        'loggable_id',
        'title',
        'activity',
        'createable_id',
        'createable_type',
    ];
}
