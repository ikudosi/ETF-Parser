<?php

namespace App\Models;

/**
 * Class Holdings
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property int shares_held
 * @property double weight
 */
class Holdings extends BaseModel
{
    public $fillable = [
        'name', 'shares_held', 'weight'
    ];
}
