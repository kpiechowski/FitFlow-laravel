<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;
use App\Models\ActivitiesType;

class UserActivity extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function currentUser(){
        return $this->belongsTo(User::class);
    }

    // public function activityTypeName(){
    //     $activity = $this->hasOne(ActivitiesType::class)->get();
    //     dd($activity);
    //     // return $activity->name;
    // }

    public function userLatestActivity(){
        return $this->currentUser()->latest('add_date')->first();
    }

    public function activityType(){
        return $this->hasOne(ActivitiesType::class, 'id', 'activity_type_id');
        // return $this->hasOne(ActivitiesType::class, 'id');
    }

    // public function all()

}
