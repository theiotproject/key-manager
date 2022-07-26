<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['GUID', 'scan_time', 'qr_code', 'status'];
    public $incrementing = false;

    public function keyUsage() {
        return $this->hasOne(KeyUsage::class, 'id', 'GUID');
    }
}
