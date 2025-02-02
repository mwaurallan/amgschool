<?php

namespace App\Http\Controllers;

use App\Student;
use App\StudentAccount;
use App\StudentSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Invoice;
use App\InvoiceItem;
use App\StudentPayment;
use Illuminate\Support\Facades\DB;
use Validator;
use Illuminate\Validation\Rule;

class InvoiceController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($class = "")
    {
//        dd($class);
        $invoices = array();
        if ($class != "") {
            $invoices = Invoice::join('students', 'invoices.student_id', '=', 'students.id')
                ->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
                ->join('classes', 'classes.id', '=', 'student_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'student_sessions.section_id')
                ->select('invoices.*', 'students.first_name', 'students.last_name', 'student_sessions.roll', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
                ->where('student_sessions.session_id', get_option('academic_year'))
                ->where('invoices.session_id', get_option('academic_year'))
                ->where('invoices.class_id', $class)
                ->orderBy('invoices.id', 'DESC')
                ->get();
        }else{
            $invoices = Invoice::join('students', 'invoices.student_id', '=', 'students.id')
                ->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
                ->join('classes', 'classes.id', '=', 'student_sessions.class_id')
                ->join('sections', 'sections.id', '=', 'student_sessions.section_id')
                ->select('invoices.*', 'students.first_name', 'students.last_name', 'student_sessions.roll', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
                ->where('student_sessions.session_id', get_option('academic_year'))
                ->where('invoices.session_id', get_option('academic_year'))
//                ->where('invoices.class_id', $class)
                ->orderBy('invoices.id', 'DESC')
                ->get();
        }
        return view('backend.invoice.list', compact('invoices', 'class'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if (!$request->ajax()) {
            return view('backend.invoice.create');
        } else {
            return view('backend.invoice.modal.create');
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
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);

//        print_r($request->all());die;

        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'class_id' => 'required',
//			'section_id' => 'required',
            'due_date' => 'required',
            'title' => 'required|max:191',
            'total' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect('invoices/create')
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $invoice = DB::transaction(function () use ($request) {
            if ($request->input('student_id') == "all") {
                foreach ($request->input('students') as $student_id) {
                    if($request->input('class_id') == 'all'){
                        $section = StudentSession::where('student_id',$request->input('student_id'))
                            ->where('session_id',get_option('academic_year'))
                            ->first();
                        $class_id = $section->class_id;
                        $section_id = $section->section_id;
                    }else{
                        $section = StudentSession::where('student_id',$request->input('student_id'))
                            ->where('session_id',get_option('academic_year'))
                            ->where('class_id',$request->input('class_id'))->first();
                        $class_id = $request->input('class_id');
                        $section_id = $section->section_id ?? 1;
                    }
                    $invoice = new Invoice();
                    $invoice->student_id = $student_id;
                    $invoice->class_id = $class_id;
                    $invoice->section_id = $section_id;
                    $invoice->session_id = get_option('academic_year');
                    $invoice->due_date = $request->input('due_date');
                    $invoice->title = $request->input('title');
                    $invoice->description = $request->input('description');
                    $invoice->total = $request->input('total');
                    $invoice->status = $request->input('status');

                    $invoice->save();

                    //Store Invoice Item
                    $counter = 0;
                    foreach ($request->input("fee_type") as $fee_id) {
                        if ($request->input("amount")[$counter] == 0 && $fee_id == "") {
                            continue;
                        }
                        $invoiceItem = new InvoiceItem();
                        $invoiceItem->invoice_id = $invoice->id;
                        $invoiceItem->fee_id = $fee_id;
                        $invoiceItem->amount = $request->input("amount")[$counter];
                        $invoiceItem->discount = $request->input("discount")[$counter];
                        $invoiceItem->save();

                        $account = StudentAccount::create([
                            'student_id' => $student_id,
                            'invoice_id' => $invoice->id,
                            'invoice_item_id' => $invoiceItem->id,
                            'fee_id' => $fee_id,
                            'class_id' => $request->input('class_id'),
                            'transaction_type' => 'CREDIT',
                            'amount' => $invoiceItem->amount,
                            'date' => Carbon::now()
                        ]);

                        $counter++;
                    }
                }
            } else {
                //Store Single Student Invoice

                if($request->input('class_id') == 'all'){
                    $section = StudentSession::where('student_id',$request->input('student_id'))
                        ->where('session_id',get_option('academic_year'))
                        ->first();
                    $class_id = $section->class_id;
                    $section_id = $section->section_id;
                }else{
                    $section = StudentSession::where('student_id',$request->input('student_id'))
                        ->where('session_id',get_option('academic_year'))
                    ->where('class_id',$request->input('class_id'))->first();
                    $class_id = $request->input('class_id');
                    $section_id = $section->section_id;
                }

                $invoice = new Invoice();
                $invoice->student_id = $request->input('student_id');
                $invoice->class_id = $class_id;
                $invoice->section_id = $section_id;
                $invoice->session_id = get_option('academic_year');
                $invoice->due_date = $request->input('due_date');
                $invoice->date = $request->input('date');
                $invoice->title = $request->input('title');
                $invoice->description = $request->input('description');
                $invoice->total = $request->input('total');
                $invoice->status = $request->input('status');

                $invoice->save();

                //Store Invoice Item
                $counter = 0;
                foreach ($request->input("fee_type") as $fee_id) {
                    if ($request->input("amount")[$counter] == 0) {
                        continue;
                    }
                    $invoiceItem = new InvoiceItem();
                    $invoiceItem->invoice_id = $invoice->id;
                    $invoiceItem->fee_id = $fee_id;
                    $invoiceItem->amount = $request->input("amount")[$counter];
                    $invoiceItem->discount = $request->input("discount")[$counter];
                    $invoiceItem->save();
                    $account = StudentAccount::create([
                        'student_id' => $request->input('student_id'),
                        'invoice_id' => $invoice->id,
                        'invoice_item_id' => $invoiceItem->id,
                        'fee_id' => $fee_id,
                        'class_id' => $request->input('class_id'),
                        'transaction_type' => 'CREDIT',
                        'amount' => $invoiceItem->amount,
                        'date' => $invoice->date
                    ]);
                    $counter++;
                }
            }
        });

        if (!$request->ajax()) {
            return redirect('invoices/create')->with('success', _lang('Invoice Created sucessfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'store', 'message' => _lang('Invoice Created sucessfully'), 'data' => $invoice]);
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
        $invoice = Invoice::join('students', 'invoices.student_id', '=', 'students.id')
            ->join('student_sessions', 'students.id', '=', 'student_sessions.student_id')
            ->join('classes', 'classes.id', '=', 'student_sessions.class_id')
            ->join('sections', 'sections.id', '=', 'student_sessions.section_id')
            ->select('invoices.*', 'students.first_name', 'students.last_name', 'student_sessions.roll', 'classes.class_name', 'sections.section_name', 'invoices.id as id')
            ->where('student_sessions.session_id', get_option('academic_year'))
            ->where('invoices.session_id', get_option('academic_year'))
            ->where('invoices.id', $id)->first();
        $invoiceItems = InvoiceItem::join("fee_types", "invoice_items.fee_id", "=", "fee_types.id")
            ->where("invoice_id", $id)->get();

        $transactions = StudentPayment::where("invoice_id", $id)->get();

        if (!$request->ajax()) {
            return view('backend.invoice.view', compact('invoice', 'id', 'invoiceItems', 'transactions'));
        } else {
            return view('backend.invoice.modal.view', compact('invoice', 'id', 'invoiceItems', 'transactions'));
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
        $invoice = Invoice::where("id", $id)
//            ->where("session_id", get_option('academic_year'))
            ->with('student')
            ->first();
        if (empty($invoice)) {
            abort(404);
        }
        $invoiceItems = InvoiceItem::where("invoice_id", $id)->get();
        if (!$request->ajax()) {
            return view('backend.invoice.edit', compact('invoice', 'id', 'invoiceItems'));
        } else {
            return view('backend.invoice.modal.edit', compact('invoice', 'id', 'invoiceItems'));
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
        @ini_set('max_execution_time', 0);
        @set_time_limit(0);
//        print_r($request->all());die;

        $validator = Validator::make($request->all(), [
            'student_id' => 'required',
            'class_id' => 'required',
            'section_id' => 'required',
            'due_date' => 'required',
            'title' => 'required|max:191',
            'total' => 'required|numeric',
            'status' => 'required'
        ]);

        if ($validator->fails()) {
            if ($request->ajax()) {
                return response()->json(['result' => 'error', 'message' => $validator->errors()->all()]);
            } else {
                return redirect()->route('invoices.edit', $id)
                    ->withErrors($validator)
                    ->withInput();
            }
        }


        $invoice = DB::transaction(function() use ($id,$request){
            $invoice = Invoice::find($id);
            $invoice->student_id = $request->input('student_id');
            $invoice->class_id = $request->input('class_id');
            $invoice->section_id = $request->input('section_id');
            $invoice->due_date = $request->input('due_date');
            $invoice->title = $request->input('title');
            $invoice->description = $request->input('description');
            $invoice->total = $request->input('total');
            $invoice->status = $request->input('status');

            $invoice->save();

            //Remove All Items
            $invoiceItem = InvoiceItem::where("invoice_id", $id);
            $studentAccounts = StudentAccount::where('invoice_id',$id)->delete();
            $invoiceItem->delete();

            //Store Invoice Item
            $counter = 0;
            foreach ($request->input("fee_type") as $fee_id) {
                if ($request->input("amount")[$counter] == 0) {
                    continue;
                }
                $invoiceItem = new InvoiceItem();
                $invoiceItem->invoice_id = $invoice->id;
                $invoiceItem->fee_id = $fee_id;
                $invoiceItem->amount = $request->input("amount")[$counter];
                $invoiceItem->discount = $request->input("discount")[$counter];
                $invoiceItem->save();
                $account = StudentAccount::create([
                    'student_id' => $request->input('student_id'),
                    'invoice_id' => $invoice->id,
                    'invoice_item_id' => $invoiceItem->id,
                    'fee_id' => $fee_id,
                    'class_id' => $request->input('class_id'),
                    'transaction_type' => 'CREDIT',
                    'amount' => $invoiceItem->amount,
                    'date' => Carbon::now()
                ]);
                $counter++;
            }

            return $invoice;
        });
        if (!$request->ajax()) {
            return redirect('invoices')->with('success', _lang('Invoice updated sucessfully'));
        } else {
            return response()->json(['result' => 'success', 'action' => 'update', 'message' => _lang('Invoice updated sucessfully'), 'data' => $invoice]);
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
        DB::transaction(function ()use($id){
            $studentAccounts = StudentAccount::where('invoice_id',$id)->delete();
            $studentPayments = StudentPayment::where('invoice_id',$id)->delete();
            $invoiceItem = InvoiceItem::where("invoice_id", $id);
            $invoiceItem->delete();
            //delete invoice payments
            $invoice = Invoice::find($id);
            $invoice->delete();
        });


        return redirect('invoices')->with('success', _lang('Invoice Removed sucessfully'));
    }
}
