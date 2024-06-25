<li class="nav-item px-0 px-lg-3">
  <a @class(['nav-link', 'active' => request()->routeIs('home')]) href="{{ route('home') }}">Home</a>
</li>
<li class="nav-item px-0 px-lg-3">
  <a @class(['nav-link', 'active' => request()->routeIs('map')]) href="{{ route('map') }}">Map</a>
</li>
<li class="nav-item px-0 px-lg-3">
  <a @class(['nav-link', 'active' => request()->routeIs('contact')]) href="{{ route('contact') }}">Contact</a>
</li>
<li class="nav-item px-0 px-lg-3">
  <a @class(['nav-link', 'active' => request()->routeIs('about')]) href="{{ route('about') }}">About</a>
</li>
