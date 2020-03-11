<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Holdings extends Model
{
    public $fillable = [
        'name', 'shares_held', 'weight'
    ];
}
