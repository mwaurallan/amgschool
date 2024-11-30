@extends('layouts.backend')
@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/paper-css/0.3.0/paper.css">

    <style>@media print
        {@page { size: A5 landscape }}
    </style>
@endpush
@section('content')

<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title">{{ _lang('List Student Payment') }}</span>

                <select id="class" class="select_class pull-right" onchange="showClass(this);">
				   <option value="">{{ _lang('Select Class') }}</option>
				   {{ create_option('classes','id','class_name',$class) }}
				</select>
                <a class="btn btn-primary btn-sm pull-right" data-title="Add Payment" data-toggle="modal" onclick="openModal()">Add New</a>
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
				<th>Payment #</th>
				<th>Student</th>
				<th>{{ _lang('Date') }}</th>
				<th>{{ _lang('Amount') }}</th>
				<th>Reference</th>
				<th>{{ _lang('Action') }}</th>
			  </tr>
			</thead>
			<tbody>
			  @php $currency = get_option('currency_symbol') @endphp
			  @foreach($studentpayments as $studentpayment)
			    <tr id="row_{{ $studentpayment->id }}">
					<td class='invoice_id'>{{ $studentpayment->id }}</td>
					<td class='invoice_id'>{{ $studentpayment->invoice->student->first_name ?? ''}} {{ $studentpayment->invoice->student->last_name ?? '' }}</td>
					<td class='date'>{{ date('d-M-Y', strtotime($studentpayment->date)) }}</td>
					<td class='amount'>{{ $currency." ".$studentpayment->amount }}</td>
					<td class='note'>{{ $studentpayment->note }}</td>
					<td>
					  <form action="{{action('StudentPaymentController@destroy', $studentpayment['id'])}}" method="post">
{{--						<a href="{{action('StudentPaymentController@edit', $studentpayment['id'])}}" data-title="{{ _lang('Update Student Payment') }}" class="btn btn-warning btn-sm ajax-modal">{{ _lang('Edit') }}</a>--}}
						<a href="{{action('StudentPaymentController@show', $studentpayment['id'])}}" data-title="{{ _lang('View Student Payment') }}" data-fullscreen="true" class="btn btn-info btn-sm ajax-modal">{{ _lang('View') }}</a>
						{{ csrf_field() }}
						<input name="_method" type="hidden" value="DELETE">
						<button class="btn btn-danger btn-sm btn-remove" type="submit">Reverse</button>
					  </form>
					</td>
			    </tr>
			  @endforeach
			</tbody>
		  </table>
			</div>
		</div>
	</div>
</div>
<div id="add-payment-modal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" action="{{ route('student_payments.store') }}">
                 @csrf
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Payment</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label>Student</label>
                    <select name="student_id" class="form-control select2">
                        <option value="">Select student</option>
                        @if(count($students))
                            @foreach($students as $student)
                                <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }}</option>
                            @endforeach
                            @endif
                    </select>
                </div>
                <div class="form-group">
                    <label>Payment Method</label>
                    <select name="payment_method" class="form-control" >
                        <option value="MPESA">Mpesa</option>
                        <option value="CASH">Cash</option>
                        <option value="CHEQUE">Cheque</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Reference</label>
                    <input  type="text" class="form-control" name="reference_number" required >
                </div>
                <div class="form-group">
                    <label>Amount</label>
                    <input type="number" class="form-control" name="amount" required >
                </div>
                <div class="form-group">
                    <label>Payment Date</label>
                    <input type="date" class="form-control" name="date" value="{{ \Carbon\Carbon::today()->toDateString() }}" required >
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>

    </div>
</div>

{{--<div class="modal fade" id="add-payment-modal" role="dialog">--}}
{{--    {!! Form::open(['route' => 'banks.store']) !!}--}}
{{--    <div class="modal-dialog">--}}
{{--        <div class="modal-content">--}}
{{--            <div class="modal-header">--}}
{{--                <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                    <span aria-hidden="true">&times;</span>--}}
{{--                </button>--}}
{{--                <h4 class="modal-title">Create Bank</h4>--}}
{{--            </div>--}}
{{--            <div class="modal-body">--}}
{{--                <div class="row">--}}
{{--                    @include('banks.fields')--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            <div class="modal-footer">--}}
{{--                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>--}}
{{--                <button type="submit" class="btn btn-primary">Save</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- /.modal-content -->--}}
{{--    </div>--}}
{{--    <!-- /.modal-dialog -->--}}
{{--    {!! Form::close() !!}--}}
{{--</div>--}}

@endsection

@section('js-script')
<script>
function showClass(elem){
	if($(elem).val() == ""){
		return;
	}
	window.location = "<?php echo url('student_payments/class') ?>/"+$(elem).val();
}

function openModal(){
    $('#add-payment-modal').modal({
        'backdrop':false
    })
}
</script>
@stop
