<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile">
      <a href="#" class="nav-link">
        {{-- <div class="nav-profile-image"> --}}
        {{-- <img src="{{ asset('/assets/images/faces/face1.jpg') }}" alt="profile" /> --}}
        {{-- <span class="login-status online"></span> --}}
        <!--change to offline or busy as needed-->
        {{-- </div> --}}
        <div class="nav-profile-text d-flex flex-column">
          <span class="font-weight-bold mb-2">{{ Auth::user()->name }}</span>
          <span class="text-secondary text-small">Admin</span>
        </div>
        <i class="mdi mdi-bookmark-check text-success nav-profile-badge"></i>
      </a>
    </li>
    <li @class(['nav-item', 'active' => $active == 'dashboard'])>
      <a class="nav-link" href="{{ route('dashboard') }}">
        <span class="menu-title">Dashboard</span>
        <i class="mdi mdi-home menu-icon"></i>
      </a>
    </li>
    <li @class(['nav-item', 'active' => $active == 'map'])>
      <a class="nav-link" href="{{ route('map.index') }}">
        <span class="menu-title">Maps</span>
        <i class="mdi mdi-map menu-icon"></i>
      </a>
    </li>
    <li @class(['nav-item', 'active' => $active == 'category'])>
      <a class="nav-link" href="{{ route('category.index') }}">
        <span class="menu-title">Category</span>
        <i class="mdi mdi-layers menu-icon"></i>
      </a>
    </li>
    <li @class(['nav-item', 'active' => $active == 'users'])>
      <a class="nav-link" href="{{ route('user.index') }}">
        <span class="menu-title">Users</span>
        <i class="mdi mdi-account menu-icon"></i>
      </a>
    </li>
  </ul>
</nav>
