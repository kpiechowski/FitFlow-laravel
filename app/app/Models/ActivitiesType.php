<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\UserActivity;
use App\Models\User;

class ActivitiesType extends Model
{
    use HasFactory;


    protected $table = 'activities_type';

    public static function getNameById($id){
        $model = ActivitiesType::find($id);

        if($model) return $model;
        return 'brak';
    }

    public function getActivities(){
        return $this->HasMany(UserActivity::class, 'activity_type_id');
    }

    public function getActivitiesByUser($id){
        return $this->HasMany(UserActivity::class, 'activity_type_id')->where('user_id', $id);
    }

    public function getActivitiesByUserAndYear($id, $year){
        return $this->HasMany(UserActivity::class, 'activity_type_id')
        ->where('user_id', $id)
        ->whereYear('add_date', '=', $year);
    }


}
