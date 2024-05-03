@extends('layout.dashboard', ['active' => 'map'])

@push('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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

  <form action="{{ route('map.store') }}" method="POST" enctype="multipart/form-data">
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
                <label for="latitude">Latitude</label>
                <input type="number" name="latitude" class="form-control" id="latitude"
                  placeholder="Latitude" value="{{ old('latitude') }}" step="any">
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" name="longitude" class="form-control" id="longitude"
                  placeholder="Longitude" value="{{ old('longitude') }}" step="any">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name"
                  placeholder="Name" value="{{ old('name') }}">
              </div>
              <button type="button" class="btn btn-primary" id="check-coordinate">Check
                Coordinate</button>
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
            <label for="exampleInputUsername1">Category</label>
            <select class="form-select" name="category" aria-label="Default select example">
              <option selected disabled>Open this select category</option>
              @foreach ($category as $item)
                <option value="{{ $item->id }}">{{ $item->name }}</option>
              @endforeach
            </select>
          </div>
          <div class="form-group mb-3">
            <label for="open">Open</label>
            <input type="time" name="open" class="form-control" id="open"
              placeholder="Open" value="{{ old('open') }}">
          </div>
          <div class="form-group mb-3">
            <label for="close">Close</label>
            <input type="time" name="close" class="form-control" id="close"
              placeholder="Close" value="{{ old('close') }}">
          </div>

          <div class="list-group p-3">
            <label for="operational-day">Operational Days</label>
            <div class="row row-cols-4">
              @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $item)
                <div class="col-12 col-md-3">
                  <div class="form-check form-check-inline">
                    <label class="form-check-label" for="{{ $item }}">
                      <input class="form-check-input daily" type="checkbox" name="daily[]"
                        value="{{ $item }}" id="{{ $item }}">
                      {{ $item }}
                    </label>
                  </div>
                </div>
              @endforeach
              <div class="col-12 col-md-3">
                <div class="form-check form-switch">
                  <label class="form-check-label" for="all-day">
                    <input class="form-check-input" type="checkbox" id="all-day">
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
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script
    src="{{ asset('assets/vendors/file-upload-with-image-preview/file-upload-with-preview.iife.js') }}">
  </script>


  {{-- map --}}
  <script>
    var map = L.map('map').setView([-2.8994298, 107.9140491], 10);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    const lat = document.getElementById('latitude')
    const long = document.getElementById('longitude')
    const checkCoordinate = document.getElementById('check-coordinate')

    let latitude = 0;
    let longitude = 0;

    lat.addEventListener('change', (e) => {
      latitude = e.target.value
    })

    long.addEventListener('change', (e) => {
      longitude = e.target.value
    })

    let icon = L.divIcon({
      className: "mdi mdi-map-marker",
      style: "color: blue"
    })
    let marker = L.marker([latitude, longitude]).addTo(map);

    checkCoordinate.addEventListener('click', () => {
      map.removeLayer(marker)
      map.flyTo([latitude, longitude, 8])
      marker = L.marker([latitude, longitude]).addTo(map);
    })

    // map.on('click', onMapClick);

    map.on('click', function(e) {
      map.removeLayer(marker)

      latitude = e.latlng.lat
      longitude = e.latlng.lng

      lat.value = e.latlng.lat
      long.value = e.latlng.lng

      marker = L.marker(e.latlng).addTo(map);
    });
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
    const Events = FileUploadWithPreview.Events
    let input = document.getElementById("file-upload-with-preview-my-unique-id")
    input.setAttribute('name', 'image[]')

    const dataTranfer = new DataTransfer()

    input.addEventListener('change', (e) => {
      e.target.files = dataTranfer.files
    })

    window.addEventListener(Events.IMAGE_ADDED, (e) => {
      for (let index = 0; index < e.detail.cachedFileArray.length; index++) {
        const file = e.detail.cachedFileArray[index];

        dataTranfer.items.add(file)
      }
    })
  </script>

  {{-- daily check box --}}
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
