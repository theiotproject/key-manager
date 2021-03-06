<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MagicCodeUsage extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'magic_code', 'message', 'user_id'];
}
