<?php

namespace App\Models;

/**
 * Class FundGeographicalBreakdown
 * @package App\Models
 *
 * @property int id
 * @property int fund_id
 * @property string country_name
 * @property double weight
 */
class FundGeographicalBreakdown extends BaseModel
{
    protected $fillable = ['fund_id','country_name','weight'];
}
