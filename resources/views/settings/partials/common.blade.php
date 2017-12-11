@if($group->settings->count())
	@foreach($group->settings as $setting)
		<div class="form-group">
			<label clasS="control-label col-sm-2">{{$setting->name}}</label>
			<div class="col-sm-10">
				@if($setting->type == 'textarea')
				<textarea class="form-control" name="settings[{{$setting->handle}}]">{{$setting->value}}</textarea>
				@else
				<input class="form-control" type="{{is_numeric($setting->value) ? 'number' : 'text'}}" name="settings[{{$setting->handle}}]" value="{{$setting->value}}" placeholder="{{$setting->default}}">
				@endif
				@if($setting->description)
					<span class="help-block">{!! $setting->description !!}</span>
				@endif
			</div>
		</div>
	@endforeach
@endif
