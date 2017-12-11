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

class UsersController extends Controller {


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
        $title = trans('admin/users/title.user_management');

        // Grab all the users
        $users = $this->user;

        // Show the page
        return View::make('admin::users.index', compact('users', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate()
    {
        // All roles
        $roles = $this->role->all();

        // Get all the available permissions
        $permissions = $this->permission->all();

        // Selected groups
        $selectedRoles = Input::old('roles', array());

        // Selected permissions
        $selectedPermissions = Input::old('permissions', array());

		// Title
        $title = 'Create User';

		// Mode
        $mode = 'create';

        $user = new User;

		// Show the page
        return View::make('admin::users.create_edit', compact('user', 'roles', 'permissions', 'selectedRoles', 'selectedPermissions', 'title', 'mode'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(Request $request)
    {
        $rules = array(
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users',
            'password'              => 'required|min:4|confirmed',
            'password_confirmation' => 'min:4',
            'thumbnail'             => 'mimes:png'
            );

        // Validate the inputs
        $validator = $this->validate($request, $rules);

        $user = new User;
        $user->name = Input::get( 'name' );
        $user->email = Input::get( 'email' );
        $user->active = Input::get( 'active' );

        $password = Input::get( 'password' );
        $passwordConfirmation = Input::get( 'password_confirmation' );
        $image = Input::file( 'thumbnail' );

        if($image){
            $filename = $user->name;
            $extension = $image->getClientOriginalExtension();
            $myThumbnail = $filename . '.' . $extension;
            $destinationPath = public_path().'/uploads';
            $upload_success = $image->move($destinationPath, $myThumbnail);

            // create image instances
            $image = Image::make($upload_success)->resize(45, 45);
            $image->save();

            $user->image = $myThumbnail;
        }

        if ($password) {
            $user->password = $password;
        }

        // Generate a random confirmation code
        $this->user->confirmation_code     = md5($this->user->name.time('U'));

        // Save if valid. Password field will be hashed before save
        $user->save();

        // Save roles. Handles updating.
        $user->roles()->attach(Input::get( 'roles' ));
        $user->permissions()->attach(Input::get( 'permissions' ));

        // if error found on model
        if(empty($user->errors)) {
            // Redirect to the new user page
            return redirect()->route('admin.users')->with('success', trans('admin::users/messages.create.success'));
        }

     }

    /**
     * Display the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getShow($user)
    {
        // redirect to the frontend
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getEdit($user)
    {
        if ( $user->id )
        {
            $roles = $this->role->all();
            $permissions = $this->permission->all();

            $user_roles = $user->roles()->pluck('role_id')->toArray();
            $user_permissions = $user->permissions()->pluck('permission_id')->toArray();
            // Title
            $title = trans('admin/users/title.user_update');
        	// mode
            $mode = 'edit';

            return View::make('admin::users.create_edit', compact('user', 'roles', 'permissions', 'title', 'mode', 'user_roles','user_permissions'));
        }
        else
        {
            return redirect()->route('admin.root' . '/users')->with('error', trans('admin/users/messages.does_not_exist'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
    public function postEdit($user)
    {
        $rules = array(
            'name'                  => 'required',
            'email'                 => 'required|email|unique:users,email,'.$user->id,
            'password'              => 'sometimes|nullable|min:4|confirmed',
            'password_confirmation' => 'sometimes|nullable|min:4',
            'thumbnail'             => 'mimes:png'
            );

        // Validate the inputs
        $validator = Validator::make(Input::all(), $rules);

        if ($validator->passes())
        {
            $oldUser = clone $user;
            $user->name = Input::get( 'name' );
            $user->email = Input::get( 'email' );
            $user->active = Input::get( 'confirm' );

            $password = Input::get( 'password' );
            $passwordConfirmation = Input::get( 'password_confirmation' );
            $image = Input::file( 'thumbnail' );

            if($image){
                $filename = $user->name;
                $extension = $image->getClientOriginalExtension();
                $myThumbnail = $filename . '.' . $extension;
                $destinationPath = public_path().'/uploads';
                $upload_success = $image->move($destinationPath, $myThumbnail);

                // create image instances
                $image = Image::make($upload_success)->resize(45, 45);
                $image->save();

                $user->image = $myThumbnail;
            }

            if ($password) {
                $user->password = bcrypt($password);
                //$user->password_confirmation = $passwordConfirmation;
            }

            if($user->active == null) {
                $user->active = $oldUser->active;
            }

            // Save if valid. Password field will be hashed before save
            $user->save();

            // Save roles. Handles updating.
            if (empty(Input::get( 'roles' ))) {
                $user->roles()->detach();
            } else {
                $user->roles()->sync(Input::get( 'roles' ));
            }
            // Save permissions. Handles updating.            
            if (empty(Input::get( 'permissions' ))) {
                $user->permissions()->detach();
            } else {
                $user->permissions()->sync($permissions);
            }

        } else {
            return redirect()->route('admin.users.edit', [$user->id])->withErrors($validator);
        }

        // if error found on model
        if(empty($user->errors)) {
            // Redirect to the new user page
            return redirect()->route('admin.users.edit', [$user->id])->with('success', trans('admin::users/messages.edit.success'));
        } else {
            return redirect()->route('admin.users.edit', [$user->id])
                ->withInput()
                ->withErrors($user->errors);
        }
    }

    /**
     * Remove the specified user from storage.
     *
     * @param $user
     * @return Response
     */
    public function getDelete($user)
    {
        // Check if we are not trying to delete ourselves
        if ($user->id === Auth::id())
        {
            // Redirect to the user management page
            return redirect()->route('admin.users')->with('error', trans('admin::users/messages.delete.impossible'));
        }

        $id = $user->id;
        $user->roles()->detach();

        $user->delete();

        // There was a problem deleting the user
        return redirect()->route('admin.users')->with('success', trans('admin::users/messages.delete.success'));
    }

    /**
     * Show a list of all the users formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function getData()
    {
        $users = User::select(array('users.id', 'users.name','users.email','users.created_at',DB::raw("'roles'"), 'users.active'));
        return Datatables::of($users)
            ->editColumn('roles','{{ implode(", ", App\User::find($id)->roles()->pluck(\'name\')->toArray()) }}')
            ->editColumn('active','@if($active)
                Yes
                @else
                No
                @endif')
            ->addColumn('action', '
                <div class="btn-group">
                <a href="{{{ route(\'admin.users.edit\', [$id]) }}}" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> {{{ trans(\'admin::buttons.edit\') }}}</a>
                @if($email == Auth::user()->email)
                @else
                <a href="{{{ route(\'admin.users.delete\', [$id]) }}}" class="btn btn-xs btn-danger" onclick="return confirm(\'Are you positive?\');"><i class="fa fa-trash-o"></i> {{{ trans(\'admin::buttons.delete\') }}}</a>
                @endif
                </div>
                ')
            ->make(true);
    }
}
