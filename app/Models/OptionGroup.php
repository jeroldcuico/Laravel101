<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionGroup extends Model
{
    use HasFactory , SoftDeletes;

    public function options(){
        return $this->hasMany('App\Models\Option','group_id');
    }
}
