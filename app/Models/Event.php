<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;
    protected $fillable = ['GUID', 'serial_number', 'scan_time', 'message', 'qr_code', 'status'];
    public $incrementing = false;

    public function keyUsage() {
        return $this->belongsTo(KeyUsage::class, 'GUID', 'id');
    }

    public function gate(){
        return $this->belongsTo(Gate::class, 'serial_number', 'serial_number');
    }
}
