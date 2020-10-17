<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class City extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name',
		'code',
		'latitude',
		'longitude',
		'state_id',
		'slug',
	];

	/**
	 * Undocumented function
	 *
	 * @return BelongsTo
	 */
	public function state(): BelongsTo
	{
		return $this->belongsTo(State::class);
	}

	/**
	 * Undocumented function
	 *
	 * @return HasMany
	 */
	public function neighborhoods(): HasMany
	{
		return $this->hasMany(Neighborhood::class);
	}
}
