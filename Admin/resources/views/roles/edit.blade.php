@extends('adminlte::page')

@section('content')

<div class="row">
	<div class="col-md-12">

		<div class="box box-primary">
	        <div class="box-header">
	            <h3 class="box-title">{{ trans('admin::roles/title.role_title') }}</h3>
	        </div><!-- /.box-header -->

	        <!-- form start -->
	        <form class="form-horizontal" method="POST">
				{{ csrf_field() }}
	            <div class="box-body">

					  <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
					    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-10">
					    	<input type="text" name="name" class="form-control" value="{{ old('name', $role->name ) }}"> 
							{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
					    </div>
					  </div>
					  <div class="form-group {{{ $errors->has('permissions') ? 'has-error' : '' }}}">
					    <label for="inputPassword3" class="col-sm-2 control-label">Permissions</label>
					    <div class="col-sm-10">
					    	<select name="permissions[]" class="select2-multiple" multiple>
								@foreach ($permissions as $permission)
								@if ($mode == 'create')
								<option value="{{ $permission->id }}">{{ $permission->name }}</option>
								@else
								<option value="{{ $permission->id }}"{{ ( array_search($permission->id, $role_permissions) !== false && array_search($permission->id, $role_permissions) >= 0 ? ' selected="selected"' : '') }}>{{ $permission->name }}</option>
								@endif
								@endforeach
					    	</select>
							{!! $errors->first('permissions', '<span class="help-block">:message</span>') !!}
					  	</div>
					  </div>
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
