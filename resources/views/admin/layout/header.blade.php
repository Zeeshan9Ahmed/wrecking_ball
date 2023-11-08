<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Wrecking Ball | Dashboard</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="{{ asset('public/web/assets/images/favicon.png') }}" />
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/fontawesome-free/css/all.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css')}}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/jqvmap/jqvmap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('public/admin/dist/css/adminlte.min.css')}}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/daterangepicker/daterangepicker.css')}}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{asset('public/admin/plugins/summernote/summernote-bs4.min.css')}}">
  @yield('style')
  <style>
    /* .nav-pills .nav-link:not(.active):hover {
    color: #f0f2f5;
}

.nav_active {
  background-color: #781a1a;
  color: white;
} */
  </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
  <div class="wrapper">

  <!-- Preloader -->
  <div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="{{asset('public/admin/app_icon.png')}}" alt="Syriac Hymnal" height="60" width="60">
  </div>

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
     <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="{{url('/dashboard')}}" class="nav-link">Home</a>
      </li>
  
    </ul>

    <!-- <ul class="navbar-nav ml-auto"> -->
      <!-- Navbar Search -->
     

      <!-- Messages Dropdown Menu -->
      
      <!-- Notifications Dropdown Menu -->
      <!-- <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-people"></i>
          <span class="badge badge-warning navbar-badge">Profile</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right"> -->
          
          <!-- <div class="dropdown-divider"></div>
          <a href="" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> Profile
            
          </a> -->
          <!-- <div class="dropdown-divider"></div>
          <a href="{{ route('logout') }}" class="dropdown-item">
            <i class="fas fa-users mr-2"></i>Logout
           
          </a>
          
      </li>
      
    </ul> -->
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4" >
    <!-- Brand Logo -->
    <a href="{{route('dashboard')}}" class="brand-link">
      <img src="{{asset('public/admin/app_icon.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">Wrecking Ball</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <!-- <img src="" class="img-circle elevation-2" alt=""> -->
        </div>
        <div class="info">
          <a href="#" class="d-block">Admin</a>
        </div>
      </div>

      <!-- SidebarSearch Form -->
    

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
        
            

         

            <li class="nav-item {{ Request::is('dashboard') ? 'nav_active' : '' }}">
              <a href="{{ route('dashboard') }}" class="nav-link">
                <i class="nav-icon fas fa-list"></i>
                  <p>
                    Dashboard
                  </p>
              </a>
            </li>
            

            <li class="nav-item {{ Request::is('cycles') ? 'nav_active' : '' }}">
              <a href="{{ route('admin.exercises') }}" class="nav-link">
                <i class="nav-icon fas fa-recycle"></i>
                  <p>
                    Exercises
                  </p>
              </a>
            </li>


            <!-- <li class="nav-item {{ Request::is('chants') ? 'nav_active' : '' }}">
              <a href="{{-- route('admin.chants') --}}" class="nav-link">
                <i class="nav-icon fas fa-recycle"></i>
                  <p>
                    Chants
                  </p>
              </a>
            </li> -->
            

           <!-- <li class="nav-item">
            <a href="{{ route('dashboard')}}" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Health Care Centers
              </p>
            </a>
          </li> -->
          
           <!-- <li class="nav-item">
            <a href="{{url('/nurses')}}" class="nav-link">
              <i class="nav-icon fas fa-user-friends"></i>
              <p>
                Nurses
              </p>
            </a>
          </li> -->

        


          
         <!--<li class="nav-item">-->
         <!--   <a href="" class="nav-link">-->
         <!--     <i class="nav-icon fas fa-copy"></i>-->
         <!--     <p>-->
         <!--       Notifications-->
         <!--     </p>-->
         <!--   </a>-->
         <!-- </li>-->
         
         
          <li class="nav-item">
            <a href="{{ route('admin.logout')}}" class="nav-link">
              <i class="nav-icon fas fa-trash"></i>
               <p>
               Logout
              </p>
            </a>
          </li>
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(){
  document.querySelectorAll('.sidebar .nav-link').forEach(function(element){
    
    element.addEventListener('click', function (e) {

      let nextEl = element.nextElementSibling;
      let parentEl  = element.parentElement;  

        if(nextEl) {
            e.preventDefault(); 
            let mycollapse = new bootstrap.Collapse(nextEl);
            
            if(nextEl.classList.contains('show')){
              mycollapse.hide();
            } else {
                mycollapse.show();
                // find other submenus with class=show
                var opened_submenu = parentEl.parentElement.querySelector('.submenu.show');
                // if it exists, then close all of them
                if(opened_submenu){
                  new bootstrap.Collapse(opened_submenu);
                }
            }
        }
    }); // addEventListener
  }) // forEach
}); 
  </script>