var mymap = L.map('mapHome').setView([47.80949, 13.05501], 14);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token={accessToken}', {
    attribution: 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox.streets',
    accessToken: 'pk.eyJ1Ijoic29waGllbXJpZSIsImEiOiJjamdmNXMxaWw0bXdkMnd0NTA2enM5d2YzIn0.lRBm0ek-aotIfhwTJxPe1g'
}).addTo(mymap);

var popup = L.popup();



var greenIcon = new L.Icon({
    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});

var orangeIcon = new L.Icon({
    iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-orange.png',
    shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
    iconSize: [25, 41],
    iconAnchor: [12, 41],
    popupAnchor: [1, -34],
    shadowSize: [41, 41]
});







var altstadt = [47.800018, 13.042874];
var neustadt = [47.807033, 13.040297];
var muelln = [47.806237, 13.031855];
var riedenburg = [47.796085, 13.029383];
var nonntal = [47.791328, 13.050452];
var maxglan = [47.804081, 13.018549];
var lehen = [47.813258, 13.02759];
var liefering = [47.825891, 13.009102];
var aigen = [47.791492, 13.08369];
var parsch = [47.800703, 13.077718];
var gnigl = [47.813506, 13.069087];
var itzling = [47.82403, 13.047998];
var elisabethvorstadt = [47.815016, 13.039451];
var morzg = [47.770588, 13.055239];
var gneis = [47.778951, 13.040047];
var leopoldskronermoos = [47.775894, 13.022957];
var salzburgsued = [47.770397, 13.078833];
var langwied = [47.824866, 13.097789];
var kasern = [47.838371, 13.065306];
var taxham = [47.811466, 13.004066];
var schallmoos = [47.811391, 13.055753];

var stadtteile = [altstadt, neustadt,muelln, riedenburg, nonntal, maxglan, lehen, liefering,
    aigen, parsch, gnigl, itzling, elisabethvorstadt, morzg, gneis, leopoldskronermoos, salzburgsued, kasern, taxham, schallmoos];


var stadtteilestring = ["altstadt", "neustadt","muelln", "riedenburg", "nonntal", "maxglan", "lehen", "liefering",
    "aigen", "parsch", "gnigl", "itzling", "elisabethvorstadt", "morzg", "gneis", "leopoldskronermoos", "salzburgsued", "kasern", "taxham", "schallmoos"];




a.forEach(function(element) {
    var id = element[2];
    for(var i = 0; i < stadtteile.length; i++) {
        if (element[0] == stadtteilestring[i]) {
            if (element[1] == "anfaenger") {
                L.marker(stadtteile[i], {icon: greenIcon}).addTo(mymap).on('click', onClick);
            }
            else if (element[1] == "fortgeschritten") {
                L.marker(stadtteile[i], {icon: orangeIcon}).addTo(mymap).on('click', onClick);
            }
            else {
                L.marker(stadtteile[i]).addTo(mymap).on('click', onClick);
            }
        }
    }


    function onClick(e) {
        window.location.href = "laeuferkarte.php?id="+id;
    }


});







