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
        <button type="button" data-print="print-invoice" class="btn btn-primary btn-sm print"><i class="fa fa-print"></i> {{ _lang('Print Receipt') }}</button>
    </div>
    <div class="panel-body">
        <div class="invoice-box" id="print-invoice">
            @php $currency = get_option('currency_symbol') @endphp

            <table>
                <tr class="information">
                    <td style="width: 25%">
                        <img src="{{ get_logo() }}" style="width:100px;">
                    </td>
                    <td style="text-align: center !important;width: 50%;">
                        <h4 style="padding-top: 0;margin-top: 0;"><b>{{ get_option("school_name") }}</b></h4>
                        {{ _lang('Phone')." : ".get_option('phone') }}<br>
                        {{ _lang('Email')." : ".get_option('email') }}<br>
                        {{ _lang('Address')." : ".get_option("address") }}<br>
                    </td>
                    <td style="text-align: center !important;width: 25%">
                        <img src="{{ get_logo() }}" style="width:100px;">
                    </td>
                </tr>
            </table>
            <table class="table receipt">
                <thead style="background:#dce9f9;">
                <tr>
                    <th colspan="2">Particulars</th>
                </tr>
                </thead>
                <tbody id="invoice">
                <tr> <td> Pupil: </td> <td class="text-center">{{ $payment->student->first_name ?? '' }} {{ $payment->student->last_name ?? '' }}</td></tr>
                <tr> <td> Admission #: </td> <td class="text-center">{{ $payment->student->register_no ?? '' }} </td></tr>
                <tr> <td> Payment Ref:</td> <td class="text-left">{{ $studentpayment->note ?? '' }}</td></tr>
                <tr> <td> Date:</td> <td class="text-left">{{ \Carbon\Carbon::parse($studentpayment->date)->format('d/m/Y') }}</td></tr>
                </tbody>
            </table>

{{--            <!--Summary Table-->--}}
            <div class="col-md-6 pull-right " style="background:#dce9f9">
                <table class="table receipt">
                        <tr><td>Balance Before Payment: <td style="text-align:right; width:50%;">{{ $currency." ".decimalPlace($studentpayment->amount + $bcf) }}</td></tr>
                        <tr><td>Total Paid</td><td style="text-align:right; width:50%;">{{ $currency." ".decimalPlace($studentpayment->amount) }}</td></tr>
                    <tr><td>Balance After Payment: </td><td style="text-align:right; width:50%;">{{ $currency." ".decimalPlace($bcf) }}</td></tr>
                </table>
            </div>
        </div>
    </div>
</div>
