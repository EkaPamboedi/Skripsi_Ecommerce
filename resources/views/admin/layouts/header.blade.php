<header class="main-header">
  <!-- mini logo for sidebar mini 50x50 pixels -->

  <span class="logo-mini">{{-- $word --}}</span>
  <!-- logo for regular state and mobile devices -->

    <!-- Logo -->
    <a  class="logo">
      <!-- <span class="logo-lg" style="font-family: 'Teko', sans-serif;">{{ auth()->user()->name }}</span> -->
      <span class="logo-lg" style=" font-family: 'Teko', sans-serif;">{{ auth()->user()->name }}</span>
      <span class="logo-mini">  <img src="{{ url(auth()->user()->foto ?? '') }}" class="user-image img-profil"
            alt="User Image"></span>
      <!-- <img src="" alt="as"> -->
      <!-- <span class="logo-lg"><b>Kenal Kopi</b></span> -->
    </a>
  <!-- <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
    <span class="sr-only">Toggle navigation</span>
  </a> -->

    <!-- Header Navbar: style can be found in header.less -->
        <!-- Sidebar toggle button-->


        <nav class="navbar navbar-static-top">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ url(auth()->user()->foto ?? '') }}" class="user-image img-profil"
                            alt="User Image">
                        <span class="hidden-xs">{{ auth()->user()->name }}</span>
                    </a>
                    <ul class="dropdown-menu list-group" style="width:20px;">
                        <!-- User image -->
                        <li class="list-group-item list-group-item-action">
                          <a  href="{{ route('user.profile') }}" class="btn btn-outline-secondary">Profile</a>
                        </li>
                        <li class="list-group-item list-group-item-action">
                          <a  href="#" class="btn btn-outline-secondary"
                              onclick="$('#logout-form').submit()">Keluar</a>
                        </li>
                    </ul>

                </li>
            </ul>
        </div>
    </nav>
</header>

<form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
    @csrf
</form>
