<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\UserActivity;
use App\Models\Notification;
use App\Models\Footwear;
use App\Models\PersonalChallenge;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUserProfileIcon(){

    }

    public function userActivities()
    {
        return $this->hasMany(UserActivity::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function footwear(){
        return $this->hasMany(Footwear::class);
    }
     
    public function challenges(){
        return $this->hasMany(PersonalChallenge::class);
    }


}
