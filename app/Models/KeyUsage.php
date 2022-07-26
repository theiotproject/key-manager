<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KeyUsage extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'virtual_key_id', 'access_granted', 'message'];

    public $incrementing = false;

    public function getEvent() {
        return $this->hasOne(Event::class, 'id', 'id');
    }
}
