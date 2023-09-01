<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class PersonalChallenge extends Model
{
    use HasFactory;


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function checkIfComplete(){
        if($this->current_value >= $this->goal_value) {
            $this->complete = 1;
        }else{
            $this->complete = 0;
        }
    }

    public function getValueByType($activity){
        switch ($this->type){

            case "total-distance":
            case "total-distance-per-type":
                return $activity->value;
            case "total-activities":
            case "total-activities-per-type":
                return 1;
            case "total-time":
            case "total-time-per-type":
                return $activity->total_time;
           
        }
    }

    public function updateCurrentValue($activity){

        $value = $this->getValueByType($activity);
        $this->current_value += $value;

        $this->checkIfComplete();

        $this->save();

    }

    public function updateCurrentValueRaw($value){
        $this->current_value += $value;
        $this->checkIfComplete();
        $this->save();
    }

    public function includePreviousActivities(){

    }

    
}
