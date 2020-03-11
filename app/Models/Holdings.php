<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Holdings
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property int shares_held
 * @property double weight
 */
class Holdings extends Model
{
    public $fillable = [
        'name', 'shares_held', 'weight'
    ];
}
