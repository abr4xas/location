<?php

namespace Abr4xas\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Abr4xas\Location\Models\Neighborhood
 *
 * @property string $code
 */
class Neighborhood extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'latitude',
        'longitude',
        'city_id',
        'slug',
    ];

    /** Undocumented function */
    public function state(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }
}
