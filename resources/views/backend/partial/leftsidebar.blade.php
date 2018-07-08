
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">    
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
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
            <li><a href="#"><i class="fa fa-comments"></i> Testimonials</a></li>
            <li><a href="#"><i class="fa fa-users"></i> Subscribers</a></li>            
          </ul>
        </li>      
     
        <li>
          <a href="#">
            <i class="fa fa-building"></i>
            <span>Class</span>           
          </a>         
        </li>

        <li>
          <a href="#">
            <i class="fa icon-teacher"></i>
            <span>Teachers</span>           
          </a>         
        </li>   
        <li>
          <a href="#">
            <i class="fa fa-bullhorn"></i>
            <span>Events</span>           
          </a>         
        </li>   
        <li>
          <a href="#">
            <i class="fa fa-camera"></i>
            <span>Gallery</span>           
          </a>         
        </li>   
        <li>
          <a href="#">
            <i class="fa fa-map-marker"></i>
            <span>Contact Us</span>           
          </a>         
        </li>   
        <li>
          <a href="#">
            <i class="fa fa-question-circle"></i>
            <span>FAQ</span>
          </a>
          </li>
        <li>
          <a href="#"><i class="fa fa-clock-o"></i>
            <span>Timeline</span>
        </a>
        </li>
     
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
