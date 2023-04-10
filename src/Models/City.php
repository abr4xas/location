<?php

namespace Abr4xas\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Abr4xas\Location\Models\City
 *
 * @property string $code
 */
class City extends Model
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
        'state_id',
        'slug',
    ];

    /** Undocumented function */
    public function state(): BelongsTo
    {
        return $this->belongsTo(State::class);
    }

    /** Undocumented function */
    public function neighborhoods(): HasMany
    {
        return $this->hasMany(Neighborhood::class);
    }
}
