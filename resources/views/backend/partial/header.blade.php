<header class="main-header">
    <!-- Logo -->
<a href="{{ URL::route('user.dashboard') }}" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini">
      <img src="{{ asset('images/logo-sm.png') }}" alt="logo-mini">
      </span>
      <!-- logo for regular state and mobile devices -->
      <span class="logo-lg">
        <img src="{{ asset('images/logo-md.png') }}" alt="logo-md">
      </span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">    
          <li class="clock-menu hidden-xs">
            <a href="#0">
                <p class="smsclock"><span id="date"></span> || <span id="clock"></span></p>
            </a>
          </li>     
          <!-- Site Start -->
        <li class="dropdown site-menu">
        <a target="_blank" title="Site" href="{{ URL::route('home') }}" class="dropdown-toggle" data-toggle="tooltip" title="" data-placement="bottom" data-original-title="Visit Site">
                <i class="fa fa-globe"></i>
            </a>
        </li>
        <!-- Site Close -->
         <!-- Notifications: style can be found in dropdown.less-->
         <li class="dropdown messages-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-danger"><lable class="alert-image">15</lable></span> </a>
            <ul class="dropdown-menu">
                <li class="header">You have 5 recent notifications</li>
                <li>
                        <ul class="menu notification">
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                    <img class="img-circle" src="{{ asset('images/notification.png') }}"></div>
                                    <h4>Praesentium comm..<small><i class="fa fa-clock-o"></i> 5 min</small></h4>
                                    <p>Blanditiis quia distinctio rep..</p>
                                </a>
                            </li>                           
                            <li>
                                <a href="#">
                                    <div class="pull-left"><img class="img-circle" src="{{ asset('images/notification.png') }}"></div>
                                    <h4>Autem modi aliqu..<small><i class="fa fa-clock-o"></i> 2 days</small></h4>
                                    <p>Necessitatibus omnis voluptate..</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                    <img class="img-circle" src="{{ asset('images/notification.png') }}"></div>
                                    <h4>Praesentium comm..<small><i class="fa fa-clock-o"></i> 5 days</small></h4>
                                    <p>Blanditiis quia distinctio rep..</p>
                                </a>
                            </li>                           
                            <li>
                                <a href="#">
                                    <div class="pull-left"><img class="img-circle" src="{{ asset('images/notification.png') }}"></div>
                                    <h4>Autem modi aliqu..<small><i class="fa fa-clock-o"></i> 5 days</small></h4>
                                    <p>Necessitatibus omnis voluptate..</p>
                                </a>
                            </li>
                            <li>
                                <a href="#">
                                    <div class="pull-left">
                                    <img class="img-circle" src="{{ asset('images/notification.png') }}"></div>
                                    <h4>Praesentium comm..<small><i class="fa fa-clock-o"></i> 20 days</small></h4>
                                    <p>Blanditiis quia distinctio rep..</p>
                                </a>
                            </li>                         
                           
                        </ul>
                      
                </li>
                <li class="footer"><a href="#">See All Notifications</a></li>
            </ul>
        </li>                                                  
          
        <li class="dropdown lang-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img class="language-img" src="{{ asset('images/lang/english.png') }}"> 
                <span class="label label-warning">3</span>
            </a>
            <ul class="dropdown-menu">
                <li class="header"> Language</li>            
                <li class="language" id="bangla">
                    <a href="#">
                        <div class="pull-left">
                            <img src="{{ asset('images/lang/bangla.png') }}">
                        </div>
                        <h4>
                            Bangla
                        </h4>
                    </a>
                </li>                     
                <li class="language" id="english">
                    <a href="#">
                        <div class="pull-left">
                            <img src="{{ asset('images/lang/english.png') }}">
                        </div>
                        <h4>
                            English  <i class="glyphicon glyphicon-ok green pull-right"></i>  
                        </h4>
                    </a>
                </li>
                <li class="language" id="hindi">
                    <a href="#">
                        <div class="pull-left">
                            <img src="{{ asset('images/lang/hindi.png') }}">
                        </div>
                        <h4>
                          Hindi
                        </h4>
                    </a>
                </li>               
                <li class="footer"></li>
            </ul>
        </li>                   
<!-- User Account: style can be found in dropdown.less -->
<li class="dropdown user user-menu">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="fa fa-user"></i>
        <span>Admin <i class="caret"></i></span>
    </a>

    <ul class="dropdown-menu">
        <!-- Menu Body -->
        <li class="user-body">
            <div class="col-xs-6 text-center">
                <a href="#">
                    <div><i class="fa fa-briefcase"></i></div>
                    Profile
                </a>
            </div>
            <div class="col-xs-6 text-center password">
                <a href="#">
                    <div><i class="fa fa-lock"></i></div>
                   Password
                </a>
            </div>
        </li>

        <!-- Menu Footer-->
        <li class="user-footer">

            <div class="text-center">
            <a href="{{ URL::route('logout') }}">
                    <div><i class="fa fa-power-off"></i></div>
                    Log out
                </a>
            </div>
        </li>
    </ul>
</li>         
          <!-- Control Sidebar Toggle Button -->
          <li>
            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
          </li>
        </ul>
      </div>
    </nav>
  </header>