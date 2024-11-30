@extends('layouts.backend')

@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default no-export">
			<div class="panel-heading"><span class="panel-title">Fee Structures</span>
			<a class="btn btn-primary btn-sm pull-right" data-title="add fee structure" href="{{route('structure.create')}}">{{ _lang('Add New') }}</a>
			</div>

			<div class="panel-body">
			 @if (\Session::has('success'))
			  <div class="alert alert-success">
				<p>{{ \Session::get('success') }}</p>
			  </div>
			  <br />
			 @endif
			<table class="table table-bordered data-table">
			<thead>
			  <tr>
				<th>Class</th>
				<th>Title</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>

            @if(count($structures))
			  @foreach($structures as $structure)
			  <tr id="row_{{ $structure->id }}">
				<td class='fee_type'>{{ $structure->c->class_name }}</td>
				<td class='fee_code'>{{ $structure->title }}</td>

				<td>
				  <form action="{{action('FeeStructureController@destroy', $structure['id'])}}" method="post">
{{--                      <a href="{{action('FeeStructureController@show', $structure['id'])}}" data-title="{{ _lang('View Fee Type') }}" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>--}}
                      <a href="{{ url('structure/createStructureDetails/'.$structure->id) }}" data-title="{{ _lang('Update Fee Type') }}" class="btn btn-info btn-sm">View/Update Structure</a>
					{{ csrf_field() }}
{{--					<input name="_method" type="hidden" value="DELETE">--}}
{{--					<button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>--}}
				  </form>
				</td>
			  </tr>
			  @endforeach
                @endif
			</tbody>

		  </table>
			</div>
		</div>
	</div>
</div>

@endsection


