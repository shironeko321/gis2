@extends('layout.dashboard', ['active' => 'map'])

@push('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

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
                <input type="text" name="longtitude" class="form-control"
                  id="exampleInputUsername1" placeholder="Longtitude" value="{{ old('longtitude') }}">
              </div>
              <div class="form-group">
                <label for="exampleInputUsername1">Name</label>
                <input type="text" name="name" class="form-control" id="exampleInputUsername1"
                  placeholder="Name" value="{{ old('name') }}">
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card mb-3">
      <div class="card-body">
        <p class="card-description">Images</p>
        <div id="img-preview" class="overflow-auto"></div>
        <div class="forms-sample mt-3">
          <div class="form-group">
            <label for="exampleInputUsername1">Image Upload</label>
            <input type="file" name="image[]" class="form-control" id="image"
              placeholder="Image Updload" multiple>
          </div>
        </div>
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
            <input type="time" name="open" class="form-control" id="exampleInputUsername1"
              placeholder="Open" value="{{ old('open') }}">
          </div>
          <div class="form-group mb-3">
            <label for="exampleInputUsername1">Close</label>
            <input type="time" name="close" class="form-control" id="exampleInputUsername1"
              placeholder="Close" value="{{ old('close') }}">
          </div>

          <div class="list-group text-bg-secondary p-3">
            <label for="operational-day">Operational Days</label>
            <div class="row row-cols-4 px-5">
              @foreach (['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'] as $item)
                <div class="col-12 col-md-3">
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="daily[]"
                      value="{{ $item }}" id="{{ $item }}">
                    <label class="form-check-label" for="{{ $item }}">
                      {{ $item }}
                    </label>
                  </div>
                </div>
              @endforeach
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

  <script>
    let image = document.getElementById('image')
    let preview = document.getElementById('img-preview')

    image.addEventListener('change', (e) => {
      preview.textContent = "";

      preview.classList.add('d-flex', 'flex-column', 'bg-secondary', 'w-100', 'p-3',
        'border-rounded', 'gap-3')
      preview.style = '--bs-bg-opacity: .5;'

      const child = document.createElement('div');
      child.classList.add('d-inline-flex', 'gap-3')

      const span = document.createElement('span');
      span.innerText = 'Preview'

      preview.append(span)
      preview.append(child)

      const length = e.target.files.length
      for (let index = 0; index < length; index++) {
        let reader = new FileReader();
        reader.onload = function() {
          const div = document.createElement('div');
          div.classList.add('card')

          const img = document.createElement('img');
          img.classList.add('card-img-top')
          img.style = 'height: 150px;width:150px;'
          img.src = reader.result;

          div.append(img)
          child.append(div)
        };
        reader.readAsDataURL(e.target.files[index]);
      }
    })
  </script>
@endpush
