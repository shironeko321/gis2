@extends('layout.dashboard', ['active' => 'map'])

@push('style')
  {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> --}}

  <style>
    #map {
      height: 180px;
    }
  </style>
@endpush

@push('script')
  {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script>
    var map = L.map('map').setView([51.505, -0.09], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    var marker = L.marker([51.5, -0.09]).addTo(map);

    var popup = L.popup();

    function onMapClick(e) {
      popup
        .setLatLng(e.latlng)
        .setContent("You clicked the map at " + e.latlng.toString())
        .openOn(map);
    }

    map.on('click', onMapClick);
  </script> --}}
@endpush

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-plus"></i>
      </span> Map
    </h3>
  </div>

  @if ($errors->any())
    <ul class="alert alert-warning">
      @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
  @endif

  @if (session()->has('msg'))
    <div class="alert alert-success">{{ session()->get('msg') }}</div>
  @endif

  <form action="{{ route('category.store') }}" method="POST" class="card">
    @csrf
    <div class="card-body">
      <h4 class="card-title">Create New Map</h4>
      <p class="card-description">Map</p>
      <div class="forms-sample">
        <div id="map"></div>
        <div class="row">
          <div class="col-6">
            <div class="form-group">
              <label for="exampleInputUsername1">Latitude</label>
              <input type="text" name="latitude" class="form-control" id="exampleInputUsername1" placeholder="Name"
                value="{{ old('latitude') }}">
            </div>
          </div>
          <div class="col-6">
            <div class="form-group">
              <label for="exampleInputUsername1">Longtitude</label>
              <input type="text" name="longtitude" class="form-control" id="exampleInputUsername1" placeholder="Name"
                value="{{ old('longtitude') }}">
            </div>
          </div>
        </div>
        <div class="form-group">
          <label for="exampleInputUsername1">Name</label>
          <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Name"
            value="{{ old('name') }}">
        </div>
      </div>
    </div>

    <div class="card-body">
      <p class="card-description">Images</p>
      <div class="forms-sample">
        <div class="form-group">
          <label for="exampleInputUsername1">Name</label>
          <input type="file" name="name" class="form-control" id="exampleInputUsername1" placeholder="Name"
            value="{{ old('name') }}">
        </div>
      </div>
    </div>

  </form>
@endsection
