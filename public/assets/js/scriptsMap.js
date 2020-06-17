window.onload = function(e) {

    const mapTiles = L.tileLayer(
        "https://{s}.basemaps.cartocdn.com/rastertiles/voyager_labels_under/{z}/{x}/{y}.png", {
            attribution: '<a href="https://carto.com" target="_blank">Tiles source : CARTO</a>',
        }
    );

    const map = L.map("map")
        .addLayer(mapTiles)
        // .fitWorld()
        .setView([45.7673014, 4.8315513], 12)
        .locate({
            setView: true,
            maxZoom: 17
        });

        map.zoomControl.setPosition('bottomright');

    /*********** If localisation ok, add a marker and add a position button ***********/

    function onLocationFound(e) {

        const localisationIconBack = L.divIcon({
            className: 'pinGeolocalisationBack',
            iconSize: [24, 24]
        })

        const localisationIcon = L.divIcon({
            className: 'pinGeolocalisation',
            iconSize: [14, 14]
        })

        const centerButton = L.control({
            position: 'bottomright'
        });

        L.marker(e.latlng, {
            icon: localisationIconBack,
        }).addTo(map)

        L.marker(e.latlng, {
            icon: localisationIcon
        }).addTo(map)

        centerButton.onAdd = function (map) {
            this.div = L.DomUtil.create('div', 'leaflet-control-geocoder leaflet-bar leaflet-control');
            const positionButton = "<button id=\"centerButton\"class=\"leaflet-control-geocoder-icon\"></button>";
            this.div.innerHTML = positionButton;
            return this.div;
        };

        centerButton.addTo(map);

        const centerBtn = $("#centerButton")

        centerBtn.on("click", function (e) {
            // Fonction pour retrouver la latitude et la longitude, puis centrer la carte :
            navigator.geolocation.getCurrentPosition(function (location) {
                var latlng = new L.LatLng(location.coords.latitude, location.coords.longitude);
                // localisationIcon.setLatLng(latlng);
                // localisationIconBack.setLatLng(latlng);
                map.flyTo(latlng, 17);
            });
        })
    }

    map.on('locationfound', onLocationFound);

    function onLocationError(e) {
        centerBtn.style.display = "none";
        const message = "Nous n'avons pas pu vous localiser";
        console.log(message);
    }

    map.on('locationerror', onLocationError);

    showLayers();

    /*********** Geocoding by adress ***********/

    const searchGeocoder = L.Control.geocoder({
            defaultMarkGeocode: false,
            position: "topright",
            placeholder: "Code postal ou adresse...",
        })
        .on('markgeocode', function (e) {
            map.flyTo(e.geocode.center, 16);
        })
        .addTo(map);


    /*********** Layers builder ***********/

    const layers = [];

    function layersBuilders(lyonJSON) {

        // console.log(lyonJSON.id_Json);

        const categoryIcon = new L.Icon({
            iconUrl: lyonJSON.icon,
            // shadowUrl: "https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png",
            iconSize: [30, 41],
            // shadowSize: [41, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34],
        });

        let idCategory = lyonJSON.categorie;
        let jsonName;

        // Import depuis les API du contenu des popups

        function onEachFeature(feature, marker) {

            switch (jsonName) {
                case "gic_collecte.gicsiloverre":
                    marker.bindPopup(
                        "<h5>Silo à verre</h5><table class=\"tableMap\"><tr><th>Adresse :</th><td>" +
                        feature.properties.voie + "<br />" +
                        feature.properties.code_postal + " " +
                        feature.properties.commune + "</td></tr><tr><th>Commentaire :</th><td>" +
                        feature.properties.observation + "</td></tr></table>");
                    break;
                case "gip_proprete.gipdecheterie_3_0_0":
                    let allowed_wastes = [];
                    for (let id of feature.properties.allowed_waste) {
                        allowed_wastes.push(id["schema:category"]);
                    }
                    marker.bindPopup(
                        "<h5>Déchèterie " +
                        feature.properties.type_decheterie + " de " +
                        feature.properties.nom + "</h5><table class=\"tableMap\"><tr><th>Adresse :</th><td>" +
                        feature.properties.address.streetAddress + "<br />" +
                        feature.properties.address.postalCode + " " +
                        feature.properties.address.addressLocality + "</td></tr><tr><th>Déchets acceptés :</th><td>" +
                        allowed_wastes.join('<br />') + "</td></tr></table>");
                    break;
                case "gip_proprete.gipdonnerie_3_0_0":
                    let allowed_donations = [];
                    for (let id of feature.properties.allowed_waste) {
                        allowed_donations.push(id["schema:category"]);
                    }
                    marker.bindPopup(
                        "<h5>Donnerie de " +
                        feature.properties.nom + "</h5><table class=\"tableMap\"><tr><th>Adresse :</th><td>" +
                        feature.properties.address.streetAddress + "<br />" +
                        feature.properties.address.postalCode + " " +
                        feature.properties.address.addressLocality + "</td></tr><tr><th>Dons acceptés :</th><td>" +
                        allowed_donations.join('<br />') + "</td></tr></table>");
                    break;
                case "Le_relais":
                    marker.bindPopup(
                        "<h5>Borne à vêtements de " +
                        feature.properties.name + "</h5>");
                    // + "<table class=\"tableMap\"><tr><th>Commentaire :</th><td>" + feature.properties.content + "</td></tr></table>")
                    break;
                default:
                    marker.bindPopup("Pas d'information");
            }
        }

        const promise = $.getJSON(lyonJSON.url, function (json) {
            jsonName = json.name;
        });

        promise.then(function (data) {

            lyonJSON.categorie = L.geoJson(data, {

                onEachFeature: onEachFeature,

                pointToLayer: function (feature, latlng) {
                    return L.marker(latlng, {
                        icon: categoryIcon
                    })
                },
            });

            /**** Regroupement des type de lieux par cluster ****/
            const markersClusterCategory = new L.MarkerClusterGroup();

            markersClusterCategory.addLayer(lyonJSON.categorie);

            markersClusterCategory.addTo(map);

            /**** Création des boutons avec un id qui utilise lyonJSON.categorie et le texte lyonJSON.name ****/

            const buttonsContainer = document.getElementById('buttonsContainer');

            const buttonCategory = document.createElement('button');
            const labelButton = document.createTextNode(lyonJSON.name);
            const spanLabelButton = document.createElement('span');
            const checkboxCategory = document.createElement('input');
            const imgCategory = document.createElement('img');
            imgCategory.src = lyonJSON.icon;
            checkboxCategory.type = 'checkbox';

            buttonCategory.appendChild(checkboxCategory);
            buttonCategory.appendChild(imgCategory);
            buttonCategory.appendChild(spanLabelButton);
            spanLabelButton.appendChild(labelButton);
            buttonsContainer.appendChild(buttonCategory);
            buttonCategory.id = idCategory;
            imgCategory.className = "legendIcon";
            buttonCategory.className = "mapButton";
            checkboxCategory.className = "mapButton";
            checkboxCategory.checked = true;

            layers.push(markersClusterCategory);

            /**** Gestion des boutons grace aux IDs, peut être relier l'ID au layer ****/

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

    function showLayers() {

        const lyonJSONs = [{
                name: "Silos",
                categorie: "silo",
                id_Json: "gic_collecte.gicsiloverre",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gic_collecte.gicsiloverre&outputFormat=application/json; subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/verre-pin.png",
            },
            {
                name: "Déchèteries",
                categorie: "decheterie",
                id_Json: "gip_proprete.gipdecheterie_3_0_0",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gip_proprete.gipdecheterie_3_0_0&outputFormat=application/json;%20subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/decheterie-pin.png",
            },
            {
                name: "Donneries",
                categorie: "donnerie",
                id_Json: "gip_proprete.gipdonnerie_3_0_0",
                url: "https://download.data.grandlyon.com/wfs/grandlyon?SERVICE=WFS&VERSION=2.0.0&request=GetFeature&typename=gip_proprete.gipdonnerie_3_0_0&outputFormat=application/json; subtype=geojson&SRSNAME=EPSG:4171&startIndex=0",
                icon: assetsBaseDir + "/img/icon/1x/donnerie-pin.png",
            },
            {
                name: "Bornes Vêtements",
                categorie: "borne",
                id_Json: "Le_relais",
                url: assetsBaseDir + "/json/le-relais.json",
                icon: assetsBaseDir + "/img/icon/1x/textile-pin.png",
            }
        ];

        const collectionPointType = $('#datas').attr("data-collectionpointtype");

        if (collectionPointType != undefined) {

            for (let lyonJSON of lyonJSONs) {

                if (collectionPointType == lyonJSON.categorie) {
                    layersBuilders(lyonJSON);
                }
            }

        } else {
            for (let lyonJSON of lyonJSONs) {
                layersBuilders(lyonJSON);
            }
        }
    }

    /**** Gestion du bouton #addRemoveAll ****/

    $("#addRemoveAll").click(function () {

        $(this).toggleClass("selected");
        if ($(this).hasClass("selected")) {
            $(this).children("#titleButton").text("Tout masquer");
            for (const layer of layers) {
                map.addLayer(layer);
                $(".mapButton").prop("checked", true);
            }
            $("#addRemoveAll").removeClass('btn-success');
            $("#addRemoveAll").addClass('btn-danger');
        } else {
            for (const layer of layers) {
                $(this).children("#titleButton").text("Tout afficher");
                map.removeLayer(layer);
                $(".mapButton").prop("checked", false);
            }
            $("#addRemoveAll").addClass('btn-success');
            $("#addRemoveAll").removeClass('btn-danger');

        }
    })
    
    /**** Show / Hide legend on mobile ****/

    $('#showHideButton').click(function () {
        $(this).css('display', $(this).css('display') === 'none' ? 'inline-block' : 'none');
        $('#buttonsContainer').css("display", $('#buttonsContainer').css("display") === 'none' ? 'flex' : 'none')
    })

    $('#closeLegend').click(function() {
        $('#buttonsContainer').css('display', 'none');
        $('#showHideButton').css('display', 'inline-block');
    })

    // /**** Toggle legend on mobile ****/

    // $('#showHideButton').click(() => {
    //     $('#buttonsContainer').slideToggle(1000, function() {
    //         if ($(this).is(':visible')) {
    //             $(this).css('display', 'flex');
    //         }
    //     });
    // })    
}