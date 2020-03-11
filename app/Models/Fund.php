<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Fund
 * @package App\Models
 *
 * @property int id
 * @property string name
 * @property string description
 * @property string url
 *
 * @property HasMany holdings
 * @property HasMany indexSectors
 * @property HasMany geographyBreakdown
 */
class Fund extends Model
{
    protected $fillable = [
        'name','description','url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holdings()
    {
        return $this->hasMany(Holdings::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indexSectors()
    {
        return $this->hasMany(FundIndexSector::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function geographyBreakdown()
    {
        return $this->hasMany(FundGeographicalBreakdown::class);
    }
}
