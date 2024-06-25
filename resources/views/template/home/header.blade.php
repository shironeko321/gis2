<nav class="navbar navbar-expand-lg" data-bs-theme="dark">
  <div class="container">
    <a class="navbar-brand" href="{{ route('home') }}">Destinasi</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
      data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
      aria-expanded="false" aria-label="Toggle navigation" id="navbar-toggler">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        @include('template.home.navigation')
      </ul>
    </div>
  </div>
</nav>
