
  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <section class="sidebar">    
      <!-- sidebar menu -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="active">
          <a href="{{ URL::route('user.dashboard') }}">
            <i class="fa fa-dashboard"></i> <span>Dashboard</span>          
          </a>          
        </li>      
        <li class="treeview">
          <a href="#">
            <i class="fa fa-home"></i>
            <span>Class</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> Add New</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> List</a></li>
          </ul>
        </li>      
     
        <li class="treeview">
          <a href="#">
            <i class="fa fa-book"></i>
            <span>Subject</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> Add New</a></li>
            <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> List</a></li>
          </ul>
        </li>      
     
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
