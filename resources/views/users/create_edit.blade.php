@extends('adminlte::page')

@section('content')

<div class="row">

	<div class="col-md-12">

		<div class="box box-primary">
	        <div class="box-header">
	        	<i class="fa fa-user"></i>
	            <h3 class="box-title">{{ trans('admin::users/title.user_title') }}</h3>
	        </div><!-- /.box-header -->

	        <!-- form start -->
	        <form name="" class="form-horizontal" enctype="multipart/form-data" autocomplete="off" method="POST"> 
				{{ csrf_field() }}
	            <div class="box-body">

					<!-- name -->
					<div class="form-group {{ $errors->has('name') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="username">Full Name</label>
						<div class="col-md-10">
							<input type="text" name="name" class="form-control" value="{{ old('name', $user->name ) }}">
							{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ username -->

					<!-- Email -->
					<div class="form-group {{ $errors->has('email') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="email">Email</label>
						<div class="col-md-10">
							<input type="text" name="email" class="form-control" value="{{ old('email', $user->email ) }}">
							{!! $errors->first('email', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ email -->

					<!-- Password -->
					<div class="form-group {{ $errors->has('password') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="password">Password</label>
						<div class="col-md-10">
							<input class="form-control" type="password" name="password" id="password" value="" />
							{!! $errors->first('password', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ password -->

					<!-- Password Confirm -->
					<div class="form-group {{ $errors->has('password_confirmation') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="password_confirmation">Password Confirm</label>
						<div class="col-md-10">
							<input class="form-control" type="password" name="password_confirmation" id="password_confirmation" value="" />
							{!! $errors->first('password_confirmation', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ password confirm -->

					<!-- Thumbnail -->
					<div class="form-group">
						<label class="col-md-2 control-label" for="thumbnail">Image</label>
						<div class="col-md-10">
							<input class="form-control" type="file" name="thumbnail" id="thumbnail" value="" />
							{!! $errors->first('thumbnail', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ thumbnail -->

					<!-- Activation Status -->
					<div class="form-group {{ $errors->has('activated') || $errors->has('confirm') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="confirm">Activate User?</label>
						<div class="col-md-6">
							@if ($mode == 'create')
							<select name="active" class="form-control">
								<option value="1"{{ old('confirm', 0) === 1 ? ' selected="selected"' : '' }}>{{ trans('yes') }}</option>
								<option value="0"{{ old('confirm', 0) === 0 ? ' selected="selected"' : '' }}>{{ trans('no') }}</option>
							</select>
							@else
							<select name="active" class="form-control" {{ ($user->id === Auth::user()->id ? ' disabled="disabled"' : '') }}>
								<option value="1"{{ ($user->confirmed ? ' selected="selected"' : '') }}>{{ trans('yes') }}</option>
								<option value="0"{{ ( ! $user->confirmed ? ' selected="selected"' : '') }}>{{ trans('no') }}</option>
							</select>
							@endif
							{!! $errors->first('confirm', '<span class="help-block">:message</span>') !!}
						</div>
					</div>
					<!-- ./ activation status -->

					<!-- Roles -->
					<div class="form-group {{ $errors->has('roles') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="roles">Roles</label>
						<div class="col-md-6">
							<select class="form-control select2-multiple" name="roles[]" id="roles[]" multiple>
								@foreach ($roles as $role)
								@if ($mode == 'create')
								<option value="{{ $role->id }}"{{ ( in_array($role->id, $selectedRoles) ? ' selected="selected"' : '') }}>{{ $role->name }}</option>
								@else
								<option value="{{ $role->id }}"{{ ( array_search($role->id, $user_roles) !== false && array_search($role->id, $user_roles) >= 0 ? ' selected="selected"' : '') }}>{{ $role->name }}</option>
								@endif
								@endforeach
							</select>

							<span class="help-block">
								Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
							</span>
						</div>
					</div>
					<!-- ./ groups -->

					<!-- Permissions -->
					<div class="form-group {{ $errors->has('permissions') ? 'has-error' : '' }}">
						<label class="col-md-2 control-label" for="roles">Permissions</label>
						<div class="col-md-6">
							<select class="form-control select2-multiple" name="permissions[]" id="permissions[]" multiple>
								@foreach ($permissions as $permission)
								@if ($mode == 'create')
								<option value="{{ $permission->id }}"{{ ( in_array($permission->id, $selectedPermissions) ? ' selected="selected"' : '') }}>{{ $permission->name }}</option>
								@else
								<option value="{{ $permission->id }}"{{ ( array_search($permission->id, $user_permissions) !== false && array_search($permission->id, $user_permissions) >= 0 ? ' selected="selected"' : '') }}>{{ $permission->name }}</option>
								@endif
								@endforeach
							</select>

							<span class="help-block">
								Select a group to assign to the user, remember that a user takes on the permissions of the group they are assigned.
							</span>
						</div>
					</div>
					<!-- ./ groups -->

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-success">{{ trans('admin::buttons.save') }}</button>
						</div>
					</div>

	            </div><!-- /.box-body -->

	        </form>
	    </div>

	</div>
</div>

@stop

@section('css')
    <link rel="stylesheet" href="{!! URL::asset('select2/css/select2.min.css') !!}">
    <link rel="stylesheet" href="{!! URL::asset('select2/css/select2-bootstrap.css') !!}">

@stop

@section('js')

    <script src="{!! URL::asset('select2/js/select2.min.js') !!}"></script>
	<script type="text/javascript">

	$(document).ready(function() {
	    
	    // select2 style
	    $('.select2').select2();
	    // Dual List Box
	    $('.select2-multiple').select2({
	        width: '100%'
	    });
	    
	    // dataTables bootstrap style
	    $('.dataTables_length select').select2({width: 80})
	    $('.dataTables_filter input').addClass('form-control')

	    // add blue bg on header
	    $('.dataTable th').addClass('bg-blue'); 

	});
	</script> 

@stop