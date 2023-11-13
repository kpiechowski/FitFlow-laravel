<?php

namespace App\Models;

use App\Models\TeamRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


class Team extends Model
{
    use HasFactory;


    // protected $attributes = [
    //     'max_members' => 50,
    // ];

    public static $max_members = 50;

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function getTeamData(){

        $data = [];
        $data['memberCount'] = count($this->users);

        $activities = new Collection();
        foreach ($this->users as $user) {
            $activities = $activities->merge($user->userActivities);
        }
        $activities = $activities->sortBy('updated_at');

        $data['memberActivities'] = $activities->take(10);

        return $data;
    }

    public function isTeamFull(){
        // dump();
        // dump(count($this->users));
        return Team::$max_members == count($this->users);
    }

    public function getMaxMember(){
        return Team::$max_members;
    }

    // public function joinRequests(){
    //     return $this->hasMan
    // }



    public function activeTeamRequests()
    {
        return $this->hasMany(TeamRequest::class)->where('status', 'send');
    }


}
