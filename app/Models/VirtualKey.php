<?php

namespace App\Models;

use App\Models\Gate;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VirtualKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'label', 'user_id', 'valid_days'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function gates()
    {
        return $this->belongsToMany(Gate::class);
    }
}
