@extends('layouts.backend')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
				<span class="panel-title">
					{{_lang('Progress Card')}}
				</span>
                </div>
                <div class="panel-body">
                    <form id="search_form" class="params-panel validate"
                          action="{{ url('reports/progress_card/view') }}" method="post" autocomplete="off"
                          accept-charset="utf-8">
                        @csrf

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Class') }}</label>
                                <select name="class_id" class="form-control select2" onChange="getData(this.value);"
                                        required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    {{ create_option('classes','id','class_name',$class_id) }}
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Section') }}</label>
                                <select name="section_id" onchange="get_students();" class="form-control select2"
                                        required>
                                    <option value="">{{ _lang('Select One') }}</option>
                                    {{ create_option('sections','id','section_name',$section_id,array("class_id="=>$class_id)) }}
                                </select>
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <label class="control-label">{{ _lang('Select Student') }}</label>
                                <select name="student_id" id="student_id" class="form-control select2">
                                    <option value="">{{ _lang('Select One') }}</option>
                                </select>
                            </div>
                        </div>


                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" style="margin-top:24px;"
                                        class="btn btn-primary btn-block rect-btn">{{_lang('View Report')}}</button>
                            </div>
                        </div>
                    </form>


                    <!--Show Full Report Card-->
                    @if(!empty($exams))
                        <div class="panel panel-default" id="progress_card">
                            <div class="panel-heading">
                                <span class="panel-title">{{ _lang('Progress Card') }}</span>
                                <button type="button" data-print="progress_card"
                                        class="btn btn-primary btn-sm pull-right print"><i
                                        class="fa fa-print"></i> {{ _lang('Print Progress Card') }}</button>
                            </div>
                            <div class="panel-body">
                                <table class="table table-bordered">
                                    <tr>
                                        <td colspan="4" style="text-align:center;"><img width="100px"
                                                                                        style="border-radius: 8px; padding:5px; border:2px solid #ccc;"
                                                                                        src="{{ asset('public/uploads/images/profile.png') }}">
                                        </td>
                                        {{--									<td colspan="4" style="text-align:center;"><img width="100px" style="border-radius: 8px; padding:5px; border:2px solid #ccc;" src="{{ asset('public/uploads/images/'.$student->image) }}"></td>--}}
                                    </tr>
                                    <tr>
                                        <td><b>{{ _lang('School') }}</b></td>
                                        <td>{{ get_option('school_name') }}</td>
                                        <td><b>{{ _lang('Student Name') }}</b></td>
                                        <td>{{ $student->first_name." ".$student->last_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ _lang('Class') }}</b></td>
                                        <td>{{ $student->class_name }}</td>
                                        <td><b>{{ _lang('Section') }}</b></td>
                                        <td>{{ $student->section_name }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ _lang('Roll') }}</b></td>
                                        <td>{{ $student->roll }}</td>
                                        <td><b>{{ _lang('Reg No') }}</b></td>
                                        <td>{{ $student->register_no }}</td>
                                    </tr>
                                    <tr>
                                        <td><b>{{ _lang('Academic Year') }}</b></td>
                                        <td>{{ get_academic_year(get_option('academic_year')) }}</td>
                                        <td><b>{{ _lang('Group') }}</b></td>
                                        <td>{{ $student->group_name }}</td>
                                    </tr>
                                </table>
                                <div class="table-responsive">
                                    <table class="table table-bordered report-card">
                                        <thead>
                                        <tr>
                                            <th rowspan="2">{{ _lang('Subject') }}</th>
                                            @foreach($exams as $exam)
                                                <th colspan="{{ count($mark_head) }}"
                                                    style="background:#bdc3c7;text-align:center">
                                                    <b>{{ $exam->name }}</b></th>
                                            @endforeach
                                            <th rowspan="2">{{ _lang('Total') }}</th>
                                            <th rowspan="2">{{ _lang('Grade') }}</th>
                                            <th rowspan="2">{{ _lang('Point') }}</th>
                                        </tr>

                                        <tr>
                                            @foreach($exams as $exam)
                                                @foreach($mark_head as $mh)
                                                    <th style="background:#bdc3c7">{{ $mh->mark_type }}</th>
                                                @endforeach
                                            @endforeach
                                        </tr>
                                        </thead>
                                        <tbody>

                                        @php $total = 0; @endphp
                                        @php $total_subject = 0; @endphp

                                        @foreach($subjects as $subject)
                                            @php $row_total=0; @endphp
                                            @php $point=0; @endphp
                                            <tr>
                                                <td>{{ $subject->subject_name }}</td>
                                                @foreach($exams as $exam)
                                                    @if(array_key_exists($subject->id,$mark_details))
                                                    @foreach($mark_details[$subject->id][$exam->exam_id] as $md)
                                                        @php
                                                            $row_total = $row_total + $md->mark_value;
                                                            $point = get_point($row_total/count($exams));
                                                            $grade = get_grade($row_total/count($exams));
                                                        @endphp
                                                        <td style="text-align:center">{{ $md->mark_value }}</td>
                                                    @endforeach
                                                    @endif

                                                    @php $total_subject++  @endphp
                                                @endforeach
                                                <td>{{ $row_total }}</td>
                                                <td>{{ $grade }}</td>
                                                <td>{{ $point }}</td>
                                            </tr>
                                            @php $total = $total + $row_total; @endphp
                                        @endforeach
                                        <tr>
                                            <td colspan="100%" style="text-align:center">
                                                <h5>{!! _lang('Total Marks')." : <b>".$total."</b>" !!}</h5></td>
                                        </tr>

                                        <tr>
                                            <td colspan="100%" style="text-align:center">
                                                <h5>{!! _lang('Average Marks')." : <b>".($total/$total_subject)."</b>" !!}</h5>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="100%" style="text-align:center">
                                                <h5>{!! _lang('Point')." : <b>".get_point($total/$total_subject)."</b>" !!}</h5>
                                            </td>
                                        </tr>

                                        <tr>
                                            <td colspan="100%" style="text-align:center">
                                                <h5>{!! _lang('Grade')." : <b>".get_grade($total/$total_subject)."</b>" !!}</h5>
                                            </td>
                                        </tr>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js-script')
    <script type="text/javascript">
        function getData(val) {
            var _token = $('input[name=_token]').val();
            var class_id = $('select[name=class_id]').val();
            $.ajax({
                type: "POST",
                url: "{{url('sections/section')}}",
                data: {_token: _token, class_id: class_id},
                beforeSend: function () {
                    $("#preloader").css("display", "block");
                }, success: function (sections) {
                    $("#preloader").css("display", "none");
                    $('select[name=section_id]').html(sections);
                }
            });
        }

        function get_students() {

            var class_id = "/" + $('select[name=class_id]').val();
            var section_id = "/" + $('select[name=section_id]').val();
            var link = "{{ url('students/get_students') }}" + class_id + section_id;
            $.ajax({
                url: link,
                beforeSend: function () {
                    $("#preloader").css("display", "block");
                }, success: function (data) {
                    $("#preloader").css("display", "none");
                    var json = JSON.parse(data);
                    $('select[name=student_id]').html("");

                    jQuery.each(json, function (i, val) {
                        $('select[name=student_id]').append("<option value='" + val['id'] + "'>Roll " + val['roll'] + " - " + val['first_name'] + " " + val['last_name'] + "</option>");
                    });

                }
            });
        }

    </script>
@stop
