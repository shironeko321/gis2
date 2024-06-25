@extends('layout.dashboard')

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
    {{-- map --}}
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

    {{-- images --}}
    <div class="card mb-3">
      <div class="card-body">
        <div class="custom-file-container" data-upload-id="my-unique-id"></div>
      </div>
    </div>

    {{-- description --}}
    <div class="card mb-3">
      <div class="card-body">
        <p class="card-description">Description</p>
        <div class="forms-sample">
          <div class="form-floating mb-3">
            <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea2"
              style="height: 100px">{{ old('description') }}</textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
          <div class="row">
            <div class="col-10 form-group mb-3">
              <label for="exampleInputUsername1">Category</label>
              <select class="form-select" name="category" aria-label="Default select example">
                <option selected disabled>Open this select category</option>
                @foreach ($category as $item)
                  <option value="{{ $item->id }}" @selected(old('category') == $item->id)>{{ $item->name }}
                  </option>
                @endforeach
              </select>
            </div>
            <div class="col-2 d-flex align-items-center justify-content-end">
              <a href="{{ route('category.create') }}" class="btn btn-primary">Create</a>
            </div>
          </div>
          <div class="form-group">
            <label for="address">Address</label>
            <input type="text" name="address" class="form-control" id="address"
              placeholder="address" value="{{ old('address') }}">
          </div>
          <div class="form-group">
            <label for="website">website</label>
            <input type="text" name="website" class="form-control" id="website"
              placeholder="website" value="{{ old('website') }}">
          </div>
        </div>
      </div>
    </div>

    {{-- operational time --}}
    <div class="card mb-3">
      <div class="card-body">
        <p class="card-description">Daily Operational</p>
        <table class="table">
          <thead class="table-primary">
            <th>Daily</th>
            <th>Open</th>
            <th>Close</th>
          </thead>
          <tbody>
            <tr>
              <td>
                <div class="form-check form-switch ms-5">
                  <input class="form-check-input -ms-1 daily" type="checkbox" id="allday">
                  <label class="form-check-label ms-3" for="allday">
                    all day
                  </label>
                </div>
              </td>
              <td>
                <input type="time" class="form-control open" disabled id="openallday"
                  placeholder="Open">
              </td>
              <td>
                <input type="time" class="form-control close" disabled id="closeallday"
                  placeholder="Close"">
              </td>
            </tr>
          </tbody>
        </table>

        <hr>

        <table class="table">
          <thead class="table-primary">
            <th>Daily</th>
            <th>Open</th>
            <th>Close</th>
          </thead>
          <tbody>
            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $item)
              <tr>
                <td>
                  <div class="form-check form-switch ms-5">
                    <input class="form-check-input -ms-1 daily" type="checkbox"
                      name="daily[{{ $item }}]" value="{{ $item }}"
                      id="{{ $item }}" @checked(old('daily')[$item] ?? '' == $item)>
                    <label class="form-check-label ms-3" for="{{ $item }}">
                      {{ ucfirst(trans($item)) }}
                    </label>
                  </div>
                </td>
                <td>
                  <input type="time" name="open[{{ $item }}]" class="form-control open"
                    disabled id="open" placeholder="Open"
                    value="{{ old('open')[$item] ?? '' }}">
                </td>
                <td>
                  <input type="time" name="close[{{ $item }}]"
                    class="form-control close" disabled id="close" placeholder="Close"
                    value="{{ old('close')[$item] ?? '' }}">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
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

    let latitude = {{ old('latitude') ?? 0 }};
    let longitude = {{ old('longitude') ?? 0 }};

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
    const allday = document.querySelector('#allday')
    const openallday = document.querySelector('#openallday')
    const closeallday = document.querySelector('#closeallday')

    const daily = document.querySelectorAll('.daily')

    allday.addEventListener('change', (e) => {
      if (e.target.checked) {
        daily.forEach((element, i) => {
          const open = document.querySelectorAll('.open')[i]
          const close = document.querySelectorAll('.close')[i]

          element.checked = true
          open.disabled = false
          close.disabled = false
        })
      }
    })

    openallday.addEventListener('change', (e) => {
      daily.forEach((element, i) => {
        const open = document.querySelectorAll('.open')[i]
        open.value = e.target.value
      })
    })

    closeallday.addEventListener('change', (e) => {
      daily.forEach((element, i) => {
        const close = document.querySelectorAll('.close')[i]
        close.value = e.target.value
      })
    })


    daily.forEach((element, i) => {
      const open = document.querySelectorAll('.open')[i]
      const close = document.querySelectorAll('.close')[i]

      if (element.checked) {
        open.disabled = false
        close.disabled = false
      }

      element.addEventListener('change', (e) => {
        if (e.target.checked) {
          open.disabled = false
          close.disabled = false
        } else {
          open.disabled = true
          close.disabled = true
        }
      })
    });
  </script>
@endpush
