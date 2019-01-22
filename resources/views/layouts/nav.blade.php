<nav class="navbar navbar-default navbar-fixed-top be-top-header">
    <div class="container-fluid">
      <div class="navbar-header"><a href="index.html" class="navbar-brand"></a></div>
      <div class="be-right-navbar">
        <ul class="nav navbar-nav navbar-right be-user-nav">
          <li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><img src="assets/img/avatar.png" alt="Avatar"><span class="user-name">{{ Auth::user()->nama_member }}</span></a>
            <ul role="menu" class="dropdown-menu">
              <li>
                <div class="user-info">
                  <div class="user-name">{{ Auth::user()->nama_member }}</div>
                  <div class="user-position online">Available</div>
                </div>
              </li>
              <li><a href="{{ route('profile.index') }}"><span class="icon mdi mdi-account-o"></span> Profile</a></li>
              <li><a href="{{ route('logout') }}"><span class="icon mdi mdi-power"></span> Logout</a></li>
            </ul>
          </li>
        </ul>
        <div class="page-title"><span>@yield('page-title')</span></div>
      </div>
    </div>
</nav>