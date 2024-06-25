<header
  class="navbar bg-transparent position-fixed w-100 px-5 p-md-2 row justify-content-center mx-auto"
  style="z-index: 1000">
  <div class="bg-body p-2 rounded d-flex gap-1 col-12 col-md-3 justify-content-between">
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas"
      data-bs-target="#navigation" aria-controls="navbarNavDropdown" aria-expanded="false"
      aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    {{-- search --}}
    <form class="d-flex align-items-center border rounded w-100" id="search">
      <div class="w-100">
        <input class="form-control me-2 border-0 w-100" type="text" name="search"
          placeholder="Search" id="inputsearch" aria-label="Search" list="list">
        <datalist id="list">
          @foreach ($markers as $marker)
            <option value="{{ $marker->name }}">{{ $marker->name }}</option>
          @endforeach
        </datalist>
      </div>
      <button class="btn" type="submit">
        <i class="fa fa-search" aria-hidden="true"></i>
      </button>
    </form>

    <!-- trigger modal -->
    <input type="checkbox" class="btn-check" id="openmodal" autocomplete="off">
    <label class="btn btn-outline-info" for="openmodal">
      <i class="fa fa-filter"></i>
    </label>
  </div>
</header>
