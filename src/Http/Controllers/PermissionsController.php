<?php 

namespace Tropicalista\Admin\Http\Controllers;

use App\Http\Controllers\Controller;
use Intervention\Image\ImageManager;
use App\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Lang;
use View;
use DB;
use Redirect;
use Validator;
use Yajra\Datatables\Datatables as Datatables;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

class PermissionsController extends Controller {


    /**
     * User Model
     * @var User
     */
    protected $user;

    /**
     * Role Model
     * @var Role
     */
    protected $role;

    /**
     * Permission Model
     * @var Permission
     */
    protected $permission;

    /**
     * Inject the models.
     * @param User $user
     * @param Role $role
     * @param Permission $permission
     */
    public function __construct(User $user, Role $role, Permission $permission)
    {
        //parent::__construct();
        $this->user = $user;
        $this->role = $role;
        $this->permission = $permission;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        // Title
        $title = trans('admin::permissions/title.permission_management');

        // Grab all the groups
        $permissions = $this->permission;

        // Show the page
        return view('admin::permissions.index')->with(['permissions' => $permissions, 'title' => $title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $permission = new Permission;

        // Title
        $title = trans('admin::permissions/title.create_a_new_permission');

        // Show the page
        return view('admin::permissions.edit')->with(['permission' => $permission, 'title' => $title]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(Request $request)
    {
        $rules = array(
            'name' => 'required|alpha_dash|unique:permissions,name',
            );

        // Validate the inputs
        $validator = $this->validate($request, $rules);

        $permission = Permission::create(['name' => $request->input('name')]);
        // Create a new permission
        //$permission->name        = $request->input('name');
        //$permission->display_name = $request->input('display_name');

        //$this->permission->save();

        // Was the permission created?
        if ($permission->id)
        {
            // Redirect to the permission page
            return redirect()->route('admin.permissions')->with('success', trans('admin::permissions/messages.create.success'));
        }

    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return Response
     */
    public function getShow($id)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $role
     * @return Response
     */
    public function getEdit($permission)
    {
        if(empty($permission))
        {
            // Redirect to the roles management page
            return redirect()->route('admin.permissions')->with('error', trans('admin::permissions/messages.does_not_exist'));
        }

        // Title
        $title = trans('admin::permissions/title.permission_update');

        // Show the page
        return view('admin::permissions.edit')->with(['permission' => $permission, 'title' => $title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $permission
     * @return Response
     */
    public function postEdit(Request $request, $permission)
    {
        $rules = array(
            'name' => 'required|alpha_dash|unique:permissions,name,' . $permission->id,
            'display_name' => 'required|unique:permissions,name,' . $permission->id,
        );

        // Validate the inputs
        $validator = $this->validate($request, $rules);

        // Update the permission datapermission
        $permission->name        = $request->input('name');
        $permission->display_name = $request->input('display_name');

        // Was the permission updated?
        if ($permission->save())
        {
            // Redirect to the permission page
            return redirect()->route('admin.permissions')->with('success', trans('admin::permissions/messages.update.success'));
        }
        else
        {
            // Redirect to the permission page
            return redirect()->route('admin.permissions.edit', [$permission->id])->with('error', trans('admin::permissions/messages.update.error'));
        }

    }

    /**
     * Remove the specified user from storage.
     *
     * @param $role
     * @internal param $id
     * @return Response
     */
    public function getDelete($permission)
    {
        if ( in_array($permission->name, ['manage_users','manage_roles','manage_permissions']) )
        {
            return redirect()->route('admin.permissions')->with('error', trans('admin::permissions/messages.delete.impossible'));
        }
        // Was the permission deleted?
        if($permission->delete()) {
            // Redirect to the permission management page
            return redirect()->route('admin.permissions')->with('success', trans('admin::permissions/messages.delete.success'));
        }

        // There was a problem deleting the permission
        return redirect()->route('admin.permissions')->with('error', trans('admin::permissions/messages.delete.error'));
    }

    /**
     * Show a list of all the roles formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $permissions = Permission::select(array('permissions.id', 'permissions.name', DB::raw("'roles'")));

        return Datatables::of($permissions)
        ->editColumn('roles','{{ implode(", ", Spatie\Permission\Models\Permission::find($id)->roles()->pluck(\'name\')->toArray()) }}')
        ->addColumn('action', '
            <div class="btn-group">
            <a href="{{{ route(\'admin.permissions.edit\', [$id]) }}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans("admin::buttons.edit") }}</a>
            @if (!in_array($name, [\'admin\']))
            <a class="btn btn-xs btn-danger" href="{{{ route(\'admin.permissions.delete\', [$id]) }}}" onclick="return confirm(\'Are you positive?\');"><i class="fa fa-trash-o"></i> {{ trans("admin::buttons.delete") }}</a>
            @endif
            </div>
            ')
        ->make(true);
    }

}
