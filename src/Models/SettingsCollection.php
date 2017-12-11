<?php 

namespace Tropicalista\Admin\Models;

use Illuminate\Database\Eloquent\Collection;

class SettingsCollection extends Collection {

    public function get($handle, $default = null)
    {
        return $this->where('handle', $handle)->first();
    }

}