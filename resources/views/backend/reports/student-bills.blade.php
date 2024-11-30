@extends('layouts.backend')
@push('css')
    @include('backend.reports.table-style')
@endpush
@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<span class="panel-title" >
					Student Balances
				</span>
			</div>
			<div class="panel-body">
				<form id="search_form" class="params-panel validate" action="{{ url('reports/studentBills') }}" method="post" autocomplete="off" accept-charset="utf-8">
					@csrf
					<div class="col-md-3">
						<div class="form-group">
							<label class="control-label">Class</label>
{{--							<div class="input-group">--}}
                            <select name="class" required class="form-control select2">
                                <option value="all">All Classes</option>
                                @if(count($classes))
                                    @foreach($classes as $class)
                                        <option value="{{ $class->id }}">{{ $class->class_name }}</option>
                                        @endforeach
                                    @endif
                            </select>
{{--                            </div>--}}
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date From') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="from" value="{{ $date1?? \Carbon\Carbon::today()->firstOfMonth()->toDateString() }}" readOnly="true" required>
						    </div>
						</div>
					</div>

					<div class="col-md-2">
						<div class="form-group">
							<label class="control-label">{{ _lang('Date To') }}</label>
							<div class="input-group">
								<span class="input-group-addon"><i class="glyphicon glyphicon-calendar"></i></span>
								<input type="text" class="form-control datepicker" name="to" value="{{ $date2 ?? \Carbon\Carbon::today()->endOfMonth()->toDateString() }}" readOnly="true" required>
						    </div>
						</div>
					</div>


					<div class="col-sm-3">
						<div class="form-group">
							<button type="submit" style="margin-top:24px;" class="btn btn-primary btn-block rect-btn">{{_lang('View Report')}}</button>
						</div>
					</div>
				</form>

				@if( isset($reports) )
				<div class="col-md-12 params-panel" id="report">
                    <button type="button" data-print="report" class="btn btn-primary btn-sm pull-right print"><i class="fa fa-print"></i> {{ _lang('Print Report') }}</button>
						<div class="text-center clear">
							{{ get_option('school_name') }}<br>
							Student Accounts {{ $date1." "._lang("to")." ".$date2 }}<br></br>
						</div>

                    @if(count($reports))
                        @php $currency = get_option('currency_symbol') @endphp
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Admission #</th>
                                    <th>Current Class</th>
                                    <th class="text-right">Balance BF</th>
                                    @if(count($billTypes))
                                        @foreach($billTypes as $b)
                                            <th>{{ $b['name']}}</th>
                                        @endforeach
                                    <th class="text-right">Total Bills</th>
                                            <th class="text-right">Total Balance</th>
                                    @endif
                                    <th class="text-right">Payments</th>
                                    <th class="text-right">Arrears CF</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php $count = 1 @endphp
                                @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $count }}</td>
                                        <td>{{ $report['name'] }}</td>
                                        <td>{{ $report['admn'] }}</td>
                                        <td>{{ $report['class'] }}</td>
                                        <td class="text-right">{{ number_format($bbf = $report['bbf']) }}</td>
                                    @if(count($billTypes))
                                            @foreach($billTypes as $b)
                                                <td class="text-right">{{ number_format($report['bills']->where('fee_type_id',$b['fee_type_id'])->sum('amount')) }}</td>
                                            @endforeach
                                                <td class="text-right">{{ number_format($tb = $report['bills']->sum('amount')) }}</td>
                                                <td class="text-right">{{ number_format($bbf+ $tb) }}</td>
                                        @endif
                                        <td class="text-right">{{ number_format($report['currentPayments']) }}</td>
                                        <td class="text-right">{{ number_format($report['arrears']) }}</td>
                                    </tr>
                                    @php $count++ @endphp
                                @endforeach
                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-right">{{ number_format($reports->sum('bbf')) }}</th>
                                    @if(count($billTypes))
                                        @foreach($billTypes as $b)
                                            <td></td>
                                        @endforeach
                                        <td></td>
                                            <th class="text-right">{{ number_format($reports->sum('totalBal')) }}</th>
                                    @endif
                                    <th class="text-right">{{ number_format($reports->sum('currentPayments')) }}</th>
                                    <th class="text-right">{{ number_format($reports->sum('arrears')) }}</th>
                                </tr>
                                </tbody>
                            </table>
                    @endif

				</div>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
