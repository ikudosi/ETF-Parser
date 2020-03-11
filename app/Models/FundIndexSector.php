<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class FundIndexSector
 * @package App\Models
 *
 * @property int id
 * @property int fund_id
 * @property string name
 * @property double weight
 */
class FundIndexSector extends Model
{
    protected $fillable = ['fund_id','name','weight'];
}
