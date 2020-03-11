<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FundGeographicalBreakdown extends Model
{
    protected $fillable = ['fund_id','country_name','weight'];
}
