@extends('layout.dashboard', ['active' => 'map'])

@push('style')
  {{-- <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" /> --}}
  <link rel="stylesheet" href="{{ asset('assets/vendors/file-upload-with-image-preview/style.css') }}">

  <style>
    #map {
      height: 300px;
    }
  </style>
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

  <form action="{{ route('category.store') }}" method="POST">
    @csrf
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="card-title">Create New Map</h4>
        <p class="card-description">Map</p>
        <div>
          <div class="row">
            <div class="col-12 col-md-6">
              <div id="map"></div>
            </div>
            <br>
            <div class="col-12 col-md-6">
              <div class="form-group">
                <label for="exampleInputUsername1">Latitude</label>
                <input type="text" name="latitude" class="form-control" id="exampleInputUsername1"
                  placeholder="Latitude" value="{{ old('latitude') }}">
              </div>
              <div class="form-group">
                <label for="exampleInputUsername1">Longtitude</label>
                <input type="text" name="longtitude" class="form-control" id="exampleInputUsername1"
                  placeholder="Longtitude" value="{{ old('longtitude') }}">
              </div>
              <div class="form-group">
                <label for="exampleInputUsername1">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputUsername1" placeholder="Name"
                  value="{{ old('name') }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <div class="custom-file-container" data-upload-id="my-unique-id"></div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <p class="card-description">Description</p>
        <div class="forms-sample">
          <div class="form-floating mb-3">
            <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea2"
              style="height: 100px">{{ old('description') }}</textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
          <div class="form-group mb-3">
            <label for="exampleInputUsername1">Open</label>
            <input type="time" name="open" class="form-control" id="exampleInputUsername1" placeholder="Open"
              value="{{ old('open') }}">
          </div>
          <div class="form-group mb-3">
            <label for="exampleInputUsername1">Close</label>
            <input type="time" name="close" class="form-control" id="exampleInputUsername1" placeholder="Close"
              value="{{ old('close') }}">
          </div>

          <div class="list-group text-bg-secondary p-3">
            <label for="operational-day">Operational Days</label>
            <div class="row row-cols-4 px-5">
              @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $item)
                <div class="col-12 col-md-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input daily" type="checkbox" name="daily[]" value="{{ $item }}"
                      id="{{ $item }}">
                    <label class="form-check-label" for="{{ $item }}">
                      {{ $item }}
                    </label>
                  </div>
                </div>
              @endforeach
              <div class="col-12 col-md-3">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="all-day">
                  <label class="form-check-label" for="all-day">
                    All Days
                  </label>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Create</button>
  </form>
@endsection


@push('script')
  {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script> --}}
  <script src="{{ asset('assets/vendors/file-upload-with-image-preview/file-upload-with-preview.iife.js') }}"></script>


  {{-- map --}}
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
  </script>

  {{-- image preview --}}
  <script>
    const upload = new FileUploadWithPreview.FileUploadWithPreview('my-unique-id', {
      multiple: true,
      text: {
        browse: 'Choose',
        chooseFile: 'Take your pick...',
        label: 'Image',
      },
    })
    document.getElementById("file-upload-with-preview-my-unique-id").setAttribute('name', 'image[]')
  </script>

  <script>
    const allday = document.getElementById('all-day')
    const daily = document.getElementsByClassName('daily')

    allday.addEventListener('change', (e) => {
      if (e.target.checked) {
        for (let index = 0; index < daily.length; index++) {
          const element = daily[index];
          element.checked = true
        }
      } else {
        for (let index = 0; index < daily.length; index++) {
          const element = daily[index];
          element.checked = false
        }
      }
    })
  </script>
@endpush
