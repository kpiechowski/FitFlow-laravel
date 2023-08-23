<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Footwear extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function updateTotalValue($val){
        $this->total_km += $val;
        $this->save();
    }

    public function updateTotalTime($val){
        $this->total_time += $val;
        $this->save();
    }
    
}
