<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fund extends Model
{
    protected $fillable = [
        'name','url'
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
