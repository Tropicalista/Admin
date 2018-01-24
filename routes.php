<?php

Route::group(['namespace' => 'Tropicalista\Admin\Http\Controllers', 'prefix'=> 'admin', 'middleware' => ['web','auth','role:user']], function() {

    Route::get('/', ['as' => 'admin.root', 'uses' => 'DashboardController@index']);

    # User Management
    Route::get('users', ['as' => 'admin.users', 'uses' => 'UsersController@getIndex']);
    Route::get('users/data', ['as' => 'admin.users.data', 'uses' => 'UsersController@getData']);
    Route::get('users/{user}/edit', ['as' => 'admin.users.edit', 'uses' => 'UsersController@getEdit']);
    Route::post('users/{user}/edit', ['as' => 'admin.users.edit', 'uses' => 'UsersController@postEdit']);
    Route::get('users/{user}/delete', ['as' => 'admin.users.delete', 'uses' => 'UsersController@getDelete']);
    Route::get('users/create', ['as' => 'admin.users.create', 'uses' => 'UsersController@getCreate']);
    Route::post('users/create', ['as' => 'admin.users.create', 'uses' => 'UsersController@postCreate']);

    # User Role Management
    Route::get('roles', ['as' => 'admin.roles', 'uses' => 'RolesController@getIndex']);
    Route::get('roles/data', ['as' => 'admin.roles.data', 'uses' => 'RolesController@getData']);
    Route::get('roles/{role}/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@getEdit']);
    Route::post('roles/{role}/edit', ['as' => 'admin.roles.edit', 'uses' => 'RolesController@postEdit']);
    Route::get('roles/{role}/delete', ['as' => 'admin.roles.delete', 'uses' => 'RolesController@getDelete']);
    Route::get('roles/create', ['as' => 'admin.roles.create', 'uses' => 'RolesController@getCreate']);
    Route::post('roles/create', ['as' => 'admin.roles.create', 'uses' => 'RolesController@postCreate']);

   # User Permission Management
    Route::get('permissions', ['as' => 'admin.permissions', 'uses' => 'PermissionsController@getIndex']);
    Route::get('permissions/data', ['as' => 'admin.permissions.data', 'uses' => 'PermissionsController@getData']);
    Route::get('permissions/{permission}/edit', ['as' => 'admin.permissions.edit', 'uses' => 'PermissionsController@getEdit']);
    Route::post('permissions/{permission}/edit', ['as' => 'admin.permissions.edit', 'uses' => 'PermissionsController@postEdit']);
    Route::get('permissions/{permission}/delete', ['as' => 'admin.permissions.delete', 'uses' => 'PermissionsController@getDelete']);
    Route::get('permissions/create', ['as' => 'admin.permissions.create', 'uses' => 'PermissionsController@getCreate']);
    Route::post('permissions/create', ['as' => 'admin.permissions.create', 'uses' => 'PermissionsController@postCreate']);

    # Settings
    // ===================================
    Route::get('settings', [
        'as'   => 'admin.settings.index',
        'uses' => 'SettingsController@index'
    ]);
    Route::get('settings/{settingsGroup}', [
        'as'   => 'admin.settings.show',
        'uses' => 'SettingsController@show'
    ]);
    Route::post('settings', [
        'as'   => 'admin.settings.update',
        'uses' => 'SettingsController@update'
    ]);

});

Route::bind('user', function($value)
{
    return App\User::find($value);
});

Route::bind('role', function($value)
{
    return Spatie\Permission\Models\Role::find($value);
});

Route::bind('permission', function($value)
{
    return Spatie\Permission\Models\Permission::find($value);
});

Route::bind('settingsGroup', function($settingsGroup)
{
    if ( is_numeric( $settingsGroup ) )
        $settingsGroup = Tropicalista\Admin\Models\SettingsGroup::find($settingsGroup);
    else
        $settingsGroup = Tropicalista\Admin\Models\SettingsGroup::where('slug', $settingsGroup)->first();

    if ( !$settingsGroup )
        \App::abort(404);

    return $settingsGroup;
});