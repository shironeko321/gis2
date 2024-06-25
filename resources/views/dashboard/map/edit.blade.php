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

{{-- @dd($item) --}}

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-pen"></i>
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

  <form action="{{ route('map.update', ['map' => $item->id]) }}" method="POST"
    enctype="multipart/form-data">
    @csrf
    @method('put')
    {{-- map --}}
    <div class="card mb-3">
      <div class="card-body">
        <h4 class="card-title">Edit Map</h4>
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
                  placeholder="Latitude" value="{{ $item->latitude }}" step="any">
              </div>
              <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="number" name="longitude" class="form-control" id="longitude"
                  placeholder="Longitude" value="{{ $item->longitude }}" step="any">
              </div>
              <div class="form-group">
                <label for="name">Name</label>
                <input type="text" name="name" class="form-control" id="name"
                  placeholder="Name" value="{{ $item->name }}">
              </div>
              <button type="button" class="btn btn-primary" id="check-coordinate">Check
                Coordinate</button>
            </div>
          </div>
        </div>
      </div>
    </div>

    {{-- image --}}
    <div class="card mb-3">
      <div class="card-body">
        @if (count($item->image) > 0)
          <div class="w-100 d-inline-flex gap-3 bg-secondary overflow-auto p-2">
            @foreach ($item->image as $img)
              <div class="card text-bg-dark">
                <img src="{{ asset("storage/images/$img->name") }}" alt="alt" width="200px">
                <div class="card-img-overlay">
                  <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal"
                    data-bs-target="#image-delete-{{ $img->id }}">
                    <i class="mdi mdi-delete"></i>
                  </button>
                </div>
              </div>
            @endforeach
          </div>
        @endif
        <div class="custom-file-container" data-upload-id="my-unique-id"></div>
      </div>
    </div>

    {{-- detail --}}
    <div class="card mb-3">
      <div class="card-body">
        <p class="card-description">Description</p>
        <div class="forms-sample">
          <div class="form-floating mb-3">
            <textarea class="form-control" name="description" placeholder="Description" id="floatingTextarea2"
              style="height: 100px">{{ $item->detail->description }}</textarea>
            <label for="floatingTextarea2">Description</label>
          </div>
          <div class="row">
            <div class="col-10 form-group mb-3">
              <label for="exampleInputUsername1">Category</label>
              <select class="form-select" name="category" aria-label="Default select example">
                <option selected disabled>Open this select category</option>
                @foreach ($category as $cat)
                  <option value="{{ $cat->id }}" @selected($item->category_id == $cat->id)>
                    {{ $cat->name }}
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
              placeholder="address" value="{{ $item->detail->address }}">
          </div>
          <div class="form-group">
            <label for="website">website</label>
            <input type="text" name="website" class="form-control" id="website"
              placeholder="website" value="{{ $item->detail->website }}">
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
            `@php
              use Illuminate\Support\Arr;
              $dayactive = Arr::pluck($item->operationaltime, 'day');
              $openactive = Arr::pluck($item->operationaltime, 'open');
              $closeactive = Arr::pluck($item->operationaltime, 'close');
            @endphp

            @foreach (['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
              @php
                $checked = in_array($day, $dayactive);
                $open = $openactive[array_search($day, $dayactive)] ?? '';
                $close = $closeactive[array_search($day, $dayactive)] ?? '';
              @endphp
              <tr>
                <td>
                  <div class="form-check form-switch ms-5">
                    <input class="form-check-input -ms-1 daily" type="checkbox"
                      name="daily[{{ $day }}]" value="{{ $day }}"
                      id="{{ $day }}" @checked($checked)>
                    <label class="form-check-label ms-3" for="{{ $day }}">
                      {{ ucfirst(trans($day)) }}
                    </label>
                  </div>
                </td>
                <td>
                  <input type="time" name="open[{{ $day }}]" class="form-control open"
                    disabled id="open" placeholder="Open"
                    value="{{ $checked ? $open : '' }}">
                </td>
                <td>
                  <input type="time" name="close[{{ $day }}]"
                    class="form-control close" disabled id="close" placeholder="Close"
                    value="{{ $checked ? $close : '' }}">
                </td>
              </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
  </form>

  {{-- image delete --}}
  @foreach ($item->image as $img)
    <div class="modal fade" id="image-delete-{{ $img->id }}" tabindex="-1"
      aria-labelledby="label" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Delete</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <p>are you sure delete this image?</p>
          </div>
          <form action="{{ route('map.deleteImage', ['id' => $img->id]) }}" method="POST"
            class="modal-footer">
            @csrf
            @method('delete')
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-danger">Delete</button>
          </form>
        </div>
      </div>
    </div>
  @endforeach
@endsection


@push('script')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
  <script
    src="{{ asset('assets/vendors/file-upload-with-image-preview/file-upload-with-preview.iife.js') }}">
  </script>

  {{-- map --}}
  <script>
    let latitude = {{ $item->latitude }};
    let longitude = {{ $item->longitude }};

    var map = L.map('map').setView([latitude, longitude], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);


    const lat = document.getElementById('latitude')
    const long = document.getElementById('longitude')
    const checkCoordinate = document.getElementById('check-coordinate')


    lat.addEventListener('change', (e) => {
      latitude = e.target.value
    })

    long.addEventListener('change', (e) => {
      longitude = e.target.value
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
    const daily = document.querySelectorAll('.daily')

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
