<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Map</title>

  <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css') }}">
  <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">


  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

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
</head>

<body>
  <nav class="navbar bg-transparent position-fixed w-100 d-flex justify-content-center"
    style="z-index: 1000">
    <div class="bg-white p-2 rounded">
      <form class="d-flex" id="search">
        <input class="form-control me-2 form-control-sm border-0" type="text" name="search"
          placeholder="Search" aria-label="Search" list="list">
        <datalist id="list">
          @foreach ($markers as $marker)
            <option value="{{ $marker->name }}" />
          @endforeach
        </datalist>
        <button class="btn btn-sm" type="submit">
          <i class="fa fa-search" aria-hidden="true"></i>
        </button>
      </form>
    </div>
  </nav>

  <div id="map"></div>

  <div class="offcanvas offcanvas-end" tabindex="-1" id="detail"
    aria-labelledby="offcanvasLabel">
    <div class="offcanvas-header">
      <h5 class="offcanvas-title" id="offcanvasLabel">Offcanvas</h5>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
        aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <ul class="list-group list-group-horizontal overflow-auto" id="images">
      </ul>

      <div class="card">
        <div class="card-body p-2">
          <h5 class="card-title">description</h5>
          <p class="card-text" id="description"></p>
        </div>
      </div>

      <div class="card">
        <div class="card-body p-2">
          <h5 class="card-title">Open</h5>
          <p class="card-text" id="open"></p>
        </div>
      </div>
    </div>
  </div>

  <script src="{{ asset('assets/vendors/js/vendor.bundle.base.js') }}"></script>
  <script src="{{ asset('assets/js/off-canvas.js') }}"></script>

  {{-- marker  --}}
  <script>
    var map = L.map('map').setView([-2.8994298, 107.9140491], 10);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '© OpenStreetMap'
    }).addTo(map);

    map.locate({
      setView: true,
      maxZoom: 16
    });

    const markers = {{ Js::from($markers) }};

    const detail = document.getElementById('detail')
    const bsOffcanvas = new bootstrap.Offcanvas(detail)


    markers.forEach(marker => {
      let mark = L.marker([marker.latitude, marker.longitude]).bindTooltip(marker.name, {
        permanent: true,
        direction: 'right'
      }).addTo(map)

      mark.on('click', (e) => {
        map.setView(e.latlng, 15);

        // set title
        const title = document.getElementById('offcanvasLabel')
        title.innerText = marker.name

        // set images
        const images = document.getElementById('images')
        // clear image in list
        images.innerText = ''
        images.scrollTo({
          left: 0
        })
        // add image to list
        marker.image.forEach(img => {
          let li = document.createElement('li')
          li.classList.add('list-group-item')

          let image = document.createElement('img')
          image.setAttribute('src', `{{ asset('storage/images/') }}/${img.name}`)
          image.setAttribute('style', 'width: 200px;')

          li.append(image)
          images.append(li)
        });

        bsOffcanvas.show()
      })

      const description = document.getElementById('description')
      description.innerText = marker.detail.description

      const open = document.getElementById('open')
      open.innerText =
        `${marker.detail.open} - ${marker.detail.close}`
    });

    const search = document.getElementById('search')
    search.addEventListener('submit', (e) => {
      e.preventDefault()

      const input = search.getElementsByTagName('input')[0].value
      //   set url
      const urlParams = new URLSearchParams();
      urlParams.set('search', input);
      history.replaceState(null, null, "?" + urlParams.toString());

      const {
        latitude,
        longitude
      } = markers.filter(item => item.name.toLowerCase().indexOf(input) > -1)[0]
      map.setView([latitude, longitude], 15);
    })
  </script>
</body>

</html>
