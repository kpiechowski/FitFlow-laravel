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


    public function getUserData(){

        if($this->photo){
            $url = url('images/userImage/' . $this->id() . 'profileIcon.webp');
            $userIconType = 'userIcon--photo';
            $content = "<img src='$url' loading='lazy' alt='UserIcon' >";
        }else{
            $userIconType = 'userIcon--letters';
            $content = substr($this->name,0,1);

        }


        return [
            'name'=> $this->name,
            'desc'=> $this->description,
            'team_id'=> $this->team_id,
            'iconType' => $userIconType,
            'iconContent' => $content,
        ];
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

    public function friends()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id_1', 'user_id_2')
            ->wherePivot('status', true);
    }

    public function friendRequests()
    {
        return $this->belongsToMany(User::class, 'friendships', 'user_id_1', 'user_id_2')
            ->wherePivot('status', false);
    }


    public function removeFriend(User $f){
        $this->friends()->detach($f);
    }

    // wyzwania

    public function challenges(){
        return $this->hasMany(PersonalChallenge::class);
    }

    public function activeChallenges($ac_type = 0){

        if($ac_type != 0){
            return $this->hasMany(PersonalChallenge::class)
                ->where(function ($query) use ($ac_type) {
                    $query->where('expired', 0)
                          ->where(function ($query) use ($ac_type){
                              $query->where('allowed_activity', $ac_type)
                                    ->orWhere('allowed_activity', 0);
                          });
                });

        }else{
            return $this->hasMany(PersonalChallenge::class)->where('expired', 0);
        }
    }

    public function onGoingChallenges(){
        return $this->hasMany(PersonalChallenge::class)->where('complete', 0)->where('expired', 0);
    }

    public function completeChallenges(){
        return $this->hasMany(PersonalChallenge::class)->where('complete', 1);
    }

    public function expiredChallenges(){
        return $this->hasMany(PersonalChallenge::class)->where('expired', 1);
    }

    public function team()
    {
        return $this->belongsTo(Team::class);
    }


}
