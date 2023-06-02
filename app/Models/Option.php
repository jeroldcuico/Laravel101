<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Option extends Model
{
    use HasFactory , SoftDeletes;

    public function optionGroup(){
        return $this->belongsTo('App\Models\OptionGroup','group_id')->withDefault();
    }

    public function getStatusNameAttribute(){
        if(!$this->isDeleted){
            return 'Enable';
        }else{
            return 'Disabled';
        }
    }

     public function getIsDeletedAttribute(){
        if($this->deleted_at != null){
            return true;
        }else{
            return false;
        }
    }
}
