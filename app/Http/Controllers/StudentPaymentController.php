<?php

namespace App\Http\Controllers;

use App\InvoiceItem;
use App\Payment;
use App\Student;
use App\StudentAccount;
use Illuminate\Http\Request;
use App\StudentPayment;
use App\Invoice;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class StudentPaymentController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = "")
    {
        $studentpayments = array();
        if ($class != "") {
            $studentpayments = StudentPayment::join('invoices', 'invoices.id', '=', 'student_payments.invoice_id')
                ->select('invoices.*', 'student_payments.*', 'student_payments.id as id')
//                ->where('invoices.session_id', get_option('academic_year'))
                ->where('invoices.class_id', $class)
                ->with(['invoice.student'])
                ->orderBy('student_payments.id', 'DESC')
                ->get();
        } else {
            $studentpayments = StudentPayment::join('invoices', 'invoices.id', '=', 'student_payments.invoice_id')
                ->select('invoices.*', 'student_payments.*', 'student_payments.id as id')
//                ->where('invoices.session_id', get_option('academic_year'))
//                ->where('invoices.class_id',$class)
                ->with(['invoice.student:id,first_name,last_name'])
                ->orderBy('student_payments.id', 'DESC')
                ->get();
        }

        $students = Student::all();
        return view('backend.student_payment.list', compact('studentpayments', 'class', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $invoice_id = "")
    {
        $invoice = Invoice::find($invoice_id);
        $history = StudentPayment::where("invoice_id", $invoice_id)->get();
        if (!$request->ajax()) {
            return view('backend.student_payment.create', compact('invoice_id', 'invoice', 'history'));
        } else {
            return view('backend.student_payment.modal.create', compact('invoice_id', 'invoice', 'history'));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        print_r($request->all());die;
        $validator = Validator::make($request->all(), [
//			'invoice_id' => 'required',
            'date' => 'required',
            'amount' => 'required|numeric',
            'reference_number' => 'required|unique:payments,ref_number'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        DB::transaction(function () use ($request) {
            $payment = Payment::create([
                'payment_mode' => $request->payment_method,
                'student_id' => $request->student_id,
                'ref_number' => $request->reference_number,
                'amount' => $request->amount,
                'received_on' => $request->date
            ]);

            $bills = StudentAccount::where('student_id', $request->student_id)
                ->where('transaction_type', 'CREDIT')->sum('amount');

            $payments = StudentAccount::where('student_id', $request->student_id)
                ->where('transaction_type', 'DEBIT')->sum('amount');

//            dd($payments);
            $prepayments = $bills - $payments;

            $studentAccount = StudentAccount::create([
                'student_id' => $request->student_id,
                'payment_id' => $payment->id,
                'transaction_type' => 'DEBIT',
                'amount' => $request->amount,
                'date' => $request->date,
            ]);

            //first get all invoices for this student
            $invoices = Invoice::where('student_id', $request->student_id)
                ->orderBy('id')->get();
            $amountPaid = $request->amount + (($prepayments < 0) ? -$prepayments : 0);
//            dd($amountPaid);
            if (count($invoices)) {
                foreach ($invoices as $inv) {
                    //check invoice balance
                    $invoiceBills = InvoiceItem::where('invoice_id', $inv->id)->sum('amount');
                    $invoicePayments = StudentPayment::where('invoice_id', $inv->id)->sum('amount');
                    $invoiceBalance = $invoiceBills - $invoicePayments;
                    if ($invoiceBalance > 0 && $amountPaid > 0) {

                         $payable = ($amountPaid >= $invoiceBalance) ? $invoiceBalance :  $amountPaid;
                        //pay the balance
                        $studentpayment = new StudentPayment();
                        $studentpayment->invoice_id = $inv->id;
                        $studentpayment->date = $payment->received_on;
                        $studentpayment->payment_id = $payment->id;
                        $studentpayment->amount = $payable;
                        $studentpayment->note = $payment->ref_number;
                        $studentpayment->save();

                        $amountPaid = $amountPaid - $payable;

                        //Update Invoice
                        $invoice = Invoice::find($studentpayment->invoice_id);
                        if (($invoice->paid + $studentpayment->amount) >= $invoice->total) {
                            $invoice->status = "Paid";
                        }
                        $invoice->paid = $invoice->paid + $studentpayment->amount;
                        $invoice->save();
                    }
                }
            }
        });


        if (!$request->ajax()) {
            return redirect()->back()->with('success', _lang('Information has been added sucessfully'));
        } else {
            return response()->json(['result' => 'success',
                'action' => 'store2', 'message' => _lang('Information has been added sucessfully'),
                'data' => $studentpayment]);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $studentpayment = StudentPayment::find($id);
        $payment = Payment::where('id',$studentpayment->payment_id)->with(['student'])->first();
        $invoices = Invoice::where('id',$studentpayment->invoice_id)
            ->get();
        $balanceBf = StudentAccount::where('student_id',$payment->student->id)
            ->where('date','<=',$studentpayment->date)->where('transaction_type','CREDIT')->sum('amount') - StudentAccount::where('student_id',$payment->student->id)
                ->where('date','<=',$studentpayment->date)->where('transaction_type','DEBIT')->sum('amount');
        $balancecf = StudentAccount::where('student_id',$payment->student->id)
           ->where('transaction_type','CREDIT')->sum('amount') - StudentAccount::where('student_id',$payment->student->id)->where('transaction_type','DEBIT')->sum('amount');

        if (!$request->ajax()) {
            return view('backend.student_payment.view', compact('studentpayment', 'id','payment'),[
                'bbf' => $balanceBf - $studentpayment->amount,
                'invoices' => $invoices,
                'bcf' => $balancecf
            ]);
        } else {
            return view('backend.student_payment.modal.view', compact('studentpayment', 'id'),[
                'invoices' => $invoices,
                'payment'=> $payment,
                'bbf' => $balanceBf,
                'bcf' => $balancecf
            ]);
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $studentpayment = StudentPayment::find($id);
        $history = StudentPayment::where("invoice_id", $studentpayment->invoice_id)->get();
        if (!$request->ajax()) {
            return view('backend.student_payment.edit', compact('studentpayment', 'id', 'history'));
        } else {
            return view('backend.student_payment.modal.edit', compact('studentpayment', 'id', 'history'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $validator = Validator::make($request->all(), [
            'invoice_id' => 'required',
            'date' => 'required',
            'amount' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('student_payments.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }


        $studentpayment = StudentPayment::find($id);
        $previous_amount = $studentpayment->amount;
        $studentpayment->invoice_id = $request->input('invoice_id');
        $studentpayment->date = $request->input('date');
        $studentpayment->amount = $request->input('amount');
        $studentpayment->note = $request->input('note');

        $studentpayment->save();

        //Update Invoice
        $invoice = Invoice::find($studentpayment->invoice_id);
        if ((($invoice->paid + $studentpayment->amount) - $previous_amount) >= $invoice->total) {
            $invoice->status = "Paid";
        } else {
            $invoice->status = "Unpaid";
        }
        $invoice->paid = (($invoice->paid + $studentpayment->amount) - $previous_amount);
        $invoice->save();

        if (!$request->ajax()) {
            return redirect('student_payments')->with('success', _lang('Information has been updated sucessfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Information has been updated sucessfully'), 'data' => $studentpayment]);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::transaction(function()use($id){
            $studentpayment = StudentPayment::find($id);
            $pId = $studentpayment->payment_id;
            $studentpayment->delete();
            $account = StudentAccount::where('payment_id',$pId)->delete();
            $payments = Payment::where('id',$pId)->delete();
        });

        return redirect('student_payments')->with('success', _lang('Information has been deleted sucessfully'));
    }
}
