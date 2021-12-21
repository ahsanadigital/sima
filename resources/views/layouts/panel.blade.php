<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />

  <!-- Main Title Here -->
  <title>{{ !empty($title) ? $title : config('app.name') }}</title>

  <!-- Main Styling -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/fontawesome-free/css/all.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('vendor/toastr/snackbar.css') }}" />

  <!-- Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />

  @yield('header')
</head>
<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

      <!-- Sidebar - Brand -->
      <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
        <img src="{{ asset('images/logo.png') }}" height="75px" alt="{{ config('app.name') }}" />
      </a>

      <!-- Divider -->
      <hr class="sidebar-divider my-0">

      <!-- Nav Item - Dashboard -->
      <li class="{{ request()->route()->getName() == 'panel.home' ? 'nav-item active' : 'nav-item' }}">
        <a class="nav-link" href="{{ route('panel.home') }}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        Activities
      </div>

      @auth('user')
      <!-- Menus -->
      <li class="{{ Str::is('agenda*', request()->route()->getName()) ? 'nav-item active' : 'nav-item' }}">
        <a class="{{ Str::is('agenda*', request()->route()->getName()) ? 'nav-link active' : 'nav-link' }}" href="{{ route('agenda.index') }}">
          <i class="fas fa-fw fa-clock"></i>
          <span>My Agenda</span>
        </a>
      </li>

      <li class="{{ Str::is('event*', request()->route()->getName()) ? 'nav-item active' : 'nav-item' }}">
        <a class="{{ Str::is('event*', request()->route()->getName()) ? 'nav-link' : 'nav-link collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseEventUser" aria-expanded="true" aria-controls="collapseEventUser">
          <i class="fas fa-fw fa-scroll"></i>
          <span>Event</span>
        </a>
        <div id="collapseEventUser" class="{{ Str::is('event*', request()->route()->getName()) ? 'collapse show' : 'collapse' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="{{ request()->route()->getName() == 'event.scholarship' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('event.scholarship') }}">Scholarship</a>
            <a class="{{ request()->route()->getName() == 'event.seminar' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('event.seminar') }}">Seminar</a>
            <a class="{{ request()->route()->getName() == 'event.competition' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('event.competition') }}">Competition</a>
            <a class="{{ request()->route()->getName() == 'event.volunteer' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('event.volunteer') }}">Volunteer</a>
          </div>
        </div>
      </li>
      @endauth

      @auth('admin')
      <li class="{{ Str::is('events*', request()->route()->getName()) ? 'nav-item active' : 'nav-item' }}">
        <a class="{{ Str::is('events*', request()->route()->getName()) ? 'nav-link' : 'nav-link collapsed' }}" href="#" data-toggle="collapse" data-target="#collapseEvent" aria-expanded="true" aria-controls="collapseEvent">
          <i class="fas fa-fw fa-map-pin"></i>
          <span>Events</span>
        </a>
        <div id="collapseEvent" class="{{ Str::is('events*', request()->route()->getName()) ? 'collapse show' : 'collapse' }}" aria-labelledby="headingPages" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <a class="{{ request()->route()->getName() == 'events.index' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('events.index') }}">All Events</a>
            <a class="{{ request()->route()->getName() == 'events.create' ? 'collapse-item active' : 'collapse-item' }}" href="{{ route('events.create') }}">Add New</a>
          </div>
        </div>
      </li>

      <!-- Divider -->
      <hr class="sidebar-divider">

      <!-- Heading -->
      <div class="sidebar-heading">
        User
      </div>

      <!-- Menus -->
      <li class="nav-item">
        <a class="nav-link" href="javascript:void(0)">
          <i class="fas fa-fw fa-list"></i>
          <span>User Log</span>
        </a>
      </li>
      @endauth

      <!-- Divider -->
      <hr class="sidebar-divider d-none d-md-block">

      <!-- Sidebar Toggler (Sidebar) -->
      <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
      </div>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

          <!-- Sidebar Toggle (Topbar) -->
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>

          <!-- Topbar Navbar -->
          <ul class="navbar-nav ml-auto">

            <!-- Nav Item - User Information -->
            <li class="nav-item dropdown no-arrow">
              <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ auth()->guard('admin')->user() ? auth()->guard('admin')->user()->fullname : auth()->guard('user')->user()->fullname }}</span>
                @auth('admin')
                  @if (auth()->guard('admin')->user()->pp)
                    <img src="{{ asset(auth()->guard('admin')->user()->pp) }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="img-profile rounded-circle" />
                  @else
                    <img src="{{ Gravatar::src(auth()->guard('admin')->user()->email) }}" alt="{{ auth()->guard('admin')->user()->fullname }}" class="img-profile rounded-circle" />
                  @endif
                @endauth

                @auth('user')
                  @if (auth()->guard('user')->user()->pp)
                    <img src="{{ asset(auth()->guard('user')->user()->pp) }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="img-profile rounded-circle" />
                  @else
                    <img src="{{ Gravatar::src(auth()->guard('user')->user()->email) }}" alt="{{ auth()->guard('user')->user()->fullname }}" class="img-profile rounded-circle" />
                  @endif
                @endauth
              </a>
              <!-- Dropdown - User Information -->
              <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="{{ request()->route()->getName() == 'user-edit.home' ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('user-edit.home') }}">
                  <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                  My Profile
                </a>
                <a class="{{ request()->route()->getName() == 'user-password.home' ? 'dropdown-item active' : 'dropdown-item' }}" href="{{ route('user-password.home') }}">
                  <i class="fas fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                  Change Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                  <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                  Logout
                </a>
              </div>
            </li>

          </ul>

        </nav>
        <!-- End of Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">

          @yield('container')

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Hak Cipta <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <p>Are you sure for logout from this web and any session? If yes please press the "Logout" button.</p>

          <div class="m-0 alert alert-warning">
            <h5>Warning!</h5>
            <p class="m-0">Your data are not saved will be removed and not be able to recovery!</p>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-light" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Script -->
  <script src="{{ asset('js/app.js') }}"></script>
  <script src="{{ asset('vendor/toastr/snackbar.js') }}"></script>

  @yield('footer')
  @stack('script')

  @if(session('error'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("error") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#e74a3b',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('success'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("success") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#1cc88a',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('warning'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("warning") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#f6c23e',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @elseif(session('info'))
  <script>
    "use strict";

    Snackbar.show({
      pos: 'top-right',
      actionText: 'Close',
      width: '25%',
      text: '{{ session("warning") }}',
      textColor: '#FFFFFF',
      backgroundColor: '#36b9cc',
      actionTextColor: '#FFFFFF',
    });
  </script>
  @endif
</body>

</html>
