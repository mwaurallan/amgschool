<ul class="nav metismenu" id="menu">
	<li @if(Request::is('dashboard')) class="active" @endif>
		<a href="{{route('dashboard')}}">
			<i class="fa fa-desktop"></i>
			{{ _lang('Dashboard') }}
		</a>
	</li>

	<li>
		<a href="#"><i class="fa fa-user-o"></i>{{ _lang('Profile') }}</a>
			<ul>
				<li>
					<a href="{{ url('profile/my_profile')}}">
					{{ _lang('Profile') }}
					</a>
				</li>
				<li>
					<a href="{{ url('profile/edit')}}">
					{{ _lang('Update Profile') }}
					</a>
				</li>
				<li>
					<a href="{{ url('profile/changepassword') }}">
					{{ _lang('Change Password') }}
					</a>
				</li>
				<li>
					<a class="dropdown-item" href="{{ route('logout') }}"
					onclick="event.preventDefault();
					document.getElementById('logout-form2').submit();">
					{{ __('Logout') }}
				</a>
			</li>
			<form id="logout-form2" action="{{ route('logout') }}" method="POST" style="display: none;">
				@csrf
			</form>
		</ul>
	</li>

	<li>
		<a href="#"><i class="fa fa-address-card"></i>{{ _lang('Students') }}</a>
		<ul>
		   <li @if((Request::is('students'))OR(Request::is('students/create'))OR(Request::is('students/edit'))) class="active" @endif>
				<a href="{{ route('students.index') }}">
					Student List
				</a>
			</li>
			<li @if(Request::is('students/promote')) class="active" @endif>
				<a href="{{ url('students/promote') }}">
					{{ _lang('Promote Students') }}
				</a>
			</li>
		</ul>
	 </li>

	<li @if((Request::is('parents'))OR(Request::is('parents/*'))) class="active" @endif>
		<a href="{{route('parents.index')}}">
			<i class="fa fa-user-circle-o"></i>
			{{ _lang('Parents') }}
		</a>
	</li>

	<li @if((Request::is('teachers'))OR(Request::is('teachers/*'))) class="active" @endif>
		<a href="{{route('teachers.index')}}">
			<i class="fa fa-address-book"></i>
			{{ _lang('Teachers') }}
		</a>
	</li>

	<li>
		<a href="#"><i class="fa fa-building-o"></i>{{ _lang('Academic') }}</a>
		<ul>
		   <li @if((Request::is('class'))OR(Request::is('class/*'))) class="active" @endif>
				<a href="{{route('class.index')}}">
					{{ _lang('Class') }}
				</a>
			</li>
			<li @if((Request::is('sections'))OR(Request::is('sections/*'))) class="active" @endif>
				<a href="{{route('sections.index')}}">
					{{ _lang('Sections') }}
				</a>
			</li>
			<li @if((Request::is('subjects'))OR(Request::is('subjects/*'))) class="active" @endif>
				<a href="{{route('subjects.index')}}">
					{{ _lang('Subjects') }}
				</a>
			</li>
			<li @if((Request::is('assignsubjects'))OR(Request::is('assignsubjects/*'))) class="active" @endif>
				<a href="{{route('assignsubjects.index')}}">
					{{ _lang('Assign Subjects') }}
				</a>
			</li>
			<li @if((Request::is('syllabus'))OR(Request::is('syllabus/*'))) class="active" @endif>
				<a href="{{route('syllabus.index')}}">
					{{ _lang('Syllabus') }}
				</a>
			</li>
			<li @if((Request::is('assignments'))OR(Request::is('assignments/*'))) class="active" @endif>
				<a href="{{route('assignments.index')}}">
					{{ _lang('Assignments') }}
				</a>
			</li>
			<li @if((Request::is('class_routines'))) class="active" @endif>
				<a href="{{url('class_routines')}}">
					{{ _lang('Class Routine') }}
				</a>
			</li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-calendar-check-o"></i>Attendance</a>
		<ul>
		   <li @if((Request::is('student'))OR(Request::is('student/*'))) class="active" @endif>
				<a href="{{url('student/attendance')}}">
					{{ _lang('Student Attendance') }}
				</a>
			</li>
			<li @if((Request::is('staff'))OR(Request::is('staff/*'))) class="active" @endif>
				<a href="{{url('staff/attendance')}}">
					{{ _lang('Staff Attendance') }}
				</a>
			</li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-university"></i>{{ _lang('Bank / Cash Account') }}</a>
		<ul>
		   <li @if(Request::is('accounts')) class="active" @endif>
				<a href="{{url('accounts')}}">
					{{ _lang('Accounts') }}
				</a>
			</li>
			<li @if(Request::is('accounts/create')) class="active" @endif>
				<a href="{{url('accounts/create')}}">
					{{ _lang('Add New') }}
				</a>
			</li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-money"></i>{{ _lang('Transaction') }}</a>
		<ul>
		   <li @if(Request::is('transactions/income')) class="active" @endif>
				<a href="{{ url('transactions/income') }}">
					{{ _lang('Income') }}
				</a>
		   </li>
		   <li @if(Request::is('transactions/expense')) class="active" @endif>
				<a href="{{ url('transactions/expense') }}">
					{{ _lang('Expense') }}
				</a>
		   </li>
		   <li @if(Request::is('chart_of_accounts')) class="active" @endif>
				<a href="{{url('chart_of_accounts')}}">
					{{ _lang('Chart Of Accounts') }}
				</a>
		   </li>
		   <li @if(Request::is('payment_methods')) class="active" @endif>
				<a href="{{url('payment_methods')}}">
					{{ _lang('Payment Methods') }}
				</a>
		   </li>
		   <li @if(Request::is('payee_payers')) class="active" @endif>
				<a href="{{url('payee_payers')}}">
					{{ _lang('Payee & Payers') }}
				</a>
		   </li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-credit-card"></i>{{ _lang('Student Fees') }}</a>
		<ul>
		   <li @if(Request::is('fee_types')) class="active" @endif>
				<a href="{{url('fee_types')}}">
					{{ _lang('Fees Type') }}
				</a>
		   </li>
		   <li @if(Request::is('structure') OR(Request::is('structure/*'))) class="active" @endif>
				<a href="{{url('structure')}}">
					Fee Structures
				</a>
		   </li>

		   <li @if(Request::is('invoices/create')) class="active" @endif>
				<a href="{{url('invoices/create')}}">
					{{ _lang('Generate Invoice') }}
				</a>
		   </li>

		   <li @if(Request::is('invoices')) class="active" @endif>
				<a href="{{url('invoices')}}">
					{{ _lang('Student Invoices') }}
				</a>
		   </li>
		   <li @if(Request::is('student_payments')) class="active" @endif>
				<a href="{{url('student_payments')}}">
					{{ _lang('Payment History') }}
				</a>
		   </li>

		</ul>
	 </li>

    <li>
        <a href="#"><i class="fa fa-bar-chart"></i>{{ _lang('Reports') }}</a>
        <ul>
            <li @if(Request::is('reports/studentStatement') || Request::is('reports/studentStatement')) class="active" @endif>
                <a href="{{ url('reports/studentStatement') }}">
                    Student Statement
                </a>
            </li>
            <li @if(Request::is('reports/studentAccounts') || Request::is('reports/studentAccounts')) class="active" @endif>
                <a href="{{ url('reports/studentAccounts') }}">
                    Student Balances
                </a>
            </li>
            <li @if(Request::is('reports/studentBills') || Request::is('reports/studentBills')) class="active" @endif>
                <a href="{{ url('reports/studentBills') }}">
                    Student Bills
                </a>
            </li>
            <li @if(Request::is('reports/student_attendance_report') || Request::is('reports/student_attendance_report/view')) class="active" @endif>
                <a href="{{ url('reports/student_attendance_report') }}">
                    {{ _lang('Student Attendance') }}
                </a>
            </li>
            <li @if(Request::is('reports/staff_attendance_report') || Request::is('reports/staff_attendance_report/view')) class="active" @endif>
                <a href="{{ url('reports/staff_attendance_report') }}">
                    {{ _lang('Staff Attendance') }}
                </a>
            </li>
            <li @if(Request::is('reports/student_id_card') || Request::is('reports/student_id_card/view')) class="active" @endif>
                <a href="{{ url('reports/student_id_card') }}">
                    {{ _lang('Student ID Card') }}
                </a>
            </li>
            <li @if(Request::is('reports/exam_report') || Request::is('reports/exam_report/view')) class="active" @endif>
                <a href="{{ url('reports/exam_report') }}">
                    {{ _lang('Exam Report') }}
                </a>
            </li>
            <li @if(Request::is('reports/progress_card') || Request::is('reports/progress_card/view')) class="active" @endif>
                <a href="{{ url('reports/progress_card') }}">
                    {{ _lang('Progress Card') }}
                </a>
            </li>
            <li @if(Request::is('reports/class_routine') || Request::is('reports/class_routine/view')) class="active" @endif>
                <a href="{{ url('reports/class_routine') }}">
                    {{ _lang('Class Routine') }}
                </a>
            </li>
            <li @if(Request::is('reports/exam_routine') || Request::is('reports/exam_routine/view')) class="active" @endif>
                <a href="{{ url('reports/exam_routine') }}">
                    {{ _lang('Exam Routine') }}
                </a>
            </li>
            <li @if(Request::is('reports/income_report') || Request::is('reports/income_report/view')) class="active" @endif>
                <a href="{{ url('reports/income_report') }}">
                    {{ _lang('Income Report') }}
                </a>
            </li>
            <li @if(Request::is('reports/expense_report') || Request::is('reports/expense_report/view')) class="active" @endif>
                <a href="{{ url('reports/expense_report') }}">
                    {{ _lang('Expense Report') }}
                </a>
            </li>
            <li @if(Request::is('reports/account_balance')) class="active" @endif>
                <a href="{{ url('reports/account_balance') }}">
                    {{ _lang('Financial Account Balance') }}
                </a>
            </li>
        </ul>
    </li>

	 <li>
		<a href="#"><i class="fa fa-book"></i>{{ _lang('Library') }}</a>
		<ul>
		   <li @if((Request::is('librarymembers'))OR(Request::is('librarymembers/*'))) class="active" @endif>
				<a href="{{url('librarymembers')}}">
					{{ _lang('Members') }}
				</a>
			</li>
			<li @if((Request::is('books'))OR(Request::is('books/*'))) class="active" @endif>
				<a href="{{url('books')}}">
					{{ _lang('Books') }}
				</a>
			</li>
			<li @if((Request::is('bookcategories'))OR(Request::is('bookcategories/*'))) class="active" @endif>
				<a href="{{url('bookcategories')}}">
					{{ _lang('Book Categories') }}
				</a>
			</li>
			<li @if((Request::is('bookissues'))OR(Request::is('bookissues/list'))OR(Request::is('bookissues/list/*'))OR(Request::is('bookissues/*/edit'))) class="active" @endif>
				<a href="{{url('bookissues')}}">
					{{ _lang('Issues') }}
				</a>
			</li>
			<li @if((Request::is('bookissues/create'))) class="active" @endif>
				<a href="{{url('bookissues/create')}}">
					{{ _lang('Add Issues') }}
				</a>
			</li>
		</ul>
	 </li>
	 <li>
		<a href="#"><i class="fa fa-car"></i>{{ _lang('Transport') }}</a>
		<ul>
		   <li @if((Request::is('transportvehicles'))OR(Request::is('transportvehicles/*'))) class="active" @endif>
				<a href="{{url('transportvehicles')}}">
					{{ _lang('Vehicles') }}
				</a>
			</li>
			<li @if((Request::is('transports'))OR(Request::is('transports/*'))) class="active" @endif>
				<a href="{{url('transports')}}">
					{{ _lang('Transports') }}
				</a>
			</li>
			<li @if((Request::is('transportmembers'))OR(Request::is('transportmembers/*'))) class="active" @endif>
				<a href="{{url('transportmembers')}}">
					{{ _lang('Members') }}
				</a>
			</li>
		</ul>
	 </li>
	 <li>
		<a href="#"><i class="fa fa-building-o"></i>{{ _lang('Hostel') }}</a>
		<ul>
		   <li @if((Request::is('hostels'))OR(Request::is('hostels/*'))) class="active" @endif>
				<a href="{{url('hostels')}}">
					{{ _lang('Hostel') }}
				</a>
			</li>
			<li @if((Request::is('hostelcategories'))OR(Request::is('hostelcategories/*'))) class="active" @endif>
				<a href="{{url('hostelcategories')}}">
					{{ _lang('Categories') }}
				</a>
			</li>
			<li @if((Request::is('hostelmembers'))OR(Request::is('hostelmembers/*'))) class="active" @endif>
				<a href="{{url('hostelmembers')}}">
					{{ _lang('Members') }}
				</a>
			</li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Examinations') }}</a>
		<ul>
		   <li @if(Request::is('exams')) class="active" @endif>
				<a href="{{url('exams')}}">
					{{ _lang('Exam List') }}
				</a>
		   </li>

		   <li @if(Request::is('exams/schedule/create')) class="active" @endif>
				<a href="{{url('exams/schedule/create')}}">
					{{ _lang('Exam Schedule') }}
				</a>
		   </li>

		   <li @if(Request::is('exams/schedule')) class="active" @endif>
				<a href="{{url('exams/schedule')}}">
					{{ _lang('Exam Routine') }}
				</a>
		   </li>

			<li @if(Request::is('exams/attendance')) class="active" @endif>
				<a href="{{url('exams/attendance')}}">
					{{ _lang('Exam Attendance') }}
				</a>
		   </li>

		</ul>
	 </li>


	 <li>
		<a href="#"><i class="fa fa-balance-scale"></i>{{ _lang('Marks') }}</a>
		<ul>
		   <li @if(Request::is('marks')) class="active" @endif>
				<a href="{{ url('marks') }}">
					{{ _lang('Marks') }}
				</a>
		   </li>

		   <li @if(Request::is('marks/rank')) class="active" @endif>
				<a href="{{ url('marks/rank') }}">
					{{ _lang('Student Rank') }}
				</a>
		   </li>

		   <li @if(Request::is('marks/create')) class="active" @endif>
				<a href="{{ url('marks/create') }}">
					{{ _lang('Mark Register') }}
				</a>
		   </li>

		   <li @if(Request::is('grades')) class="active" @endif>
				<a href="{{ url('grades') }}">
					{{ _lang('Grade Setup') }}
				</a>
		   </li>

		   <li @if(Request::is('mark_distributions')) class="active" @endif>
				<a href="{{ url('mark_distributions') }}">
					{{ _lang('Mark Distribution') }}
				</a>
		   </li>

		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-envelope-open"></i>{{ _lang('Message') }} {!! count_inbox() > 0 ? '<span class="label label-danger inbox-count">'.count_inbox().'</span>' : '' !!}</a>
		<ul>
		   <li @if(Request::is('message/compose')) class="active" @endif>
				<a href="{{ url('message/compose') }}">
					{{ _lang('New Message') }}
				</a>
		   </li>
		   <li @if(Request::is('message/inbox')) class="active" @endif>
				<a href="{{ url('message/inbox') }}">
					{{ _lang('Inbox Items') }}
				</a>
		   </li>
		   <li @if(Request::is('message/outbox')) class="active" @endif>
				<a href="{{ url('message/outbox') }}">
					{{ _lang('Send Items') }}
				</a>
		   </li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Notice') }}</a>
		<ul>
		   <li @if(Request::is('notices')) class="active" @endif>
				<a href="{{ route('notices.index') }}">
					{{ _lang('All Notice') }}
				</a>
		   </li>
		   <li @if(Request::is('notices/create')) class="active" @endif>
				<a href="{{ route('notices.create') }}">
					{{ _lang('New Notice') }}
				</a>
		   </li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-calendar"></i>{{ _lang('Events') }}</a>
		<ul>
		   <li @if(Request::is('events')) class="active" @endif>
				<a href="{{ route('events.index') }}">
					{{ _lang('All Events') }}
				</a>
		   </li>
		   <li @if(Request::is('events/create')) class="active" @endif>
				<a href="{{ route('events.create') }}">
					{{ _lang('Add New Event') }}
				</a>
		   </li>
		</ul>
	 </li>

	  <li>
		<a href="#"><i class="fa fa-envelope-o"></i>{{ _lang('Email & SMS') }}</a>
		<ul>
		   <li @if(Request::is('email/compose')) class="active" @endif>
				<a href="{{ url('email/compose') }}">
					{{ _lang('Send Email') }}
				</a>
		   </li>
		   <li @if(Request::is('email/logs')) class="active" @endif>
				<a href="{{ url('email/logs') }}">
					{{ _lang('Email Log') }}
				</a>
		   </li>
		   <li @if(Request::is('sms/compose')) class="active" @endif>
				<a href="{{ url('sms/compose') }}">
					{{ _lang('Send SMS') }}
				</a>
		   </li>
		   <li @if(Request::is('sms/logs')) class="active" @endif>
				<a href="{{ url('sms/logs') }}">
					{{ _lang('SMS Log') }}
				</a>
		   </li>
		</ul>
	 </li>




	 <li @if((Request::is('users'))OR(Request::is('users/*'))) class="active" @endif>
			<a href="{{route('users.index')}}">
			<i class="fa fa-users"></i>
				{{ _lang('User Management') }}
			</a>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-cogs"></i>{{ _lang('Administration') }}</a>
		<ul>
		   <li @if((Request::is('administration/general_settings'))) class="active" @endif>
				<a href="{{ url('administration/general_settings') }}">
					{{ _lang('System Settings') }}
				</a>
		   </li>

		   <li @if((Request::is('academic_years'))OR(Request::is('academic_years/*'))) class="active" @endif>
				<a href="{{route('academic_years.index')}}">
					{{ _lang('Adademic Session') }}
				</a>
		   </li>
		   <li @if((Request::is('student_groups'))OR(Request::is('student_groups/*'))) class="active" @endif>
				<a href="{{route('student_groups.index')}}">
					{{ _lang('Student Group') }}
				</a>
		   </li>
		   <li @if((Request::is('picklists'))) class="active" @endif>
				<a href="{{route('picklists.index')}}">
					{{ _lang('Picklist Editor') }}
				</a>
		   </li>
		   <li @if((Request::is('permission_roles'))OR(Request::is('permission_roles/*'))) class="active" @endif>
				<a href="{{route('permission_roles.index')}}">
					{{ _lang('User Role') }}
				</a>
		   </li>
		   <li @if((Request::is('permission/control'))) class="active" @endif>
				<a href="{{url('permission/control')}}">
					{{ _lang('Permission Control') }}
				</a>
		   </li>
		   <li @if((Request::is('administration/backup_database'))) class="active" @endif>
				<a href="{{url('administration/backup_database')}}">
					{{ _lang('Database Backup') }}
				</a>
		   </li>
		   <li @if(Request::is('languages') || Request::is('languages.*')) class="active" @endif>
				<a href="{{ route('languages.index') }}">
					{{ _lang('Languages') }}
				</a>
		   </li>
		</ul>
	 </li>

	 <li>
		<a href="#"><i class="fa fa-newspaper-o"></i>{{ _lang('Website CMS') }}</a>
		<ul>
		   <li @if(Request::is('posts') || Request::is('posts/*')) class="active" @endif>
				<a href="{{ route('posts.index') }}">
					{{ _lang('Posts') }}
				</a>
		   </li>
		   <li @if(Request::is('post_categories') || Request::is('post_categories/*')) class="active" @endif>
				<a href="{{ route('post_categories.index') }}">
					{{ _lang('Post Category') }}
				</a>
		   </li>
		   <li @if(Request::is('pages') || Request::is('pages/*')) class="active" @endif>
				<a href="{{ route('pages.index') }}">
					{{ _lang('Pages') }}
				</a>
		   </li>

		   <li @if(Request::is('site_navigations') || Request::is('site_navigations/*')) class="active" @endif>
				<a href="{{ route('site_navigations.index') }}">
					{{ _lang('Site Menu') }}
				</a>
		   </li>

		   <li @if(Request::is('website/theme_option')) class="active" @endif>
				<a href="{{ url('website/theme_option') }}">
					{{ _lang('Theme Option') }}
				</a>
		   </li>

		</ul>
	 </li>

</ul>
