
//Map
var mymap = L.map('mapid').setView([51.505, -0.09], 13);

function ShowMap(){	
	//affichage de la map
	L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
        attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
        maxZoom: 18,
        id: 'mapbox/streets-v11',
        tileSize: 512,
        zoomOffset: -1,
        accessToken: 'pk.eyJ1IjoiYWxkb3JhbCIsImEiOiJja213MWpoeGwwYWtlMnV1dGllYjQ4Y3Y1In0.1Z59U9T8LvXeEV9eA9CKvg'
    }).addTo(mymap);
}


//Markers
var LeafIcon = L.Icon.extend({
    options: {
        iconSize:     [38, 95],
        iconAnchor:   [22, 94],
        popupAnchor:  [-3, -76]
    }
});
var greenIcon = new LeafIcon({iconUrl: 'img/markerVert.png'}),
    orangeIcon = new LeafIcon({iconUrl: 'img/markerRouge.png'}),
    redIcon = new LeafIcon({iconUrl: 'img/markerOrange.png'});

function PlacerEmplacements(markers){
    markers.forEach((unMarker, index) => {
        NouvelEmplacement(markers[0], markers[1], markers[1], markers[1]);
    })
}
function NouvelEmplacement(iterations, latitude, longitude, infos){
    if(iterations <= 5){
        L.marker([latitude, longitude], {icon: greenIcon}).addTo(map).bindPopup(infos);
    }
    else if(iterations <= 10){
        L.marker([latitude, longitude], {icon: orangeIcon}).addTo(map).bindPopup(infos);
    }
    else{
        L.marker([latitude, longitude], {icon: redIcon}).addTo(map).bindPopup(infos);
    }
}
