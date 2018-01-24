@extends('adminlte::page')

@section('content')
	<div class="block settings">

		<div class="row">		
			<div class="col-md-3 col-xs-6">
				<div class="info-box">
				  <span class="info-box-icon bg-red"><i class="fa fa-fw fa-dashboard"></i></span>
				  <div class="info-box-content">
					<a href="{{ route('admin.settings.show', 'general') }}" title="@lang('admin::settings/messages.general')">
						<i class="fa fa-fw fa-dashboard"></i>
						@lang('admin::settings.messages.general')
					</a>
				  </div><!-- /.info-box-content -->
				</div><!-- /.info-box -->					
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="info-box">
				  <span class="info-box-icon bg-red"><i class="fa fa-fw fa-dashboard"></i></span>
				  <div class="info-box-content">
					<a href="{{ route('admin.settings.show', 'analytics') }}" title="@lang('admin::settings/messages.analytics')">
						<i class="fa fa-fw fa-dashboard"></i>
						@lang('admin::settings/messages.analytics')
					</a>
				  </div><!-- /.info-box-content -->
				</div><!-- /.info-box -->					
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="info-box">
				  <span class="info-box-icon bg-red"><i class="fa fa-fw fa-dashboard"></i></span>
				  <div class="info-box-content">
					<a href="{{ route('admin.settings.show', 'ads') }}" title="@lang('admin::settings/messages.ads')">
						<i class="fa fa-fw fa-dashboard"></i>
						@lang('admin::settings/messages.ads')
					</a>
				  </div><!-- /.info-box-content -->
				</div><!-- /.info-box -->					
			</div>
			<div class="col-md-3 col-xs-6">
				<div class="info-box">
				  <span class="info-box-icon bg-red"><i class="fa fa-fw fa-dashboard"></i></span>
				  <div class="info-box-content">
					<a href="{{ route('admin.settings.show', 'template') }}" title="@lang('admin::settings/messages.layout')">
						<i class="fa fa-fw fa-dashboard"></i>
						@lang('admin::settings/messages.layout')
					</a>
				  </div><!-- /.info-box-content -->
				</div><!-- /.info-box -->					
			</div>
		</div>
	</div>
@stop