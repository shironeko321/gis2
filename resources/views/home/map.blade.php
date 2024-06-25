@extends('layout.index')

@push('style')
  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

  <script src="{{ asset('assets/js/jquery-3.7.1.min.js') }}"></script>
  <script src="{{ asset('assets/js/bootstrap-autocomplete.min.js') }}"></script>

  <style>
    body {
      padding: 0;
      margin: 0;
    }

    html,
    body,
    #map {
      height: 100%;
      width: 100vw;
    }
  </style>
@endpush



@section('content')
  @include('template.home.headerMap')

  <!-- Modal filter by category -->
  @include('template.home.modalCategoryMap', ['category' => $category])

  <div id="map"></div>

  {{-- navigation --}}
  @include('template.home.sidebarMap')

  {{-- detail --}}
  @include('template.home.detailMap')
@endsection

@push('script')
  {{-- setup --}}
  <script>
    const imageBaseUrl = "{{ asset('storage/images/') }}"
    const markers = {{ Js::from($markers) }};
  </script>

  <script src="{{ asset('assets/js/map/map.js') }}" defer></script>
  <script src="{{ asset('assets/js/map/search.js') }}" defer></script>
  <script src="{{ asset('assets/js/map/filter-category.js') }}" defer></script>

  <script defer>
    // autocomplete
    document.addEventListener('DOMContentLoaded', e => {
      $('#inputsearch').autocomplete()

      // add mark to map
      renderAllMap(markers)
    }, false);
  </script>
@endpush
