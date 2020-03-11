<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FundIndexSector
 * @package App\Models
 */
class FundIndexSector extends Model
{
    protected $fillable = ['fund_id','name','weight'];
}
