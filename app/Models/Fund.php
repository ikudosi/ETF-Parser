<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Fund
 * @package App\Models
 *
 * @property int id
 * @property string symbol
 * @property string description
 * @property string url
 *
 * @property HasMany holdings
 * @property HasMany indexSectors
 * @property HasMany geographyBreakdown
 */
class Fund extends BaseModel
{
    protected $fillable = [
        'symbol','description','url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function holdings()
    {
        return $this->hasMany(Holdings::class)->orderByDesc('weight');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function indexSectors()
    {
        return $this->hasMany(FundIndexSector::class)->orderByDesc('weight');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function geographyBreakdown()
    {
        return $this->hasMany(FundGeographicalBreakdown::class)->orderByDesc('weight');
    }

    /**
     * @param $query
     * @param $symbol
     * @return mixed
     */
    public static function scopeBySymbol($query, $symbol)
    {
        return $query->where('symbol', $symbol);
    }
}
