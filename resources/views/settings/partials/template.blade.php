@if($group->settings->count())

@php
	$layout = [
				'amelia' => 'amelia',
				'bootflat' => 'bootflat',
				'cerulean' => 'cerulean',
				'cosmo' => 'cosmo',
				'cyborg' => 'cyborg',
				'flat-ui' => 'flat-ui',
				'flatly' => 'flatly',
				'journal' => 'journal',
				'lumen' => 'lumen',
				'material' => 'material',
				'readable' => 'readable',
				'simplex' => 'simplex',
				'slate' => 'slate',
				'spacelab' => 'spacelab',
				'superhero' => 'superhero',
				'united' => 'united',
				'yeti' => 'yeti'
			];
@endphp


	{{-- Layout setting --}}
	<div class="form-group">
		<label clasS="control-label col-sm-2">{{$setting->handle('layout')->name}}</label>
		<div class="col-sm-10">
			<select class="form-control" name="settings[{{$setting->handle('layout')->handle}}]">
			@foreach ($layout as $key => $value)
			    <option value="{{ $key }}"
			    @if ($key == $setting->handle('layout')->value)
			        selected="selected"
			    @endif
			    >{{$value}}</option>
			@endforeach
			</select>
			@if($setting->handle('layout')->description)
				<span class="help-block">{{ $setting->handle('layout')->description }}</span>
			@endif
		</div>
	</div>

@endif