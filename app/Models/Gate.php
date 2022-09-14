<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'serial_number', 'magic_code', 'team_id'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function virtualKeys()
    {
        return $this->belongsToMany(VirtualKey::class);
    }

    public function futureVirtualKeys()
    {
        return $this->belongsToMany(FutureVirtualKey::class);
    }

    public function virtualTickets()
    {
        return $this->belongsToMany(VirtualTicket::class);
    }
}
