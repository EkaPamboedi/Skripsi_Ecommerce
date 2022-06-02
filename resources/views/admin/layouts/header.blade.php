<header class="main-header" >
  <!-- mini logo for sidebar mini 50x50 pixels -->

  <span class="logo-mini">{{-- $word --}}</span>
  <!-- logo for regular state and mobile devices -->

    <!-- Logo -->
    <a  class="logo" style="background-color:#CE9461;">
      <span class="logo-lg" style="font-family: 'Teko', sans-serif;">{{-- auth()->user()->name --}} Kenal Kopi</span>
      <span class="logo-mini">  <img src="{{ asset('/Logo_Kedai/Icon_KenalKopi.png') }}" class="user-image img-profil"
            alt="User Image"></span>
      <!-- <img src="" alt="as"> -->
      <!-- <span class="logo-lg"><b>Kenal Kopi</b></span> -->
    </a>

    <!-- Header Navbar: style can be found in header.less -->
        <!-- Sidebar toggle button-->


        <nav class="navbar navbar-static-top"  style="background-color:#CE9461;">
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <button style="padding: 8px 15px 8px 15px; border: 0; background: none;" href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img  style="margin:2px;" src="{{ url(auth()->user()->foto ?? '') }}" class="user-image img-profil" alt="User Image">
                  </button>
                    <ul class="dropdown-menu list-group" style="margin-top:1vh; border: 0; background: none; width: 3em;">
                        <!-- User image -->
                        <li class="list-group-item list-group-item-action">
                          <a  href="{{ route('user.profile') }}" class="btn btn-outline-secondary">{{ auth()->user()->name }}</a>
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
