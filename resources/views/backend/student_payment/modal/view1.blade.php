
<div class="panel panel-default A5">
<div class="panel-body sheet padding-10mm " id="print-receipt">
    <table class="table ">
        <tr>
            <td colspan="2" class="text-right">
                {{ get_option("school_name") }} <br>
{{--                    {{ _lang('Address')." : ".get_option("address") }}<br>--}}
                    {{ _lang('Email')." : ".get_option('email') }}<br>

            </td>
        </tr>
    </table>
  <table class="table table-bordered">
      <tr><th>Payment Reference</th><td>{{ $studentpayment->note }}</td></tr>
      <tr><td>Student Name</td><td>{{ $invoice->student->first_name }} {{ $invoice->student->last_name }}</td></tr>
      <tr><td>Class</td><td>{{ $studentpayment->stream->class_name?? '' }}</td></tr>
	 <tr><td>Receipt #</td><td>{{ $studentpayment->id }}</td></tr>
	 <tr><td>{{ _lang('Date') }}</td><td>{{ date('d-M-Y', strtotime($studentpayment->date)) }}</td></tr>
      <tr><td>Balance Bf</td><td>{{ $studentpayment->id }}</td></tr>
      <tr><td>{{ _lang('Amount') }}</td><td>{{ get_option('currency_symbol')." ".$studentpayment->amount }}</td></tr>
	 <tr><td>Balance CF</td><td>0</td></tr>
  </table>
    <button type="button" data-print="print-receipt"  class="btn btn-primary btn-sm print"><i class="fa fa-print"></i> Print Receipt</button>

</div>
</div>
