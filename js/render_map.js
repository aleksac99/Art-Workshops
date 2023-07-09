const providerOSM = new GeoSearch.OpenStreetMapProvider();

var zoom = (coordinates[0]==0. && coordinates[1]==0.) ? 2 : 15;
var leafletMap = L.map('map', {
minZoom: 2
}).setView(coordinates, zoom);
if (zoom==15) L.marker(coordinates).addTo(leafletMap);

L.tileLayer('http://{s}.tile.osm.org/{z}/{x}/{y}.png', {
attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
}).addTo(leafletMap);


if (showSearchBar) {

    const search = new GeoSearch.GeoSearchControl({
        provider: providerOSM,
        style: 'bar',
        searchLabel: 'Pretrazi',
        showMarker: true,
        marker: {
        icon: new L.Icon.Default(),
        draggable: true,
        },
        autoClose: true,
        keepResult: true,
    });
    
    leafletMap.addControl(search);
}
leafletMap.on('geosearch/showlocation',(result) => {
    
    if (result) {
        var input = document.querySelector('input[name="address"]');
        input.value = result.location.label;
        var inputLong = document.querySelector('input[name="addressLong"]');
        inputLong.value = result.location.y;
        var inputLat = document.querySelector('input[name="addressLat"]');
        inputLat.value = result.location.x;
    }
});
leafletMap.on('geosearch/marker/dragend',(result) => {
    
    if (result) {
        var input = document.querySelector('input[name="address"]');
        input.value = result.location.label;
    }
});