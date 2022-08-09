<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VirtualTicket extends Model
{
    use HasFactory, SoftDeletes;

      protected $fillable = [
        'GUID', 'label', 'email', 'valid_from', "valid_to"
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }

    public function gates()
    {
        return $this->belongsToMany(Gate::class);
    }
}
