<!--Invoice Information-->
<style>
    .receipt.table>tbody>tr>td,.receipt.table>thead>tr>th,.receipt.table>tbody>tr>th, .receipt.table>tfoot>tr>td, .receipt.table>tfoot>tr>th, .receipt.table>thead>tr>td,.receipt.table>thead>tr>th {
        padding:2px;font-size: 12px;font-family: sans-serif;
    }

    .receipt.table>thead>tr>th, .receipt.table>tbody>tr>th, .receipt.table>tfoot>tr>th, .receipt.table>thead>tr>td, .receipt.table>tbody>tr>td, .receipt.table>tfoot>tr>td {
        border: 1px solid rgba(82, 82, 82, 0.98);
        font-family: sans-serif;
    }
    .receipt.table>thead>tr {
        font-family: sans-serif;
        border-top: 1px solid;
    }
    @media print{@page {size: portrait}}
</style>
<div class="panel panel-default">
<div class="panel-heading">
	<button type="button" data-print="print-invoice" class="btn btn-primary btn-sm print"><i class="fa fa-print"></i> {{ _lang('Print Invoice') }}</button>
</div>
    <div class="panel-body">
		<div class="invoice-box" id="print-invoice">
		 @php $currency = get_option('currency_symbol') @endphp

		 <table>
             <tr class="information">
                 <td style="width: 25%">
                     <img src="{{ get_logo() }}" style="width:100px;">
                 </td>
                 <td style="text-align: center !important;width: 50%">
                     <h4><b>{{ get_option("school_name") }}</b></h4>
                     {{ _lang('Phone')." : ".get_option('phone') }}<br>
                     {{ _lang('Email')." : ".get_option('email') }}<br>
                     {{ _lang('Address')." : ".get_option("address") }}<br>
                 </td>
                 <td style="text-align: center !important;width: 25%">
                     <img src="{{ get_logo() }}" style="width:100px;">
                 </td>
			</tr>
             <tr>
                 <td class="text-left">
                     <h4><b>{{ _lang('Invoice To') }}</b></h4>
                     {{ _lang("Name")." : ".$invoice->first_name." ".$invoice->last_name }}
                     </br>
                     {{ _lang("Class")." : ".$invoice->class_name }},
                     {{ _lang("Section")." : ".$invoice->section_name }}<br>
                     Admission No: {{ $invoice->roll }}<br>
                 </td>
                 <td ></td>
                 <td class="text-right" >
                     <!--Invoice Payment Information-->
                     <h3>{{ $invoice->title }}</h3>
                     <h6>{{ _lang('Invoice Total') }} : &nbsp;{{ $currency." ".decimalPlace($invoice->total) }}</h6>
                 </td>
             </tr>
		</table>
        <table class="table receipt">
                    <thead style="background:#dce9f9;">
                    <tr>
                        <th>{{ _lang('Fee Type') }}</th>
                        <th style="text-align:right">{{ _lang('Amount')." ".get_option('currency_symbol') }}</th>
                        <th style="text-align:right">{{ _lang('Total')." ".get_option('currency_symbol') }}</th>
                    </tr>
                    </thead>
                    <tbody id="invoice">
                    @foreach($invoiceItems as $item)
                        <tr>
                            <td width="40%">{{ $item->fee_type }}</td>
                            <td style="text-align:right">{{ $currency." ".$item->amount }}</td>
                            <td style="text-align:right">{{ $currency." ".($item->amount-$item->discount) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            <!--Summary Table-->
            <div class="col-md-4 pull-right" style="background:#dce9f9">
                <table class="table receipt" >
                    <tr><td>{{ _lang('Total') }}</td><td style="text-align:right; width:50%;">{{ $currency." ".decimalPlace($invoice->total) }}</td></tr>
                    <tr><td>{{ _lang('Paid') }}</td><td style="text-align:right; width:120px;">{{ $currency." ".decimalPlace($invoice->paid) }}</td></tr>
                    <tr><td>{{ _lang('Amount Due') }}</td><td style="text-align:right; width:120px;">{{ $currency." ".decimalPlace($invoice->total-$invoice->paid) }}</td></tr>
                </table>
            </div>
            <!--End Summary Table-->
            <div class="clear"></div>

            <!--related Transaction-->
            @if( count($transactions) > 0 )
                <table class="table table-bordered receipt" style="margin-top:30px">
                    <thead>
                    <th colspan="3" style="text-align: center;">{{ _lang('Related Transaction') }}</th>
                    </thead>
                    <thead>
                    <th>{{ _lang('Date') }}</th>
                    <th>{{ _lang('Note') }}</th>
                    <th style="text-align: right;">{{ _lang('Amount') }}</th>
                    </thead>
                    <tbody>
                    @foreach($transactions as $trans)
                        <tr>
                            <td>{{ date('d/M/Y - H:m', strtotime($trans->created_at)) }}</td>
                            <td style="text-align: left;">{{ $trans->note }}</td>
                            <td style="text-align: right;">{{ $currency." ".decimalPlace($trans->amount) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endif
		</div>
    </div>
</div>
