@extends('adminlte::page')

@section('content')

@include('admin::notifications')

<div class="row">
	<div class="col-md-12">

		<div class="box box-primary">
	        <div class="box-header with-border">
	            <h3 class="box-title">{{$title}}</h3>
	        </div><!-- /.box-header -->

			<form method="POST" class="form-horizontal" action="{{route('admin.settings.update')}}">
				{{ csrf_field() }}
				<div class="box-body">
				@if(View::exists('admin::settings.partials.' . $group->slug))
					@include('admin::settings.partials.' . $group->slug)
				@else
					@include('admin::settings.partials.common')
				@endif

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-3">
						<button type="submit" class="btn btn-success">{{trans('admin::buttons.save')}}</button>
					</div>
				</div>
				</div>
			</form>

	    </div>

	</div>
</div>

@stop
