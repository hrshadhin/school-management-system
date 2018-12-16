
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
          <li>
            <a href="#">
              <i class="fa icon-subject"></i> <span>Subject</span>
            </a>
          </li>
          {{--<li>--}}
          {{--<a href="#">--}}
          {{--<i class="fa fa-clock-o"></i><span>Routine</span>--}}
          {{--</a>--}}
          {{--</li>--}}

        </ul>
      </li>
      @role('Admin')
      <li class="treeview">
        <a href="#">
          <i class="fa fa-user-secret"></i>
          <span>Administrator</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li>
            <a href="{{ URL::route('administrator.academic_year') }}">
              <i class="fa fa-calendar-plus-o"></i> <span>Academic Year</span>
            </a>
          </li>

          <li>
            <a href="{{URL::route('administrator.user_index')}}">
              <i class="fa fa-user-md"></i> <span>System Admin</span>
            </a>
          </li>
          <li>
            <a href="{{route('administrator.user_password_reset')}}">
              <i class="fa fa-eye-slash"></i> <span>Reset User Password</span>
            </a>
          </li>
          <li>
            <a href="{{URL::route('user.role_index')}}">
              <i class="fa fa-users"></i> <span>Role</span>
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
            <i class="fa fa-users"></i> <span>Users</span>
          </a>
        </li>
      @endcan
      <li class="treeview">
        <a href="#">
          <i class="fa fa-cogs"></i>
          <span>Settings</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          @role('Admin')
          <li>
            <a href="{{ URL::route('settings.institute') }}">
              <i class="fa fa-building"></i> <span>Institute</span>
            </a>
          </li>
          @endrole
          <li>
            <a href="#">
              <i class="fa fa-file-text"></i> <span>SMS</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-envelope"></i> <span>Email</span>
            </a>
          </li>

          <li>
            <a href="#">
              <i class="fa fa-certificate"></i> <span>Certificates</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class="fa fa-files-o"></i> <span>Reports</span>
            </a>
          </li>
          {{--<li>--}}
          {{--<a href="#">--}}
          {{--<i class="fa fa-share-alt"></i><span>Miscellaneous</span>--}}
          {{--</a>--}}
          {{--</li>--}}
        </ul>
      </li>
      <!-- Frontend Website links and settings -->
      @if($frontend_website)
        <li class="treeview">
          <a href="#">
            <i class="fa fa-globe"></i>
            <span>Site</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li>
              <a href="{{ URL::route('site.dashboard') }}">
                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
              </a>
            </li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-home"></i>
                <span>Home</span>
                <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="{{URL::route('slider.index')}}"><i class="fa fa-picture-o text-aqua"></i> Sliders</a></li>
                <li><a href="{{URL::route('site.about_content')}}"><i class="fa fa-info text-aqua"></i> About Us</a></li>
                <li><a href="{{ URL::route('site.service') }}"><i class="fa fa-file-text text-aqua"></i> Our Services</a></li>
                <li><a href="{{ URL::route('site.statistic') }}"><i class="fa fa-bars"></i> Statistic</a></li>
                <li><a href="{{ URL::route('site.testimonial') }}"><i class="fa fa-comments"></i> Testimonials</a></li>
                <li><a href="{{ URL::route('site.subscribe') }}"><i class="fa fa-users"></i> Subscribers</a></li>
              </ul>
            </li>
            <li>
              <a href="{{ URL::route('class_profile.index') }}">
                <i class="fa fa-building"></i>
                <span>Class</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('teacher_profile.index') }}">
                <i class="fa icon-teacher"></i>
                <span>Teachers</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('event.index') }}">
                <i class="fa fa-bullhorn"></i>
                <span>Events</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.gallery') }}">
                <i class="fa fa-camera"></i>
                <span>Gallery</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.contact_us') }}">
                <i class="fa fa-map-marker"></i>
                <span>Contact Us</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.faq') }}">
                <i class="fa fa-question-circle"></i>
                <span>FAQ</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.timeline') }}"><i class="fa fa-clock-o"></i>
                <span>Timeline</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.settings') }}"><i class="fa fa-cogs"></i>
                <span>Settings</span>
              </a>
            </li>
            <li>
              <a href="{{ URL::route('site.analytics') }}"><i class="fa fa-line-chart"></i>
                <span>Analytics</span>
              </a>
            </li>
          </ul>
        </li>
      @endif
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>
