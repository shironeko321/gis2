// filter category
const categoryFilterInput = document.querySelectorAll('.category')
const openModalCategoryFilter = document.getElementById('openmodal')
const filtercategory = document.getElementById('filtercategory')

const myModal = new bootstrap.Modal(filtercategory, {})
openModalCategoryFilter.addEventListener('change', openModalCategoryFillter)

function openModalCategoryFillter() {
    if (openModalCategoryFilter.checked) {
        myModal.show()
        categoryFilterInput.forEach(input => {
            input.checked = false
        })
    } else {
        myModal.hide()
        renderAllMap(markers)
    }
}

const filterButton = document.getElementById('filter')
filterButton.addEventListener('click', getCategoryFilterValue)
filtercategory.addEventListener('hidden.bs.modal', event => {
    getCategoryFilterValue()
})

function getCategoryFilterValue() {
    let category = []
    //   get all value from input
    categoryFilterInput.forEach(input => {
        if (input.checked) {
            category.push(input.value)
        }
    })

    if (category.length > 0) {
        filterMap(category)
    } else {
        openModalCategoryFilter.checked = false
        renderAllMap(markers)
    }
    myModal.hide()
}

// param category is array
function filterMap(category) {
    // Get the current markers array and filter marker
    let markersArray = markers.filter(marker => {
        if (category.includes(marker.category.name)) {
            return marker
        }
    })

    // Remove all markers from the map
    map.removeLayer(markersLayerGroup);

    // Add the filtered markers to a new layer group
    markersLayerGroup = L.layerGroup().addTo(map);

    // render marker
    renderAllMap(markersArray)
}
// end filteer category
