@extends('adminlte::page')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')

@include('admin::notifications')

<div class="row">
	<div class="col-md-12">

		<div class="box box-primary">
			<div class="box-header">
				<div class="pull-right box-tools">
					<a href="{{route( 'admin.root' ) . '/users/create' }}" class="btn btn-primary btn-sm">
						<span class="fa fa-plus-circle"></span> {{ trans('admin::buttons.create') }}
					</a>
					<a href="#" onClick="oTable.ajax.reload()" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
				</div>
				<i class="fa fa-user"></i>
				<h3 class="box-title">{{ trans('admin::users/title.user_title') }}</h3>
			</div>
			<div class="box-body">
				<table id="users" class="table table-striped table-hover table-bordered">
					<thead>
						<tr>
							<th class="col-md-2">{{{ trans('admin::users/table.name') }}}</th>
							<th class="col-md-2">{{{ trans('admin::users/table.email') }}}</th>
							<th class="col-md-2">{{{ trans('admin::users/table.created_at') }}}</th>
							<th class="col-md-2">{{{ trans('admin::users/table.roles') }}}</th>
							<th class="col-md-2">{{{ trans('admin::users/table.activated') }}}</th>
							<th class="col-md-2"></th>
						</tr>
					</thead>
				</table>
			</div>
		</div>

	</div>
</div>
@stop

{{-- Scripts --}}
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#users').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{{ route( 'admin.root') . '/users/data' }}}",
        "columnDefs": [ {
            "targets": -1,
            "data": null,
            "defaultContent": "<button>Click!</button>"
        } ],
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'email', name: 'email'},
            {data: 'created_at', name: 'created_at'},
            {data: 'roles', name: 'roles', searchable: false},
            {data: 'active', name: 'activated', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
});
</script>

@stop
