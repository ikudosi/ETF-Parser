<?php

namespace App\Models;

/**
 * Class FundIndexSector
 * @package App\Models
 *
 * @property int id
 * @property int fund_id
 * @property string name
 * @property double weight
 */
class FundIndexSector extends BaseModel
{
    protected $fillable = ['fund_id','name','weight'];
}
