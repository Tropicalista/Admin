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

class RolesController extends Controller {


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
        $title = trans('admin::roles/title.role_management');

        // Grab all the roles
        $roles = $this->role;

        // Show the page
        return view('admin::roles.index', compact('roles', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        $role = new Role;
        $mode = "create";

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

        // Title
        $title = trans('admin::roles/title.create_a_new_role');

        // Show the page
        return view('admin::roles.edit', compact('role', 'permissions', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(Request $request)
    {
        $rules = array(
            'name' => 'required|alpha_dash|unique:roles,name',
        );

        // Validate the inputs
        $validator = $this->validate($request, $rules);
        // Check if the form validates with success

        // Get the inputs, with some exceptions
        $inputs = Input::except('csrf_token');

        $role = Role::create(['name' => Input::get('name')]);
        // Save permissions
        $role->permissions()->attach(Input::get('permissions'));


        // Was the role created?
        if ($role->id)
        {
            // Redirect to the new role page
            return redirect()->route('admin.roles')->with('success', trans('admin::roles/messages.create.success'));
        }

        // Redirect to the role create page
        return redirect()->route('admin.roles.create')->withErrors($validator)->withInput()->with('error', trans('admin::roles/messages.'));

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
    public function getEdit($role)
    {
        if(! empty($role))
        {
            $mode = "edit";
            $role_permissions = $role->permissions()->pluck('permission_id')->toArray();
            $permissions = Permission::all();
        }
        else
        {
            // Redirect to the roles management page
            return redirect()->route('admin.root' . '/roles')->with('error', trans('admin::roles/messages.does_not_exist'));
        }


        // Title
        $title = trans('admin::roles/title.role_update');

        // Show the page
        return View::make('admin::roles.edit', compact('role', 'permissions', 'title', 'mode', 'role_permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $role
     * @return Response
     */
    public function postEdit(Request $request, $role)
    {
        $rules = array(
            'name' => 'required|alpha_dash|unique:roles,name,' . $role->id
            );

        // Validate the inputs
        $validator = $this->validate($request, $rules);

        // Update the role data
        $role->name        = Input::get('name');

        // Save permissions. Handles updating.            
        if (empty(Input::get( 'permissions' ))) {
            $role->permissions()->detach();
        } else {
            $role->permissions()->sync($request->permissions);
        }

        // Was the role updated?
        if ($role->update())
        {
            // Redirect to the role page
            return redirect()->route('admin.roles')->with('success', trans('admin::roles/messages.update.success'));
        }
        else
        {
            // Redirect to the role page
            return redirect()->route('admin.roles.edit', [$role->id])->with('error', trans('admin::roles/messages.update.error'));
        }

    }

    /**
     * Remove the specified user from storage.
     *
     * @param $role
     * @internal param $id
     * @return Response
     */
    public function getDelete($role)
    {
        if ( in_array($role->name, ['admin','comment']) )
        {
            return redirect()->route('admin.root' . '/roles')->with('error', trans('admin::roles/messages.delete.impossible'));
        }
        // Was the role deleted?
        if($role->delete()) {      
            // Redirect to the role management page
            return redirect()->route('admin.roles')->with('success', trans('admin::roles/messages.delete.success'));
        }

        // There was a problem deleting the role
        return redirect()->route('admin.roles')->with('error', trans('admin::roles/messages.delete.error'));
    }

    /**
     * Show a list of all the roles formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $roles = Role::select(array('roles.id',  'roles.name', 'roles.id as users', 'roles.created_at', 'roles.updated_at'));

        return Datatables::of($roles)
        ->editColumn('users', '<span class="label label-success">{{ DB::table(\'user_has_roles\')->where(\'role_id\', \'=\', $id)->count()  }}</span>')
        ->addColumn('action', '
            <div class="btn-group">
            <a href="{{{ route(\'admin.roles.edit\', [$id]) }}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{ trans("admin::buttons.edit") }}</a>
            @if (!in_array($name, [\'admin\',\'comment\']))
            <a href="{{{ route(\'admin.roles.delete\', [$id]) }}}" class="btn btn-xs btn-danger" data-target="#confirm-delete" onclick="return confirm(\'Are you positive?\');"><i class="fa fa-trash-o"></i> {{ trans("admin::buttons.delete") }}</a>
            @endif
            </div>
            ')
        ->escapeColumns([])
        ->make(true);
    }

}
