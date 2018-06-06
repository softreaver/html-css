
//Data pool
let stations;                                                               //tableau qui contiendra la liste de toutes les stations vélos de Toulouse
let addressList             = [];                                           //Tableau qui contiendra les adresses des stations vélo
const suggestionsListElt    = document.getElementById("suggestions");       //La boite proposant les suggestions d'adresse
const searchInputElt        = document.getElementById('address');           //Le champ permettant d'entrer la recherche d'adresse
let firstLoad               = true;                                         //Un booleen indiquant si la page vient d'être chargée ou pas
const middleContainerElt    = document.getElementById("middle-container");  //Element <section>
const stationsList          = document.getElementById("stations-list");     //Element contenant la liste des stations recherchées
const stationInfo           = document.getElementById("station-info");      //Element contenant les informations de la station delectionnée
let stationsToDisplay       = [];                                           //Tableau contenant tous les indexs des stations à afficher

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

        displayStations(stationsToDisplay);
    
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

    addressList.forEach(function (address) {
    // Si valeur en cours de saisie correspond au contenu d'une adresse connu
        if(matche(address, searchInputElt.value.toUpperCase())){
            //Si la liste de suggestion est invisible je la réaffiche
            if(suggestionsListElt.style.visibility === "hidden") {
                suggestionsListElt.style.visibility = "visible";

                //Puis la redimentionne comme il faut
                suggestionsListElt.style.maxHeight  = "50vh";
                suggestionsListElt.style.width      = "100%";
            }

            let suggestionElt = document.createElement("div");
            suggestionElt.classList.add("suggestion");
            suggestionElt.textContent = address;
            // Gère le lic sur une suggestion
            suggestionElt.addEventListener("click", function (event) {
                // Remplacement de la valeur saisie par la suggestion
                searchInputElt.value = event.target.textContent;
                // Vidage de la liste des suggestions
                flushSuggestions();
            });
            suggestionsListElt.appendChild(suggestionElt);
        }
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

function displayStations(list){
    for(let i = 0; i < stations.length; i++){
        if(list.length > 0){
            list.forEach(function(elem){
                if(elem === i)
                    stationsList.insertAdjacentHTML(
                        "beforeend",
                        `<div id="${ i }">${ stations[i].name }</div>`
                    );
            });
        }else{
            stationsList.insertAdjacentHTML(
                "beforeend",
                `<div id="${ i }">${ stations[i].name }</div>`
            );
        }
    }
}

/*************************************
 * Vérifier si tous les most de val2
 * sont tous contenu dans val1
***************************************/

function matche(val1, val2){
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

