
//Data pool
let stations;                                                               //tableau qui contiendra la liste de toutes les stations vélos de Toulouse
let addressList             = [];                                           //Tableau qui contiendra les adresses des stations vélo
let markerList              = [];                                           //Liste des marker à afficher sur la Google map
let infoWindowList          = [];                                           //Liste des infobulle pour les marqueurs
const suggestionsListElt    = document.getElementById("suggestions");       //La boite proposant les suggestions d'adresse
const searchInputElt        = document.getElementById('address');           //Le champ permettant d'entrer la recherche d'adresse
let firstLoad               = true;                                         //Un booleen indiquant si la page vient d'être chargée ou pas
const middleContainerElt    = document.getElementById("middle-container");  //Element <section>
const stationsList          = document.getElementById("stations-list");     //Element contenant la liste des stations recherchées
const stationInfo           = document.getElementById("station-info");      //Element contenant les informations de la station delectionnée
let map;                                                                    //Objet contenant la Google map
let googleMapReady          = false                                         //Booleen indiquant si la Google map à bien finit de s'initialiser
let stationsListReady       = false                                         //Booleen indiquant si la liste des stations de vélo à bien finit de se télécharger
let firstInitMarker         = true                                          //Booleen indiquant si les marqueur on déjà été initialisés une première fois
let openedInfoWindow        = -1                                            //Contient l'ID de la fenêtre actuellement ouverte, sinon vaut -1.

//Données du service en ligne
const APIUrl            = "https://api.jcdecaux.com/vls/v1/stations?contract=Toulouse&apiKey=";
const APIKey            = "b3b0187b8e554ae38d5c1407d06f8bd90cd906fb";
const refreshInterval   = 180000; //Taux de rafraichissement des données (60 * 1000 * 3 ms = 3 min)

//Démarrage du cycle de mise à jour des données de la page
upDate();
setInterval(upDate, refreshInterval);

/*************************************
 * Contact le serveur API afin de
 * récupérer les stations vélos
 * puis mettre à jour la liste
***************************************/
function upDate(){
    ajaxGet(APIUrl + APIKey, function(response){
        //Aucune erreur, on parse les données
        stations = JSON.parse(response);
        //Placer toutes les adresses dans un tableau
        addressList = [];
        for(let station of stations){
            addressList.push(station["address"].toUpperCase());
        }
    
        if(firstLoad){
            suggestionsListElt.style.visibility = "hidden";

            // Déclencher le fonction suggest à chaque fois que l'utilisateur entre quelque chose dans le input
            document.getElementById('address').addEventListener("input", suggest);
            firstLoad = false;
        }

        displayStations();

        //On signal que la liste des staions à bien été mise à jour
        stationsListReady = true;

        // Si la carte et la liste des stations sont initialisées, on place les marqueurs sur la carte
        if(isAllReady()) initMarker();
    
    }, function(error){
        //Afficher le message d'erreur sur la page
        if(firstLoad)
            document.getElementById("stations-list")
                .innerHTML = `<h3 class="error">${ error }</h3>`;
        else
            document.getElementById('stations-list')
                .insertAdjacentHTML("afterbegin",
                    `<h3 class="error">${ error }</h3>`);
        
    });
}

/*************************************
 * suggestion d'adresse
***************************************/

function suggest(event){
    // Vidage de la liste des suggestions
    suggestionsListElt.innerHTML = "";

    let i = 0;
    addressList.forEach(function (address) {
    // Si valeur en cours de saisie correspond au contenu d'une adresse connu
        if(match(address, searchInputElt.value.toUpperCase())){
            //Si la liste de suggestion est invisible je la réaffiche
            if(suggestionsListElt.style.visibility === "hidden") {
                suggestionsListElt.style.visibility = "visible";

                //Puis la redimentionne comme il faut
                suggestionsListElt.style.maxHeight  = "50vh";
                suggestionsListElt.style.width      = "60vw";
            }

            let suggestionElt = document.createElement("div");
            suggestionElt.classList.add("suggestion");
            suggestionElt.id = i;
            suggestionElt.textContent = address;
            // Gère le lic sur une suggestion
            suggestionElt.addEventListener("click", function (event) {
                // Remplacement de la valeur saisie par la suggestion
                searchInputElt.value = event.target.textContent;

                // Afficher l'info bulle correspondante
                let index = parseInt(this.getAttribute('id'), 10);
                let marker = markerList[index]
                if(openedInfoWindow !== -1) infoWindowList[openedInfoWindow].close();
                infoWindowList[index].open(map, marker);
                openedInfoWindow = marker.IDInfoWindow;
                
                // Vidage de la liste des suggestions
                flushSuggestions();
            });
            suggestionsListElt.appendChild(suggestionElt);
        }

        i++;
    });
}

/*************************************
 * Enlever la fenêtre de suggestion 
 * si le input perd le focus
***************************************/
searchInputElt.addEventListener("blur", function(){
    setTimeout(flushSuggestions, 100);
});


/*************************************
 * Afficher la fenêtre de suggestion 
 * si le input obtient le focus
***************************************/
searchInputElt.addEventListener("focus", suggest);

/*************************************
 * Afficher les stations
***************************************/

function displayStations(){
    for(let i = 0; i < stations.length; i++){
        stationsList.insertAdjacentHTML(
            "beforeend",
            `<div id="${ i }" class= "station">${ stations[i].name }</div>`
        );
    }
}

/*************************************
 * Vérifier si tous les most de val2
 * sont tous contenu dans val1
***************************************/

function match(val1, val2){
    let words = val2.split(' ');
    let count = 0;

    words.forEach(function(word){
        if (val1.indexOf(word) !== -1)
            count++;
    });
        
    return count === words.length;
}

/*************************************
 * Fonction permettan de faire disparaitre
 * la fenêtre de suggestion d'adresse
***************************************/
function flushSuggestions(){
    suggestionsListElt.innerHTML = "";
    suggestionsListElt.style.visibility = "hidden";
}

/*************************************
 * Initialisation de la Google map
***************************************/

function initMap() {
    map = new google.maps.Map(document.getElementById('map'), {
    center: {lat: 43.60, lng: 1.455},
    zoom: 13,
    });
    
    // On signal que la GoogleMap a finit de s'initialiser
    googleMapReady = true;

    //On initialise les marqueurs si la carte et la listes des staions sont bien initialisés
    if(isAllReady()) initMarker();
}

/*************************************
 * Initialisation et placement des
 * marqueurs sur la Google map
***************************************/

function initMarker(){
    //Réinitialisation de la liste des marker
    //Si une info bulle est ouverte, il faut la supprimer pour pouvoir la réinitialiser
    if(openedInfoWindow !== -1)
        infoWindowList[openedInfoWindow].close();
    infoWindowList = [];

    let i = 0;
    for(let station of stations){
        //Initialisation des données à mettre dans le markeur
        let myLatlng = station.position
        //création d'un infobulle
        //Borne de paiement disponible à la station
        let banking = (station.banking) ? "OUI" : "NON" ;

        //Disponibilité de la station
        let status = (station.status === "OPEN") ? 
            '<span class="open">OUVERT</span>' :
            '<span class="closed">FERMÉE</span>' ;

        //Dernière mise à jour des données
        let lastUpdate = new Date((Date.now() - station.last_update)).getMinutes();

        //Contenu de l'infobulle
        let infoWindowContent = `
            <div id="infoBulle-container">
                <h3>${ station.name } N° ${ station.number }</h3>
                <div id="infoBulle-content">
                    <p>${ status }</p>
                    <p>Dernière mise à jour il y a ${ lastUpdate } minutes</p>
                    <p>Vélos dispo : ${ station.available_bikes }</p>
                    <p>Places dispo : ${ station.available_bike_stands }</p>
                    <p>Borne de paiement : ${ banking }</p>
                    <p><span class="small">lat : ${ station.position.lat } - long : ${ station.position.lng }</span></p>
                </div>
            </div>`;

        infoWindowList.push(
            new google.maps.InfoWindow({
                content: infoWindowContent
            })
        );

        let marker = new google.maps.Marker({
                position: myLatlng,
                //Si c'est la première fois qu'on les initialise, on leur ajoute une animation
                animation: (firstInitMarker) ? google.maps.Animation.DROP : "",
                IDInfoWindow: i
            })

        markerList.push(marker);

        //Si l'info bulle était ouverte avant la mise à jour des infos, on la réouvre
        if(openedInfoWindow !== -1 && openedInfoWindow === i) infoWindowList[openedInfoWindow].open(map, marker);

        //Ajouter la réaction aux cliques sur le marker en cours de création
        marker.addListener("click", function(event){
            //Fermer la fenêtre déjà ouverte
            if(openedInfoWindow !== -1) infoWindowList[openedInfoWindow].close();
            infoWindowList[this.IDInfoWindow].open(map, this);
            openedInfoWindow = this.IDInfoWindow;
        });

        //Ajouter une réaction aux clique sur l'élément de la liste correspondant
        document.getElementById(i).addEventListener("click", function(event){
            let index = parseInt(this.getAttribute('id'), 10);
            let marker = markerList[index]
            if(openedInfoWindow !== -1) infoWindowList[openedInfoWindow].close();
            infoWindowList[index].open(map, marker);
            openedInfoWindow = marker.IDInfoWindow;
        });

        //Ajouter une animation sur le marqueur associé à l'élément de la liste actuellement survolé par la souris
        document.getElementById(i).addEventListener("mouseover", function(event){
            let index = parseInt(this.getAttribute('id'), 10);
            let marker = markerList[index]
            marker.setAnimation(google.maps.Animation.BOUNCE);
        });

        //Arrêter l'animation du marqueur lorsque la souris sort de l'élément
        document.getElementById(i).addEventListener("mouseout", function(event){
            let index = parseInt(this.getAttribute('id'), 10);
            let marker = markerList[index]
            marker.setAnimation(null);
        });
        

        //Incrémentation de l'itérateur
        i++;
    }

    //Affichage des marqueurs sur la carte
    for(let i = 0; i < markerList.length; i++){
        setTimeout(
            markerList[i].setMap(map),
            200 * i
        );
    }

    firstInitMarker = false;
}

/*************************************
 * R'envoie TRUE si la carte ET la
 * liste des stations sont à jours
***************************************/

function isAllReady(){
    return stationsListReady && googleMapReady;
}
