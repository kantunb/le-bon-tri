window.onload = function () {




    const mapboxTiles = L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}.png", {
            attribution: '<a href="https://carto.com" target="_blank">Tiles source : CARTO</a>',
        }
    );

    const map = L.map("map")
        .addLayer(mapboxTiles)
        // .fitWorld()
        .setView([45.7673014, 4.8315513], 12)
        .locate({
            setView: true,

            maxZoom: 17

        });

    function onLocationFound(e) {
        const localisationIconBack = L.divIcon({
            className: 'pinGeolocalisationBack',
            iconSize: [24, 24]
        })
        L.marker(e.latlng, {
            icon: localisationIconBack,
        }).addTo(map)
        const localisationIcon = L.divIcon({
            className: 'pinGeolocalisation',
            iconSize: [14, 14]
        })
        L.marker(e.latlng, {
            icon: localisationIcon
        }).addTo(map)

    }

    map.on('locationfound', onLocationFound);

    function onLocationError(e) {
        alert(e.message);
    }

    // map.on('locationerror', onLocationError);

    showLayers();

    // Geocoding by adress

    const searchGeocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            position: "topleft",
            placeholder: "Code postal ou adresse...",
        })
        .on('markgeocode', function (e) {
            map.flyTo(e.geocode.center, 16);
        })
        .addTo(map);

    // Geocoding by button

    var centerButton = L.control({
        position: 'topleft'
    });

    centerButton.onAdd = function (map) {
        this._div = L.DomUtil.create('div', 'leaflet-control-geocoder leaflet-bar leaflet-control');
        var img_log = "<button id=\"centerButton\"class=\"leaflet-control-geocoder-icon\"></button>";
        this._div.innerHTML = img_log;
        return this._div;
    }

    centerButton.addTo(map);

    $("#centerButton").on("click", /*TODO : add function*/ )

    function showLayers() {

        const layers = [];

        const lyonJSONs = [{
                name: "Silos",
                categorie: "silos",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gic_collecte.gicsiloverre&outputFormat=application/json; subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/verre-pin.png",
            },
            {
                name: "Déchèteries",
                categorie: "dechet",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gip_proprete.gipdecheterie_3_0_0&outputFormat=application/json;%20subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/decheterie-pin.png",
            },
            {
                name: "Donneries",
                categorie: "donnerie",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gip_proprete.gipdonnerie_3_0_0&outputFormat=application/json; subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/donnerie-pin.png",
            },
            {
                name: "Bornes Vêtements",
                categorie: "borne",
                url: assetsBaseDir + "/json/le-relais.json",
                icon: assetsBaseDir + "/img/icon/1x/textile-pin.png",
            }
        ];

        
        for (let lyonJSON of lyonJSONs) {

            const datas = $('#datas');

            if(datas.attr("data-collectionpointtype") == lyonJSON.name) {
                
                const categoryIcon = new L.Icon({
                    iconUrl: lyonJSON.icon,
                    // shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
                    iconSize: [30, 41],
                    // shadowSize: [41, 41],
                    iconAnchor: [12, 41],
                    popupAnchor: [1, -34],
                });
    
                let idCategory = lyonJSON.categorie;
    
                // Import depuis les API du contenu des popups
                function onEachFeature(feature, layer) {
                    if (feature.properties &&
                        feature.properties.type_decheterie &&
                        feature.properties.type_decheterie != null) {
                        layer.bindPopup(feature.properties.type_decheterie);
                    } else if (
                        feature.properties &&
                        feature.properties.observation &&
                        feature.properties.observation != null) {
                        layer.bindPopup(feature.properties.observation);
                    } else {
                        layer.bindPopup("Pas d'information");
                    }
                }
    
                const promise = $.getJSON(lyonJSON.url);
    
                promise.then(function (data) {
    
                    lyonJSON.categorie = L.geoJson(data, {
    
                        onEachFeature: onEachFeature,
    
                        pointToLayer: function (feature, latlng) {
                            return L.marker(latlng, {
                                icon: categoryIcon
                            })
                        },
                    });
    
                    /* Regroupement des type de lieux par cluster */
                    const markersClusterCategory = new L.MarkerClusterGroup();
    
                    markersClusterCategory.addLayer(lyonJSON.categorie);
    
                    markersClusterCategory.addTo(map);
    
                    // Création des boutons avec un id qui utilise lyonJSON.categorie et le texte lyonJSON.name
    
                    const buttonsContainer = document.getElementById('buttonsContainer');
    
                    const buttonCategory = document.createElement('BUTTON'); // Créer un élément <button>
                    const labelButton = document.createTextNode(lyonJSON.name); // Créer un noeud textuel
                    const checkboxCategory = document.createElement('input'); // Créer un élément <button>
                    checkboxCategory.type = 'checkbox';
    
                    buttonCategory.appendChild(labelButton); // Ajouter le texte au bouton
                    buttonsContainer.appendChild(buttonCategory);
                    buttonCategory.appendChild(checkboxCategory);
                    buttonCategory.id = idCategory;
                    buttonCategory.className = "mapButton";
                    checkboxCategory.className = "mapButton";
                    checkboxCategory.checked = true;
    
                    layers.push(markersClusterCategory);
    
                    // Gestion des boutons grace aux IDs, peut être relier l'ID au layer
    
                    $(`#${idCategory}`).click(function () {
                        if (map.hasLayer(markersClusterCategory)) {
                            $(this).children().prop("checked", false)
                            map.removeLayer(markersClusterCategory);
                        } else {
                            map.addLayer(markersClusterCategory);
                            $(this).children().prop("checked", true)
                        }
                    })
                });
            }
        }

        // Gestion du bouton #addRemoveAll

        $("#addRemoveAll").click(function () {
            $(this).toggleClass("selected");
            if ($(this).hasClass("selected")) {
                $(this).children("#titleButton").text("Tout masquer");
                for (const layer of layers) {
                    map.addLayer(layer);
                    $(".mapButton").prop("checked", true);
                }
            } else {
                for (const layer of layers) {
                    $(this).children("#titleButton").text("Tout afficher");
                    map.removeLayer(layer);
                    $(".mapButton").prop("checked", false);
                }
            }
        })
    }
}