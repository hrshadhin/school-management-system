
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <section class="sidebar">
        <!-- sidebar menu -->
        <ul class="sidebar-menu" data-widget="tree">
            <li>
                <a href="{{ URL::route('user.dashboard') }}">
                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                </a>
            </li>
            @role('Student')
                <li>
                    <a href="{{ URL::route('public.student_profile') }}">
                        <i class="fa icon-academicmain"></i> <span>Academic</span>
                    </a>
                </li>
            @endrole
            @can('student.index')
                <li>
                    <a href="{{ URL::route('student.index') }}">
                        <i class="fa icon-student"></i> <span>Students</span>
                    </a>
                </li>
            @endcan
            @can('teacher.index')
                <li>
                    <a href="{{ URL::route('teacher.index') }}">
                        <i class="fa icon-teacher"></i> <span>Teachers</span>
                    </a>
                </li>
            @endcan
            @canany(['student_attendance.index', 'employee_attendance.index'])
            <li class="treeview">
                <a href="#">
                    <i class="fa icon-attendance"></i>
                    <span>Attendance</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li>
                        <a href="{{ URL::route('student_attendance.index') }}">
                            <i class="fa icon-student"></i> <span>Student Attendance</span>
                        </a>
                    </li>
                    @can('employee_attendance.index')
                    <li>
                        <a href="{{ URL::route('employee_attendance.index') }}">
                            <i class="fa icon-member"></i> <span>Employee Attendance</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['academic.class', 'academic.section', 'academic.subject'])
            <li class="treeview">
                <a href="#">
                    <i class="fa icon-academicmain"></i>
                    <span>Academic</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    @can('academic.class')
                        <li>
                            <a href="{{ URL::route('academic.class') }}">
                                <i class="fa fa-sitemap"></i> <span>Class</span>
                            </a>
                        </li>
                    @endcan
                    @can('academic.section')
                        <li>
                            <a href="{{ URL::route('academic.section') }}">
                                <i class="fa fa-cubes"></i> <span>Section</span>
                            </a>
                        </li>
                    @endcan
                    @can('academic.subject')
                        <li>
                            <a href="{{ URL::route('academic.subject') }}">
                                <i class="fa icon-subject"></i> <span>Subject</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['exam.index', 'exam.grade.index', 'exam.rule.index'])
            <li class="treeview">
                <a href="#"> <i class="fa icon-exam"></i>
                    <span>Exam</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('exam.rule.index')
                        <li>
                            <a href="{{ URL::route('exam.rule.index') }}">
                                <i class="fa fa-cog"></i> <span>Rule</span>
                            </a>
                        </li>
                    @endcan
                    @can('exam.index')
                        <li>
                            <a href="{{ URL::route('exam.index') }}">
                                <i class="fa icon-exam"></i> <span>Exam</span>
                            </a>
                        </li>
                    @endcan
                    @can('exam.grade.index')
                        <li>
                            <a href="{{ URL::route('exam.grade.index') }}">
                                <i class="fa fa-bar-chart"></i> <span>Grade</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @canany(['marks.index', 'result.index'])
            <li class="treeview">
                <a href="#"> <i class="fa icon-markmain"></i>
                    <span>Marks & Result</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('marks.index')
                        <li>
                            <a href="{{ URL::route('marks.index') }}">
                                <i class="fa icon-markmain"></i> <span>Marks</span>
                            </a>
                        </li>
                    @endcan
                    @can('result.index')
                        <li>
                            <a href="{{ URL::route('result.index') }}">
                                <i class="fa icon-markpercentage"></i> <span>Result</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can(['promotion.create'])
            <li>
                <a href="{{ URL::route('promotion.create') }}"> <i class="fa icon-promotion"></i>
                    <span>Promotion</span>
                </a>
            </li>
            @endcan


        @canany(['hrm.employee.index', 'hrm.leave.index', 'hrm.work_outside.index', 'hrm.policy'])
            <li class="treeview">
                <a href="#"><i class="fa fa-users"></i>
                    <span>HRM</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                    @can('hrm.employee.index')
                        <li>
                            <a href="{{ URL::route('hrm.employee.index') }}">
                                <i class="fa icon-member"></i> <span>Employee</span>
                            </a>
                        </li>
                    @endcan
                    @can('hrm.leave.index')
                        <li>
                            <a href="{{ URL::route('hrm.leave.index') }}">
                                <i class="fa fa-bed"></i> <span>Leave</span>
                            </a>
                        </li>
                    @endcan
                    @can('hrm.policy')
                        <li>
                            <a href="{{ URL::route('hrm.policy') }}">
                                <i class="fa fa-cogs"></i> <span>Policy</span>
                            </a>
                        </li>
                    @endcan
                </ul>
            </li>
            @endcanany

            @can('user.index')
                <li>
                    <a href="{{ URL::route('user.index') }}">
                        <i class="fa fa-users"></i> <span>Users</span>
                    </a>
                </li>
            @endcan

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-file-pdf-o"></i>
                    <span>Reports</span>
                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>

                <ul class="treeview-menu">
                    @notrole('Student')
                    <li class="treeview">
                        <a href="#">
                            <i class="fa icon-studentreport"></i>
                            <span>Student</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @can('report.student_monthly_attendance')
                                <li>
                                    <a href="{{ URL::route('report.student_monthly_attendance') }}">
                                        <i class="fa icon-attendancereport"></i> <span>Monthly Attendance</span>
                                    </a>
                                </li>
                            @endcan

                            @can('report.student_list')
                                <li>
                                    <a href="{{route('report.student_list')}}">
                                        <i class="fa icon-student"></i> <span>Student List</span>
                                    </a>
                                </li>
                            @endcan
                        </ul>
                    </li>
                    <li class="treeview">
                        <a href="#">
                            <i class="fa fa-users"></i>
                            <span>HRM</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            @can('report.employee_monthly_attendance')
                                <li>
                                    <a href="{{ URL::route('report.employee_monthly_attendance') }}"><i class="fa icon-attendancereport"></i> <span>Monthly Attendance</span></a>
                                </li>
                            @endcan

                            @can('report.employee_list')
                                <li>
                                    <a href="{{route('report.employee_list')}}"><i class="fa icon-attendance"></i> <span>Employee List</span></a>
                                </li>
                            @endcan

                        </ul>
                    </li>

                    <li class="treeview">
                        <a href="#">
                            <i class="fa icon-mark2"></i>
                            <span>Marks & Result</span>
                            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                        </a>
                        <ul class="treeview-menu">
                            <li>
                                <a href="{{route('report.marksheet_pub')}}"><i class="fa fa-file-pdf-o"></i><span>Marksheet Public</span></a>
                            </li>
                        </ul>
                    </li>

                    @canany(['student_attendance.index', 'employee_attendance.index'])
                        <li>
                            <a href="{{route('app_log')}}">
                                <i class="fa fa-list"></i> <span>Application Log</span>
                            </a>
                        </li>
                    @endcanany
                @endnotrole
                @role('Student')
                    <li>
                        <a href="{{route('report.marksheet_pub')}}"><i class="fa fa-file-pdf-o"></i><span>Marksheet Public</span></a>
                    </li>
                @endrole
                </ul>

            </li>

            <!-- Frontend Website links and settings -->
            @notrole('Student')
            @if($frontend_website)
                <li class="treeview">
                    <a href="#"><i class="fa fa-globe"></i>
                        <span>Site</span>
                        <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                    </a>
                    <ul class="treeview-menu">
                        @can('site.dashboard')
                            <li>
                                <a href="{{ URL::route('site.dashboard') }}">
                                    <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                                </a>
                            </li>
                        @endcan
                        @canany(['site.index', 'site.about_content', 'site.service', 'site.statistic', 'site.testimonial', 'site.subscribe'])
                            <li class="treeview">
                                <a href="#"><i class="fa fa-home"></i>
                                    <span>Home</span>
                                    <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                                </a>
                                <ul class="treeview-menu">
                                    @can('slider.index')
                                        <li><a href="{{URL::route('slider.index')}}"><i class="fa fa-picture-o text-aqua"></i> Sliders</a></li>
                                    @endcan
                                    @can('site.about_content')
                                        <li><a href="{{URL::route('site.about_content')}}"><i class="fa fa-info text-aqua"></i> About Us</a></li>
                                    @endcan
                                    @can('site.service')
                                        <li><a href="{{ URL::route('site.service') }}"><i class="fa fa-file-text text-aqua"></i> Our Services</a></li>
                                    @endcan
                                    @can('site.statistic')
                                        <li><a href="{{ URL::route('site.statistic') }}"><i class="fa fa-bars"></i> Statistic</a></li>
                                    @endcan
                                    @can('site.testimonial')
                                        <li><a href="{{ URL::route('site.testimonial') }}"><i class="fa fa-comments"></i> Testimonials</a></li>
                                    @endcan
                                    @can('site.subscribe')
                                        <li><a href="{{ URL::route('site.subscribe') }}"><i class="fa fa-users"></i> Subscribers</a></li>
                                    @endcan
                                </ul>
                            </li>
                        @endcanany
                        @can('class_profile.index')
                            <li>
                                <a href="{{ URL::route('class_profile.index') }}">
                                    <i class="fa fa-building"></i>
                                    <span>Class</span>
                                </a>
                            </li>
                        @endcan
                        @can('teacher_profile.index')
                            <li>
                                <a href="{{ URL::route('teacher_profile.index') }}">
                                    <i class="fa icon-teacher"></i>
                                    <span>Teachers</span>
                                </a>
                            </li>
                        @endcan
                        @can('event.index')
                            <li>
                                <a href="{{ URL::route('event.index') }}">
                                    <i class="fa fa-bullhorn"></i>
                                    <span>Events</span>
                                </a>
                            </li>
                        @endcan
                        @can('site.gallery')
                            <li>
                                <a href="{{ URL::route('site.gallery') }}">
                                    <i class="fa fa-camera"></i>
                                    <span>Gallery</span>
                                </a>
                            </li>
                        @endcan
                        @can('site.contact_us')
                            <li>
                                <a href="{{ URL::route('site.contact_us') }}">
                                    <i class="fa fa-map-marker"></i>
                                    <span>Contact Us</span>
                                </a>
                            </li>
                        @endcan
                        @can('site.faq')
                            <li>
                                <a href="{{ URL::route('site.faq') }}">
                                    <i class="fa fa-question-circle"></i>
                                    <span>FAQ</span>
                                </a>

                            </li>
                        @endcan
                        @can('site.timeline')
                            <li>
                                <a href="{{ URL::route('site.timeline') }}"><i class="fa fa-clock-o"></i>
                                    <span>Timeline</span>
                                </a>
                            </li>
                        @endcan
                        @can('site.settings')
                            <li>
                                <a href="{{ URL::route('site.settings') }}"><i class="fa fa-cogs"></i>
                                    <span>Settings</span>
                                </a>
                            </li>
                        @endcan
                        @can('site.analytics')
                            <li>
                                <a href="{{ URL::route('site.analytics') }}"><i class="fa fa-line-chart"></i>
                                    <span>Analytics</span>
                                </a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endif
            @endnotrole

            @role('Admin')
            <li class="treeview">
                <a href="#"><i class="fa fa-user-secret"></i>
                    <span>Administrator</span><span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
                </a>
                <ul class="treeview-menu">
                   @can('settings.institute')
                        <li>
                            <a href="{{ URL::route('settings.institute') }}">
                                <i class="fa fa-building"></i> <span>Institute Settings</span>
                            </a>
                        </li>
                   @endcan
                   @can('administrator.academic_year')
                        <li>
                            <a href="{{ URL::route('administrator.academic_year') }}">
                                <i class="fa fa-calendar-plus-o"></i> <span>Academic Year</span>
                            </a>
                        </li>
                   @endcan
                   @can('settings.report')
                       <li>
                           <a href="{{ URL::route('settings.report') }}">
                               <i class="fa fa-file-pdf-o"></i> <span>Report Settings</span>
                           </a>
                       </li>
                   @endcan
                   @can('user.role_index')
                       <li>
                           <a href="{{URL::route('user.role_index')}}">
                               <i class="fa fa-users"></i> <span>User Role</span>
                           </a>
                       </li>
                   @endcan
                    @can('administrator.user_index')
                        <li>
                            <a href="{{URL::route('administrator.user_index')}}">
                                <i class="fa fa-user-md"></i> <span>System Admin</span>
                            </a>
                        </li>
                    @endcan
                    @can('administrator.user_password_reset')
                        <li>
                            <a href="{{route('administrator.user_password_reset')}}">
                                <i class="fa fa-eye-slash"></i> <span>Reset User Password</span>
                            </a>
                        </li>
                    @endcan

                    {{--<li>--}}
                    {{--<a href="#">--}}
                    {{--<i class="fa fa-download"></i> <span>Backup</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}

                    {{--<li>--}}
                    {{--<a href="#">--}}
                    {{--<i class="fa fa-upload"></i> <span>Restore</span>--}}
                    {{--</a>--}}
                    {{--</li>--}}

                </ul>
            </li>
            @endrole
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
