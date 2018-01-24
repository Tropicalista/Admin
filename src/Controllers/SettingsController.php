<?php 

namespace Tropicalista\Admin\Controllers;

use App\Http\Controllers\Controller;
use Tropicalista\Admin\Models\SettingsGroup;
use Tropicalista\Admin\Models\Setting;
use Lang;
use View;
use Illuminate\Support\Facades\Input;
use Redirect;
use Cache;

class SettingsController extends Controller {

	public function index()
	{
		$groups = SettingsGroup::with('settings')->get();
        $title = trans('admin.settings.messages.title');

		return view('admin::settings.index')->with(['title' => $title]);
	}

	public function show( SettingsGroup $group )
	{
		$setting = new Setting;
		$group   = $group->with('settings')->find($group->id);
		$title   = $group->name;

		return view('admin::settings.edit')->with(['title' => $title, 'group' => $group, 'setting' => $setting]);
	}

	public function update()
	{
		foreach ( Input::get('settings') as $handle => $value )
		{
			$setting        = Setting::where('handle', $handle)->first();
			$setting->value = htmlentities($value);
			$setting->save();
		}
		Cache::forget('settings');
		return redirect()->back()->with('success', trans('admin::settings/messages.edit.success'));
	}

}
