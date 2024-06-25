// start setup mqp
let map = L.map('map', {
    maxZoom: 20,
    minZoom: 6,
    zoomControl: false
})
    .setView([-2.8994298, 107.9140491], 10)
    .locate({
        setView: true,
        maxZoom: 16
    });

L.control.zoom({
    position: 'bottomright'
})
    .addTo(map);

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '© OpenStreetMap'
}).addTo(map);

let markersLayerGroup = L.layerGroup().addTo(map);

// map
function renderAllMap(m) {
    // set marker
    m.forEach(marker => {
        // icon
        let myIcon = L.divIcon({
            html: `<i class="fa fa-map-marker fa-3x" style="color: ${marker.category.color}"></i>`,
            iconSize: [27, 36],
            iconAnchor: [13.5, 36],
            popupAnchor: [0, -36],
            className: 'myDivIcon',
        });

        // set mark
        let mark = L.marker([marker.latitude, marker.longitude], {
            icon: myIcon
        }).bindTooltip(marker.name, {
            permanent: true,
            direction: 'right'
        })

        // mark event
        mark.on('click', (e) => markClick(e, marker))

        // add mark to layer
        markersLayerGroup.addLayer(mark);
    });
}

function markClick(e, marker) {
    const {
        lat,
        lng
    } = e.latlng
    mapFocus(lat, lng)

    setDetailDestination(marker)
}

function mapFocus(latitude, longitude) {
    map.setView([latitude, longitude], 15);
}

function setDetailDestination(marker) {
    // set bootstrap offcanvas
    const detail = document.getElementById('detail')
    const bsOffcanvas = new bootstrap.Offcanvas(detail)

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

    console.log(marker);

    // add image to caousel
    marker.image.forEach((img, index) => {
        console.log(img);
        let div = document.createElement('div')
        div.setAttribute('class', `carousel-item ${index === 0 && 'active'}`)

        let image = document.createElement('img')
        // image.setAttribute('src', `${imageBaseUrl}/${img.name}`)
        image.setAttribute('src', `${img.name}`)
        image.setAttribute('class', 'd-block w-100')
        image.setAttribute('style', 'height: 200px')

        div.append(image)
        images.append(div)
    });

    // set address
    // const address = document.getElementById('address')
    // address.innerText = marker.details.address

    // set description
    // const description = document.getElementById('description')
    // description.innerText = marker.details.description

    const open = document.getElementById('open')
    open.innerText = ''

    marker.operationaltime.forEach((v) => {
        const li = document.createElement('li')
        li.setAttribute('class', 'list-group-item')
        li.innerText = `${v.day} ${v.open} - ${v.close}`

        open.appendChild(li)
    })

    // open detail
    bsOffcanvas.show()
}

// end map
