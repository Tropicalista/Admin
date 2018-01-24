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
			<a href="{{route('admin.root') .'/roles/create' }}" class="btn btn-primary btn-sm">
				<span class="fa fa-plus-circle"></span> {{ trans('admin::buttons.create') }}
			</a>
			<a href="#" onClick="oTable.ajax.reload()" class="btn btn-primary btn-sm"><i class="fa fa-refresh"></i></a>
		</div>
		<i class="fa fa-key"></i>
		<h3 class="box-title">{{ trans('admin::roles/title.role_title') }}</h3>
	</div>
	<div class="box-body">
		<table id="roles" class="table table-striped table-hover table-bordered">
			<thead>
				<tr>
					<th class="col-md-4">{{{ trans('admin::roles/table.name') }}}</th>
					<th class="col-md-2">{{{ trans('admin::roles/table.users') }}}</th>
					<th class="col-md-2">{{{ trans('admin::roles/table.created_at') }}}</th>
					<th class="col-md-2">{{{ trans('admin::roles/table.updated_at') }}}</th>
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
    oTable = $('#roles').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": "{{ route('admin.root') .'/roles/data' }}",
        "columns": [
            {data: 'name', name: 'name'},
            {data: 'users', name: 'users', searchable: false},
            {data: 'created_at', name: 'created_at'},
            {data: 'updated_at', name: 'updated_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false}
        ]
    });
});
</script>

@stop
