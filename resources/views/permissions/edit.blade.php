@extends('adminlte::page')

@section('content')

<div class="row">
	<div class="col-md-12">

		<div class="box box-primary">
	        <div class="box-header">
	            <h3 class="box-title">{{ trans('admin::permissions/title.permission_title') }}</h3>
	        </div><!-- /.box-header -->

	        <!-- form start -->
	        <form class="form-horizontal" method="POST">
				{{ csrf_field() }}
	            <div class="box-body">

					  <div class="form-group {{{ $errors->has('name') ? 'has-error' : '' }}}">
					    <label for="inputEmail3" class="col-sm-2 control-label">Name</label>
					    <div class="col-sm-10">
							<input type="text" name="name" class="form-control" value="{{ old('name', $permission->name ) }}">
							{!! $errors->first('name', '<span class="help-block">:message</span>') !!}
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
