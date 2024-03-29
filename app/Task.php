<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    public function list(){
        return $this->belongsTo(TaskList::class);
    }
}
