<?php

namespace Tropicalista\Admin\Models;

use Illuminate\Database\Eloquent\Model;

class SettingsGroup extends Model
{
	protected $fillable = [];

	public $timestamps = false;

	public function settings()
	{
		return $this->hasMany('Tropicalista\Admin\Models\Setting', 'group_id');
	}

}
