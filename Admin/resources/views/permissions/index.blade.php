@extends('adminlte::page')

{{-- Web site Title --}}
@section('title')
{{{ $title }}} :: @parent
@stop

{{-- Content --}}
@section('content')

@include('admin::notifications')

<div class="box box-primary">
	<div class="box-header">
		<div class="pull-right box-tools">
			<a href="{{ route('admin.root') .'/permissions/create' }}" class="btn btn-primary btn-sm">
				<span class="fa fa-plus-circle"></span> {{ trans('admin::buttons.create') }}
			</a>
			<a href="#" onClick="oTable.ajax.reload()" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
		</div>
		<i class="fa fa-user"></i>
		<h3 class="box-title">{{ trans('admin::permissions/title.permission_title') }}</h3>
	</div>
	<div class="box-body">
		<table id="permissions" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th class="col-md-2">{{{ trans('admin::permissions/table.name') }}}</th>
					<th class="col-md-2">{{{ trans('admin::permissions/table.roles') }}}</th>
					<th class="col-md-2"></th>
				</tr>
			</thead>
		</table>
	</div>
</div>
@stop

{{-- Scripts --}}
@section('js')
<script type="text/javascript">
$(document).ready(function() {
    oTable = $('#permissions').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('admin.root') .'/permissions/data' }}",
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'roles', name: 'roles', searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@stop