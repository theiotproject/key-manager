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
        'user_id', 'active_from', 'active_to'
    ];

    public function user()
    {
        return $this->belongsTo(Use2r::class);
    }

    public function gates()
    {
        return $this->belongsToMany(Gate::class);
    }
}
