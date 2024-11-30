@extends('layouts.backend')

@section('content')
<div class="row">
	<div class="col-md-6">
	<div class="panel panel-default">
	<div class="panel-heading">Class Fee Structure</div>

	<div class="panel-body">
	  <form method="post" class="validate" autocomplete="off" action="{{url('structure')}}" enctype="multipart/form-data">
		{{ csrf_field() }}

		<div class="col-md-12">
		  <div class="form-group">
			<label class="control-label">Class</label>
              <select name="class_id" required class="form-control select2">
                  <option value="">Select Class</option>
                  @if(count($classes))
                      @foreach($classes as $class)
                          <option value="{{ $class->id }}">{{$class->class_name}}</option>
                      @endforeach
                      @endif
              </select>
		  </div>
		</div>
		<div class="form-group">
		  <div class="col-md-12">
              <br>
              <br>
              <br>
		    <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
			<button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
		  </div>
		</div>
	  </form>
	</div>
  </div>
 </div>
</div>
@endsection


