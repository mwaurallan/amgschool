<?php

namespace App\Http\Controllers;

use App\ClassModel;
use App\FeeStructure;
use App\FeeStructureDetail;
use App\FeeType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class FeeStructureController extends Controller
{
    public function index(){
        $structures= FeeStructure::with('c')->get();


        return view('backend.structure.list',compact('structures'));

    }

    public function create(){

        return view('backend.structure.create',[
            'classes' => ClassModel::all()
        ]);
    }

    public function store(Request $request){
        $this->validate($request,[
            'class_id' => 'required|unique:fee_structures,class_id'
        ]);

        $structure = FeeStructure::create([
            'class_id' => $request->class_id,
            'title' => ''
        ]);
        return redirect('structure')->with('success', _lang('Information has been added'));
    }

    public function createStructureDetails($id){
        $structure = FeeStructure::with('c')->first();
        $details = FeeStructureDetail::where('structure_id',$id)->with('type')->get();
        return view('backend.structure.details.create',[
            'details' => $details,
            'feeTypes' => FeeType::all(),
            'structure_id' => $id,
            'class' => $structure->c->class_name
        ]);
    }

    public function saveStructureDetails(Request $request){
        $this->validate($request,[
            'structure_id'=>'required',
            'amount'=>'required',
            'fee_type_id' => Rule::unique('fee_structure_details')->whereIn('structure_id',[$request->structure_id])
        ]);

        $st = FeeStructureDetail::create([
            'structure_id' => $request->structure_id,
            'amount' => $request->amount,
            'fee_type_id' => $request->fee_type_id
        ]);
        return redirect('structure/createStructureDetails/'.$request->structure_id)->with('success', _lang('Information has been added'));
    }

    public function deleteItem($id){
        $item = FeeStructureDetail::destroy($id);

        return redirect()->back()->with('success', _lang('Information has been deleted'));
    }
}
