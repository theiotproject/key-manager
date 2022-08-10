<?php

namespace App\Models;

use App\Traits\HasNoPersonalTeam;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Jetstream\HasTeams;
use Laravel\Sanctum\HasApiTokens;
use Auth;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasNoPersonalTeam, HasTeams {
        HasNoPersonalTeam::ownsTeam insteadof HasTeams;
        HasNoPersonalTeam::isCurrentTeam insteadof HasTeams;
    }
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password', 'tours'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'tours' => 'json'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function gates()
    {
        return $this->belongsToMany(Gate::class);
    }

    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    public function virtualKeys()
    {
        return $this->belongsToMany(VirtualKey::class);
    }

    public function virtualTickets()
    {
        return $this->belongsToMany(VirtualTicket::class);
    }

    public function isAdmin()
    {
        $team = Team::find($this->current_team_id);
        $user = Auth::user();
        return $user->hasTeamPermission($team, 'everything');
    }
}
