//si app a déjà était créée dans un autre fichier on la reprend
//et sinon on la crée
var app = app || {};

(function (publics) {// Tout ce qui devra être accessible en dehors de ce contexte d'execution sera accroché à « publics » et accessible via « app ».
    "use strict"    
    let privates = {}; // Tout ce qui ne devra pas quitter le contexte d'execution sera accroché à « privates » et accessible uniquement via « privates ».
    privates.openedInfoWindow = false;
    privates.loadData = function () {
        let xhr = new XMLHttpRequest();
        let openedInfoWindow = false;

        function onReadyStateChange(evt) {
            if (this.readyState == 4 && this.status == 200) {
                //si les données sont correctement chargées, on initialise la carte
                privates.initMap(JSON.parse(this.responseText))
            }
        }
        xhr.addEventListener('readystatechange', onReadyStateChange);
        xhr.open('get', 'https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=velo-toulouse&rows=282');
        xhr.send();
    }

    privates.initMap = function (dataObj) {
        //centre de la carte
        let toulouse = { lat: 43.600000, lng: 1.433333 };

        //création de la carte
        let map = new google.maps.Map(document.getElementById('map'), {
            zoom: 13,
            center: toulouse
        });

        //pour chaque enregistrement dans dataObj.records
        for (let i = 0; i < dataObj.records.length; i++) {
            //variable pour permettre un accés simple au record concerné
            let record = dataObj.records[i];

            //création des fenêtre d'information
            let infoWindow = new google.maps.InfoWindow({
                content: `
                    <section class="window-info-section">
                        <h3>${record.fields.nom}</h3>
                        <ul class="map-list">
                            <li>nombres de bornes : ${record.fields.nb_bornettes}</li>
                            <li>numéro de la station : ${record.fields.num_station}</li>
                        </ul>
                    </section>
                    `,
            });

            //création des markers
            let marker = new google.maps.Marker({
                position: {
                    lat: +record.fields.geo_point_2d[0],
                    lng: +record.fields.geo_point_2d[1],
                },
                map: map,
                //on passe une référence vers le record
                record: record,
                //on passe une référence vers la fenêtre d'info
                infoWindow: infoWindow
            });

            //on écoute le click sur le marker
            marker.addListener('click', privates.showMarkerInfos);
        }
    }
    privates.showMarkerInfos = function showMarkerInfos(evt) {
        //on ferme la fenêtre précédente
        if (privates.openedInfoWindow) {
            privates.openedInfoWindow.close();
        }

        //on ouvre la fenêtre d'info
        this.infoWindow.open(this.map, this);
        privates.openedInfoWindow = this.infoWindow;

        //on affiche les infos
        let dataFrame = document.querySelector('#data');
        console.log(data)
        console.log(this.record)
        dataFrame.innerHTML = JSON.stringify(this.record, null, 3);
    }
    
    publics.init = function () {
        privates.loadData();
    }
}(app));

app.init();
