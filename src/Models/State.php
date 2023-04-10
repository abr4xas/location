<?php

namespace Abr4xas\Location\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Abr4xas\Location\Models\State
 *
 * @property string $code
 */
class State extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'code',
        'slug',
    ];

    /** Undocumented function */
    public function cities(): HasMany
    {
        return $this->hasMany(City::class);
    }
}
