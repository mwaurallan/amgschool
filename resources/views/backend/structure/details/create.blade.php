@extends('layouts.backend')

@section('content')
<div class="row">
    <div class="col-md-12">
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Class Fee Structure</div>
                <div class="panel-body">
                    <form method="post" class="validate" autocomplete="off" action="{{url('saveStructureDetails')}}" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="col-md-12">

                            <div class="form-group">
                                <label class="control-label">Fee Type</label>
                                <select name="fee_type_id" required class="form-control select2">
                                    <option value="">Select Fee Type</option>
                                    @if(count($feeTypes))
                                        @foreach($feeTypes as $type)
                                            <option value="{{ $type->id }}">{{$type->fee_type}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="form-group">
                                <label>Amount</label>
                                <input type="number" class="form-control" name="amount" required>
                                <input type="hidden" name="structure_id" value="{{ $structure_id }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-12">

                                <br>
                                <br>
                                <br>
                                <button type="reset" class="btn btn-danger">{{ _lang('Reset') }}</button>
                                <button type="submit" class="btn btn-primary">{{ _lang('Save') }}</button>
                            </div>
                        </div>
                    </form>


                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading">Fee Structure for class <h2>{{ $class  }}</h2></div>
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
                            <th>Fee Type</th>
                            <th class="text-right">Amount</th>
                            <th>{{ _lang('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($details))
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{ $detail->type->fee_type }}</td>
                                        <td class="text-right">{{ number_format($detail->amount) }}</td>
                                        <td>
                                            <form action="{{ url('deleteItem/'.$detail->id)  }}" method="post">
                                                {{ csrf_field() }}
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button class="btn btn-danger btn-sm btn-remove" type="submit">{{ _lang('Delete') }}</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                                @endif
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>Total</th>
                            <th class="text-right">{{ number_format($details->sum('amount')) }}</th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


