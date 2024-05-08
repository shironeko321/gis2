@extends('layout.dashboard', ['active' => 'map'])

@push('style')
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

  <style>
    #map {
      height: 350px;
    }
  </style>
@endpush

@section('content')
  <div class="page-header">
    <h3 class="page-title">
      <span class="page-title-icon bg-gradient-primary text-white me-2">
        <i class="mdi mdi-alpha-i"></i>
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

  {{-- map --}}
  <div class="card mb-3">
    <div class="card-body">
      <h4 class="card-title">Detail Map</h4>
      <p class="card-description">Map</p>
      <div>
        <div class="row">
          <div class="col-12 col-md-6">
            <div id="map"></div>
          </div>
          <div class="col-12 col-md-6 px-3">
            <div class="overflow-auto" style="max-height: 350px">
              {{-- image --}}
              <div class="card">
                <div class="card-header">{{ $item->name }}</div>
                <div class="card-body px-2 py-1">
                  @if (count($item->image) > 0)
                    <div class="w-100 d-inline-flex gap-3 bg-secondary overflow-auto p-2">
                      @foreach ($item->image as $img)
                        <img src="{{ asset("storage/images/$img->name") }}" alt="alt"
                          width="200px">
                      @endforeach
                    </div>
                  @endif
                </div>

                {{-- detail --}}
                <div class="card-body px-2">
                  <div class="forms-sample">
                    <div class="form-floating mb-3">
                      <textarea class="form-control" disabled placeholder="Description" style="height: 100px">{{ $item->detail->description }}</textarea>
                      <label>Description</label>
                    </div>

                    <div class="form-group mb-3">
                      <label>Operational Time</label>
                      <div class="row">
                        <div class="col">
                          <label>Open</label>
                          <input type="time" class="form-control" disabled
                            value="{{ $item->detail->open }}">
                        </div>
                        <div class="col">
                          <label>Close</label>
                          <input type="time" class="form-control" disabled
                            value="{{ $item->detail->close }}">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a href="{{ route('map.edit', ['map' => $item->id]) }}" class="btn btn-primary">Update</a>
  </form>
@endsection


@push('script')
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  {{-- map --}}
  <script>
    let latitude = {{ $item->latitude }};
    let longitude = {{ $item->longitude }};

    var map = L.map('map').setView([latitude, longitude], 13);
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(map);

    L.marker([latitude, longitude]).addTo(map);
  </script>
@endpush
