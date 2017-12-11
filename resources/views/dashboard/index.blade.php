@extends('adminlte::page')

@section('content')

@if (!empty($statistics))

<div class="row">

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
	    <span class="info-box-icon bg-aqua"><i class="fa fa-user-plus"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">{{ trans('admin::dashboard.fields.dashboard.total_visits') }}</span>
	      <span class="info-box-number">{{{ $statistics['total_visits'] }}}</span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
	    <span class="info-box-icon bg-red"><i class="fa fa-user-times"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">{{ trans('admin::dashboard.fields.dashboard.bounce_rate') }}</span>
	      <span class="info-box-number">{{{ $statistics['averages']['bounce'] }}}<small>%</small></span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
	    <span class="info-box-icon bg-yellow"><i class="fa fa-clock-o"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">{{ trans('admin::dashboard.fields.dashboard.average_time') }}</span>
	      <span class="info-box-number">{{{ $statistics['averages']['time'] }}}</span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div>

	<div class="col-md-3 col-sm-6 col-xs-12">
	  <div class="info-box">
	    <span class="info-box-icon bg-green"><i class="fa fa-arrows-h"></i></span>
	    <div class="info-box-content">
	      <span class="info-box-text">{{ trans('admin::dashboard.fields.dashboard.page_visits') }}</span>
	      <span class="info-box-number">{{{ $statistics['averages']['visit'] }}}</span>
	    </div><!-- /.info-box-content -->
	  </div><!-- /.info-box -->
	</div>

</div>

<div class="row">

    <div class="col-md-8">
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active">
                    <a href="#pages" data-toggle="tab">
                        <i class="fa fa-file"></i> {{ trans('admin::dashboard.fields.dashboard.pages') }}
                    </a>
                </li>
                <li>
                    <a href="#keywords" data-toggle="tab">
                        <i class="fa fa-key"></i> {{ trans('admin::dashboard.fields.dashboard.keywords') }}
                    </a>
                </li>
                <li>
                    <a href="#entrance-pages" data-toggle="tab">
                        <i class="fa fa-building-o"></i> {{  trans('admin::dashboard.fields.dashboard.entrance_pages') }}
                    </a>
                </li>
                <li>
                    <a href="#exit-pages" data-toggle="tab">
                        <i class="fa fa-power-off"></i> {{ trans('admin::dashboard.fields.dashboard.exit_pages') }}
                    </a>
                </li>
                <li>
                    <a href="#time-pages" data-toggle="tab">
                        <i class="fa fa-clock-o"></i> {{ trans('admin::dashboard.fields.dashboard.time_pages') }}
                    </a>
                </li>
                <li>
                    <a href="#traffic-sources" data-toggle="tab">
                        <i class="fa fa-lightbulb-o"></i> {{ trans('admin::dashboard.fields.dashboard.traffic_sources') }}
                    </a>
                </li>
                <li>
                    <a href="#browsers" data-toggle="tab">
                        <i class="fa fa-android"></i> {{ trans('admin::dashboard.fields.dashboard.browsers') }}
                    </a>
                </li>
                <li>
                    <a href="#os" data-toggle="tab">
                        <i class="fa fa-linux"></i> {{ trans('admin::dashboard.fields.dashboard.os') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content no-padding">
                <div class="tab-pane statistic-tabs" id="entrance-pages">
                        <table class="table">
                            <tbody>
                            <tr>
                              <th>Page</th>
                              <th>#</th>
                            </tr>
                            @foreach($statistics['landings'] as $p)
                            <tr>
                                <td>{{ $p['path'] }}</td>
                                <td>{{ $p['visits'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="tab-pane statistic-tabs" id="exit-pages">
                        <table class="table">
                            <tbody>
                            <tr>
                              <th>Exit</th>
                              <th>#</th>
                            </tr>
                            @foreach($statistics['exits'] as $p)
                            <tr>
                                <td>{{ $p['path'] }}</td>
                                <td>{{ $p['visits'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="tab-pane statistic-tabs" id="time-pages">
                        <table class="table">
                            <tbody>
                            <tr>
                              <th>Page</th>
                              <th>#</th>
                            </tr>
                            @foreach($statistics['times'] as $p)
                            <tr>
                                <td>{{ $p['path'] }}</td>
                                <td>{{ $p['time'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="tab-pane statistic-tabs" id="traffic-sources">
                        <table class="table">
                            <tbody>
                            <tr>
                              <th>Source</th>
                              <th>#</th>
                            </tr>
                            @foreach($statistics['sources'] as $p)
                            <tr>
                                <td>{{ $p['path'] }}</td>
                                <td>{{ $p['visits'] }}</td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                </div>
                <div class="tab-pane statistic-tabs" id="browsers">

					<div class="box-body no-padding">
	                	<table class="table">
	                		<tbody>
		                    <tr>
		                      <th>Browser</th>
		                      <th>#</th>
		                    </tr>
                        	@foreach($statistics['browsers'] as $p)
	                        <tr>
	                        	<td>{{ $p['browser'] }}</td>
	                        	<td>{{ $p['visits'] }}</td>
	                        </tr>
	                        @endforeach
	                  		</tbody>
	              		</table>
	                </div>

                </div>
                <div class="tab-pane statistic-tabs" id="os">

					<div class="box-body no-padding">
	                	<table class="table">
	                		<tbody>
		                    <tr>
		                      <th>OS</th>
		                      <th>#</th>
		                    </tr>
	                        @foreach($statistics['ops'] as $p)
	                        <tr>
	                        	<td>{{ $p['os'] }}</td>
	                        	<td>{{ $p['visits'] }}</td>
	                        </tr>
	                        @endforeach
	                  		</tbody>
	              		</table>
	                </div>

                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <div class="box box-info">
            <div class="box-header with-border">
                <i class="fa fa-users"></i>
                <h3 class="box-title">{{ trans('admin::dashboard.fields.dashboard.visits') }}</h3>
            </div>
            <div class="box-body chart-responsive">
                <div class="chart right-charts" id="visitor-chart"></div>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-xs-12">
        <div class="box bg-gray-white">
            <div class="box-header">
                <i class="fa fa-globe"></i>
                <h3 class="box-title">{{ trans('admin::dashboard.fields.dashboard.world_visitors') }}</h3>
            </div>
            <div class="box-body">
                <div id="world-map"></div>
            </div>
        </div>
    </div>
</div>

@endif

@stop

{{-- Scripts --}}
@if (!empty($statistics))
@section('js')


    <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" type="text/javascript"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script>

        $(function() {
            Morris.Line({
                element: 'visitor-chart',
                data: {!! $statistics['visits'] !!},
                xkey: 'date',
                ykeys: ['visits'],
                labels: ['{{ trans('admin::dashboard.fields.dashboard.visits') }}'],
                lineColors: ['#3c8dbc'],
                hideHover: 'auto',
                resize: true,
                redraw: true
            });
        });

        google.load("visualization", "1", {packages:["geochart"]});
        google.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
            var data = new google.visualization.DataTable();
            data.addColumn('string', '{{ trans('admin.fields.dashboard.chart_country') }}');
            data.addColumn('number', '{{ trans('admin.fields.dashboard.chart_visitors') }}');
            data.addRows({!! $statistics['countries'] !!});
            var options = {
                colors:['#c8e0ed','#24536e'],
                backgroundColor: '#f9f9f9',
                datalessRegionColor: '#e5e5e5',
                legend:  {textStyle: {fontName: 'Source Sans Pro'}}
            };
            var chart = new google.visualization.GeoChart(document.getElementById('world-map'));
            chart.draw(data, options);
        }

    </script>


@stop
@endif

{{-- CSS --}}
@section('css')

<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">

@stop