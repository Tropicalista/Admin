<br />

@if (count($errors->all()) > 0)
<div class="alert alert-danger alert-block">
    
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4><i class="fa fa-ban"></i> Error</h4>
	Please check the form below for errors
</div>
@endif

@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    
	<button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
	<h4><i class="fa fa-check"></i> Success</h4>
    @if(is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-dismissable">
    
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h4><i class="fa fa-ban"></i> Error</h4>
    @if(is_array($message)) 
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
</div>
@endif

@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    <h4><i class="fa fa-warning"></i> Warning</h4>
    @if(is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
</div>
@endif

@if ($message = Session::get('info'))
<div class="alert alert-info alert-block">
    
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<h4><i class="fa fa-info"></i> Info</h4>
    @if(is_array($message))
    @foreach ($message as $m)
    {{ $m }}
    @endforeach
    @else
    {{ $message }}
    @endif
</div>
@endif
