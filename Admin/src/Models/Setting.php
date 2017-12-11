<?php

namespace Tropicalista\Admin\Models;

use Illuminate\Database\Eloquent\Model;
use Tropicalista\Admin\Models\SettingsGroup as SettingsGroup;

class Setting extends Model
{

	protected $fillable = [ 'value' ];

	public $timestamps = false;

	/**
	 * Get the setting by its handle.
	 *
	 * @param $handle
	 *
	 * @return \Illuminate\Database\Eloquent\Collection|static[]
	 */
	public function handle( $handle )
	{
		return $this->where('handle', $handle)->first();
	}

	/**
	 * Get the group the settings belongs to.
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function group()
	{
		return $this->belongsTo('SettingsGroup');
	}

	/**
	 * Override the parent method
	 *
	 * @return \App\Collections\SettingsCollection
	 */
    public function newCollection(array $models = array())
    {
        return new SettingsCollection($models);
    }
    
}
