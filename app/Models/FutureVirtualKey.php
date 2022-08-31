<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FutureVirtualKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'user_email', 'valid_days'
    ];
}
