<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivitiesType extends Model
{
    use HasFactory;


    protected $table = 'activities_type';

    public static function getNameById($id){
        $model = ActivitiesType::find($id);

        if($model) return $model;
        return 'brak';
    }



}
