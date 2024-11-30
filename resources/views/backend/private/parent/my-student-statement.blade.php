@extends('layouts.backend')
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					Student Account Statement
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('parent/feeStatement') }}" method="POST" autocomplete="off" accept-charset="utf-8">
					@csrf

					<div class="col-sm-6 col-sm-offset-1">
					   <div class="form-group">
							<label class="control-label">{{ _lang('Select Student') }}</label>
							<select name="student_id" id="student_id" class="form-control select2" required>
{{--								<option value="">{{ _lang('Select One') }}</option>--}}
                                @if(count($students))
                                    @foreach($students as $student)
                                        <option value="{{ $student->id }}">{{ $student->first_name }} {{ $student->last_name }} - {{ $student->register_no }}</option>
                                    @endforeach
                                    @endif
							</select>
						</div>
					</div>

					<div class="col-sm-3">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block ">Show Statement</button>
						</div>
					</div>
				</form>
                @if(isset($statements))
                <div class="col-md-12 params-panel" id="report">
                    <button type="button" data-print="report" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>
                    <div class="text-center clear">
                        <h2>{{ get_option('school_name') }} </h2>
                        <h3>Student Statement</h3>
                    </div>

                    <h4>{{ $name }}</h4>
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>Date</th>
                            <th>Type</th>
                            <th>Reference</th>
                            <th class="text-right">Bills</th>
                            <th class="text-right">Payments</th>
                            <th class="text-right">Running Balance</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($statements))
                            @php $balance=0 @endphp
                            @foreach($statements as $statement)
                            @php
                                $c = ($statement->transaction_type == 'CREDIT')? $statement->amount: 0;
                                $d =($statement->transaction_type == 'DEBIT')? $statement->amount: 0;

                                @endphp
                            @php $balance = $balance + $c - $d @endphp
                                <tr>
                                    <td>{{ \Carbon\Carbon::parse($statement->date)->format('D m,Y') }}</td>
                                    <td>{{ (!is_null($statement->fee_id))? \App\FeeType::find($statement->fee_id)->fee_type: 'Payment' }}</td>
                                    <td>{{ (is_null($statement->payment_id))? \App\Invoice::find($statement->invoice_id)->title : \App\Payment::find($statement->payment_id)->ref_number }}</td>
                                    <td class="text-right"> {{ number_format($c,2) }}</td>
                                    <td class="text-right"> {{ number_format($d,2) }}</td>

                                    <th class="text-right">{{ number_format($balance,2) }} </th>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="6" class="text-center">No Records</td>
                            </tr>
                        @endif
                        </tbody>
                    </table>
                </div>
                @endif
			</div>
		</div>
	</div>
</div>
@endsection

@section('js-script')
<script type="text/javascript">

</script>
@stop
