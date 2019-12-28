
<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
  <section class="sidebar">
    <!-- sidebar menu -->
    <ul class="sidebar-menu" data-widget="tree">
      <li>
        <a href="{{ URL::route('user.dashboard') }}">
          <i class="fa fa-dashboard"></i> <span>@lang('menu.dashboard')</span>
        </a>
      </li>
      @can('student.index')
        <li>
          <a href="{{ URL::route('student.index') }}">
            <i class="fa icon-student"></i> <span>@lang('menu.students')</span>
          </a>
        </li>
      @endcan
      @can('teacher.index')
        <li>
          <a href="{{ URL::route('teacher.index') }}">
            <i class="fa icon-teacher"></i> <span>@lang('menu.teachers')</span>
          </a>
        </li>
      @endcan
      @canany(['student_attendance.index', 'employee_attendance.index'])
        <li class="treeview">
          <a href="#">
            <i class="fa icon-attendance"></i>
            <span>@lang('menu.attendance')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <li>
            <a href="{{ URL::route('student_attendance.index') }}">
              <i class="fa icon-student"></i> <span>@lang('menu.students_attendance')</span>
            </a>
          </li>
            <li>
            <a href="{{ URL::route('employee_attendance.index') }}">
              <i class="fa icon-member"></i> <span>@lang('menu.employees_attendance')</span>
            </a>
          </li>
          </ul>
          </li>
      @endcanany

      <li class="treeview">
        <a href="#">
          <i class="fa icon-academicmain"></i>
          <span>@lang('menu.academic')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          @notrole('Student')
          @can('academic.class')
            <li>
              <a href="{{ URL::route('academic.class') }}">
                <i class="fa fa-sitemap"></i> <span>@lang('menu.classes')</span>
              </a>
            </li>
          @endcan
          @can('academic.section')
            <li>
              <a href="{{ URL::route('academic.section') }}">
                <i class="fa fa-cubes"></i> <span>@lang('menu.sections')</span>
              </a>
            </li>
          @endcan
          @endnotrole

          @can('academic.subject')
            <li>
              <a href="{{ URL::route('academic.subject') }}">
                <i class="fa icon-subject"></i> <span>@lang('menu.subjects')</span>
              </a>
            </li>
          @endcan

          {{--<li>--}}
          {{--<a href="#">--}}
          {{--<i class="fa fa-clock-o"></i><span>Routine</span>--}}
          {{--</a>--}}
          {{--</li>--}}

        </ul>
      </li>
      @notrole('Student')
      <li class="treeview">
        <a href="#">
          <i class="fa icon-exam"></i>
          <span>@lang('menu.exams')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          @can('exam.index')
            <li>
              <a href="{{ URL::route('exam.index') }}">
                <i class="fa icon-exam"></i> <span>@lang('menu.exams')</span>
              </a>
            </li>
          @endcan
          @can('exam.grade.index')
            <li>
              <a href="{{ URL::route('exam.grade.index') }}">
                <i class="fa fa-bar-chart"></i> <span>@lang('menu.grades')</span>
              </a>
            </li>
          @endcan
          @can('exam.rule.index')
            <li>
              <a href="{{ URL::route('exam.rule.index') }}">
                <i class="fa fa-cog"></i> <span>@lang('menu.rules')</span>
              </a>
            </li>
          @endcan
        </ul>
      </li>
      <li class="treeview">
        <a href="#">
          <i class="fa icon-markmain"></i>
          <span>@lang('menu.marks_and_results')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          @can('marks.index')
            <li>
              <a href="{{ URL::route('marks.index') }}">
                <i class="fa icon-markmain"></i> <span>@lang('menu.marks')</span>
              </a>
            </li>
          @endcan
            @can('result.index')
            <li>
              <a href="{{ URL::route('result.index') }}">
                <i class="fa icon-markpercentage"></i> <span>@lang('menu.results')</span>
              </a>
            </li>
          @endcan
        </ul>
      </li>
      @endnotrole
      @notrole('Student')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-users"></i>
          <span>@lang('menu.hrm')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          @can('hrm.employee.index')
            <li>
              <a href="{{ URL::route('hrm.employee.index') }}">
                <i class="fa icon-member"></i> <span>@lang('menu.employees')</span>
              </a>
            </li>
          @endcan
            @can('hrm.leave.index')
              <li>
                <a href="{{ URL::route('hrm.leave.index') }}">
                  <i class="fa fa-bed"></i> <span>@lang('menu.leave')</span>
                </a>
              </li>
            @endcan

            @can('hrm.work_outside.index')
              <li>
                <a href="{{ URL::route('hrm.work_outside.index') }}">
                  <i class="glyphicon glyphicon-log-out"></i> <span>@lang('menu.work_outside')</span>
                </a>
              </li>
            @endcan
            @can('hrm.policy')
              <li>
                <a href="{{ URL::route('hrm.policy') }}">
                  <i class="fa fa-cogs"></i> <span>@lang('menu.policy_settings')</span>
                </a>
              </li>
            @endcan
        </ul>
      </li>
      @endnotrole
      @role('Admin')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>@lang('menu.administrator')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ URL::route('administrator.academic_year') }}">
              <i class="fa fa-calendar-plus-o"></i> <span>@lang('menu.accademic_year')</span>
            </a>
          </li>
          <li>
            <a href="{{ URL::route('administrator.template.mailsms.index') }}">
              <i class="fa icon-mailandsms"></i> <span>@lang('menu.mail_sms_template')</span>
            </a>
          </li>
          <li>
            <a href="{{ URL::route('administrator.template.idcard.index') }}">
              <i class="fa fa-id-card"></i> <span>@lang('menu.id_card_template')</span>
            </a>
          </li>

          <li>
            <a href="{{URL::route('administrator.user_index')}}">
              <i class="fa fa-user-md"></i> <span>@lang('menu.system_admins')</span>
            </a>
          </li>
          <li>
            <a href="{{route('administrator.user_password_reset')}}">
              <i class="fa fa-eye-slash"></i> <span>@lang('menu.reset_user_password')</span>
            </a>
          </li>
          <li>
            <a href="{{URL::route('user.role_index')}}">
              <i class="fa fa-users"></i> <span>@lang('menu.roles')</span>
            </a>
          </li>

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
      @can('user.index')
        <li>
          <a href="{{ URL::route('user.index') }}">
            <i class="fa fa-users"></i> <span>@lang('menu.users')</span>
          </a>
        </li>
      @endcan

      <li class="treeview">
        <a href="#">
          <i class="fa fa-file-pdf-o"></i>
          <span>@lang('menu.reports')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li class="treeview">
            <a href="#">
              <i class="fa icon-studentreport"></i>
              <span>@lang('menu.manage_students')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
{{--              @can('report.student_monthly_attendance')--}}
                <li>
                  <a href="{{ URL::route('report.student_monthly_attendance') }}">
                    <i class="fa icon-attendancereport"></i> <span>@lang('menu.monthly_attendance')</span>
                  </a>
                </li>
              {{--@endcan--}}
                <li>
                  <a href="{{route('report.student_list')}}">
                    <i class="fa icon-student"></i> <span>@lang('menu.students_list')</span>
                  </a>
                </li>
            </ul>
          </li>
          <li class="treeview">
            <a href="#">
              <i class="fa fa-users"></i>
              <span>@lang('menu.hrm')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{ URL::route('report.employee_monthly_attendance') }}"><i class="fa icon-attendancereport"></i> <span>@lang('menu.monthly_attendance')</span></a>
              </li>
              <li>
                <a href="{{route('report.employee_list')}}"><i class="fa icon-teacher"></i> <span>@lang('menu.employees_list')</span></a>
              </li>

            </ul>
          </li>

          <li class="treeview">
            <a href="#">
              <i class="fa icon-mark2"></i>
              <span>@lang('menu.marks_and_results')</span>
              <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
            </a>
            <ul class="treeview-menu">
              <li>
                <a href="{{route('report.marksheet_pub')}}"><i class="fa fa-file-pdf-o"></i><span>@lang('menu.marksheet_public')</span></a>
              </li>
            </ul>
          </li>
        </ul>
      </li>

      @role('Admin')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>@lang('menu.settings')</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ URL::route('settings.institute') }}">
              <i class="fa fa-building"></i> <span>@lang('menu.institute')</span>
            </a>
          </li>
          <li>
            <a href="{{ URL::route('settings.academic_calendar.index') }}">
              <i class="fa fa-calendar"></i> <span>@lang('menu.academic_calendar')</span>
            </a>
          </li>
          <li>
            <a href="{{ URL::route('settings.sms_gateway.index') }}">
              <i class="fa fa-external-link"></i> <span>@lang('menu.sms_gateways')</span>
            </a>
          </li>
          <li>
            <a href="{{ URL::route('settings.report') }}">
              <i class="fa fa-file-pdf-o"></i> <span>@lang('menu.reports')</span>
            </a>
          </li>
        </ul>
      </li>
      @endrole
      <!-- Frontend Website links and settings -->
      @if($frontend_website)
        <li class="treeview">
          <a href="#">
            <i class="fa fa-globe"></i>
            <span>@lang('menu.site')</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            @can('site.dashboard')
            <li>
              <a href="{{ URL::route('site.dashboard') }}">
                <i class="fa fa-dashboard"></i> <span>@lang('menu.dashboard')</span>
              </a>
            </li>
            @endcan
            <li class="treeview">
              <a href="#">
                <i class="fa fa-home"></i>
                <span>@lang('menu.home')</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                @can('site.index')
                <li><a href="{{URL::route('slider.index')}}"><i class="fa fa-picture-o text-aqua"></i> @lang('menu.sliders')</a></li>
                @endcan
                @can('site.about_content')
                <li><a href="{{URL::route('site.about_content')}}"><i class="fa fa-info text-aqua"></i> @lang('menu.about_us')</a></li>
                @endcan
                @can('site.service')
                <li><a href="{{ URL::route('site.service') }}"><i class="fa fa-file-text text-aqua"></i> @lang('menu.our_services')</a></li>
                @endcan
                @can('site.statistic')
                <li><a href="{{ URL::route('site.statistic') }}"><i class="fa fa-bars"></i> @lang('menu.statistics')</a></li>
                @endcan
                @can('site.testimonial')
                <li><a href="{{ URL::route('site.testimonial') }}"><i class="fa fa-comments"></i> @lang('menu.testimonials')</a></li>
                @endcan
                @can('site.subscribe')
                <li><a href="{{ URL::route('site.subscribe') }}"><i class="fa fa-users"></i> @lang('menu.subscribers')</a></li>
                @endcan
              </ul>
            </li>
             @can('class_profile.index')
              <li>
              <a href="{{ URL::route('class_profile.index') }}">
                <i class="fa fa-building"></i>
                <span>@lang('site.menu_class')</span>
              </a>
            </li>
            @endcan
             @can('teacher_profile.index')
              <li>
              <a href="{{ URL::route('teacher_profile.index') }}">
                <i class="fa icon-teacher"></i>
                <span>@lang('site.menu_teachers')</span>
              </a>
            </li>
            @endcan
            @can('event.index')
            <li>
              <a href="{{ URL::route('event.index') }}">
                <i class="fa fa-bullhorn"></i>
                <span>@lang('site.menu_events')</span>
              </a>
            </li>
            @endcan
            @can('site.gallery')
            <li>
              <a href="{{ URL::route('site.gallery') }}">
                <i class="fa fa-camera"></i>
                <span>@lang('site.menu_gallery')</span>
              </a>
            </li>
            @endcan
             @can('site.contact_us')
              <li>
              <a href="{{ URL::route('site.contact_us') }}">
                <i class="fa fa-map-marker"></i>
                <span>@lang('site.menu_contact_us')</span>
              </a>
            </li>
            @endcan
            @can('site.faq')
            <li>
              <a href="{{ URL::route('site.faq') }}">
                <i class="fa fa-question-circle"></i>
                <span>@lang('site.menu_faq')</span>
              </a>

            </li>
            @endcan
             @can('site.timeline')
              <li>
              <a href="{{ URL::route('site.timeline') }}"><i class="fa fa-clock-o"></i>
                <span>@lang('site.menu_timeline')</span>
              </a>
            </li>
            @endcan
             @can('site.settings')
              <li>
              <a href="{{ URL::route('site.settings') }}"><i class="fa fa-cogs"></i>
                <span>@lang('menu.settings')</span>
              </a>
            </li>
            @endcan
            @can('site.analytics')
            <li>
              <a href="{{ URL::route('site.analytics') }}"><i class="fa fa-line-chart"></i>
                <span>@lang('menu.analytics')</span>
              </a>
            </li>
             @endcan
          </ul>
        </li>
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
