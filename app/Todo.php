<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Todo extends Model
{
    protected $fillable = [
        'value'
    ];
}
