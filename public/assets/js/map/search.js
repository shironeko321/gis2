// search
const search = document.getElementById('search')
const inputsearch = document.getElementById('inputsearch')

inputsearch.addEventListener('change', searchMarker)
search.addEventListener('submit', searchMarker)

function searchMarker(e) {
    e.preventDefault()

    const input = search.getElementsByTagName('input')[0].value
    //   set url
    setUrl('search', input)

    // filter marker by name and get first marker
    const {
        latitude,
        longitude
    } = markers.filter(item => item.name.toLowerCase().indexOf(input) > -1)[0]

    mapFocus(latitude, longitude)
}

function setUrl(key, value) {
    const urlParams = new URLSearchParams();
    urlParams.set(key, value);
    history.replaceState(null, null, "?" + urlParams.toString());
}
// end search
