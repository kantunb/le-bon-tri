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
            maxZoom: 16
        });

    function onLocationFound(e) {
        const localisationIcon = L.icon({
            iconUrl: 'https://media.giphy.com/media/AwoDg0wJImOjK/giphy.gif',
            iconSize: [60, 60],
            className: 'pin-effect'
        })
        L.marker(e.latlng, {
            icon: localisationIcon
        }).addTo(map)
    }

    map.on('locationfound', onLocationFound);

    function onLocationError(e) {
        alert(e.message);
    }

    map.on('locationerror', onLocationError);

    showLayers();

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

                // Créer automatiquement un bouton avec un id qui utilise lyonJSON.categorie et le texte lyonJSON.name

                const buttonsDiv = document.getElementById('buttons');


                const buttonCategory = document.createElement("BUTTON"); // Créer un élément <button>
                const labelButton = document.createTextNode(lyonJSON.name); // Créer un noeud textuel
                buttonCategory.appendChild(labelButton); // Ajouter le texte au bouton
                buttonsDiv.appendChild(buttonCategory);
                buttonCategory.id = idCategory;
                buttonCategory.className = "btn btn-success m-1";

                layers.push(markersClusterCategory);

                // Gestion des boutons grace aux IDs, peut être relier l'ID au layer

                $(`#${idCategory}`).click(function () {
                    const otherCategoriesLayers = layers.filter(function (e) {
                        return e != markersClusterCategory;
                    })
                    for (otherCategoriesLayer of otherCategoriesLayers) {
                        map.removeLayer(otherCategoriesLayer);
                    }
                    map.addLayer(markersClusterCategory);
                })

            });


        }

        console.log(layers);
        // Gestion des boutons All et Remove grace aux IDs, peut être relier l'ID au layer

        $("#all").on("click", function () {
            for (layer of layers) {
                map.addLayer(layer)
            }
        });


        $("#remove").on("click", function () {
            for (const layer of layers) {
                map.removeLayer(layer)
            }
        });

    }
}