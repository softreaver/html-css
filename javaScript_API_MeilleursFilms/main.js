//si app a déjà était créée dans un autre fichier on la reprend
//et sinon on la crée
var app = app || {};

window.onload = function(){
    let container = document.getElementById("filmsList");
    app.generateList(container);
}

(function(public){// Tout ce qui devra être accessible en dehors de ce contexte d'execution sera accroché à « publics » et accessible via « app ».
    "use_strict";
    let private = {};// Tout ce qui ne devra pas quitter le contexte d'execution sera accroché à « privates » et accessible uniquement via « privates ».
    
    //Données
    private.APIUrl = "https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=top-500-des-films-les-plus-empruntes-a-la-bibliotheque-de-toulouse&rows=500&sort=-annee";

    //Attributs
    private.filmsList               = [];
    private.load                    = false;
    private.titleSuggestionElt      = document.getElementById("titleSuggestion");
    private.realisatorSuggestionElt = document.getElementById("realisatorSuggestion");
    private.filmTitleInputElt       = document.getElementById("filmTitle");
    private.filmRealisatorInputElt  = document.getElementById("filmRealisator");

    //Const
    public.SUGGEST = {
        TITLE:      "titre",
        REALISATOR: "auteur",
        TOTAL_RENT: "nbre_de_prets"
    };

    public.SUGGEST_PARAM = {
        LARGEUR:        "60vw",
        HAUTEUR_MAX:    "50vh"
    };

    /////////////////////METHODS////////////////////////

    /**
     * Permet d'initialiser la liste des films
     */
    public.generateList = function(elem){

        //Si la liste existe déjà, on la supprime
        if(private.loaded) private.filmsList = [];      

        //Requête d'obtention de l'API
        ajaxGet(private.APIUrl, function(response){
            //Aucune erreur, on parse les données
            private.filmsList = JSON.parse(response).records;
            console.log(private.filmsList);
        
            if(!private.loaded){                    
                // Déclencher la fonction suggest à chaque fois que l'utilisateur entre quelque chose dans les input
                document.getElementById('filmTitle').addEventListener("input", function(){
                    private.suggest(private.titleSuggestionElt, public.SUGGEST.TITLE);
                });

                document.getElementById('filmRealisator').addEventListener("input", function(){
                    private.suggest(private.realisatorSuggestionElt, public.SUGGEST.REALISATOR);
                });

                //Signaler que la liste des film à bien été initialisée
                private.loaded = true;
            }

            private.displayList(elem);
    
        }, function(error){
            //Afficher le message d'erreur sur la page
            if(!private.loaded)
                elem.innerHTML = `<h3 class="error">${ error }</h3>`;
            else
                elem.insertAdjacentHTML(
                    "afterbegin",
                    `<h3 class="error">${ error }</h3>`
                );
            
        });

        ////////////////////////////////////////////////////
        /**
         * Affiche toute la liste des films en y appliquant les filtres
         * de recherche
         */
        private.displayList = function(elem){
            //Je filtre mon tableau avec les résultats de mes champs de recherche
            let arrayToFilter = private.filmsList.filter(
                film => match(film.fields.titre, private.filmTitleInputElt.value)
            );
            let filmsToDisplay = arrayToFilter.filter(
                film => match(film.fields.auteur, private.filmRealisatorInputElt.value)
            );

            //On crée l'élément ol qui listera tous les films
            let containerElt = document.createElement("ol");
            filmsToDisplay.forEach(function(film){
                containerElt.insertAdjacentHTML(
                    "beforeend",
                    `<li>${ film.fields.titre }</li>`
                );
            });

            elem.innerHTML = "";
            elem.appendChild(containerElt);
        }
    };


    //////////////////////UTILITAIRES////////////////////////

    /************************************************************
     * @private Fonction utilitaire                             *
     * @description : Permet de générer une liste de            *
     * se basan sur un paramètre (param) de recherche           *
     *                                                          *
     * @param elem : (element DOM) Prend l'élément dans lequel  *
     * la liste de suggestion doit être affichée                *
     *                                                          *
     * @param param : (SUGGEST.<paramètre>) le type de recherche*
     ********************************************************* */
    private.suggest = function(elem, param){
        // Vidage de la liste des suggestions
        elem.innerHTML = "";

        let i = 0;
        private.filmsList.forEach(function (film) {
            //Si param n'est pas valide on sort de la boucle
            if(film.fields.hasOwnProperty(param)){
                // Si valeur en cours de saisie correspond au contenu d'une adresse connu
                let words = "";
                let suggestionsElt = null;
                if(param === public.SUGGEST_PARAM.TITLE)
                    suggestionsElt = private.titleSuggestionElt;
                else
                    suggestionsElt = private.realisatorSuggestionElt;

                words = suggestionsElt.textContent.toUpperCase();
                
                if(match(film.fields[param], words)){
                    //Si la liste de suggestion est invisible je la réaffiche
                    if(elem.style.visibility === "hidden") {
                        elem.style.visibility = "visible";

                        //Puis la redimentionne comme il faut
                        elem.style.maxHeight  = public.SUGGEST_PARAM.HAUTEUR_MAX;
                        elem.style.width      = public.SUGGEST_PARAM.LARGEUR;
                    }

                    let suggestionElt = document.createElement("div");
                    suggestionElt.classList.add("suggestion");
                    suggestionElt.id = i;
                    suggestionElt.textContent = film.fields[param];
                    // Gère le clicque sur une suggestion
                    suggestionElt.addEventListener("click", function (event) {
                        // Remplacement de la valeur saisie par la suggestion
                        suggestionsElt.textContent = event.target.textContent;
                        
                        // Vidage de la liste des suggestions
                        flushSuggestions(elem);
                    });
                    elem.appendChild(suggestionElt);
                }
            }    
            i++;
        });
    }

//////////////////////////////////////////////////////////////////////////
/**@description : Permet de savoir si tous les mots envoyer via (keywords)
 * sont bien présent dans la phrase (sentence) et ce peut importe l'ordre
 *  
 * @param {*} sentence 
 * @param {*} keyword 
 * 
 * @returns : un booleen, TRUE si tous les mots sont présents sinon FALSE
 */
    function match(sentence, keywords){
        let words = keywords.split(' ');
        let count = 0;
    
        words.forEach(function(word){
            if (sentence.indexOf(word) !== -1)
                count++;
        });
            
        return count === words.length;
    }


///////////////////////////////////////////////////////////////////////////
    /**
     * Fonction permettan de faire disparaitre la fenêtre de suggestion d'adresse
     */
    function flushSuggestions(elem){
        elem.innerHTML = "";
        elem.style.visibility = "hidden";
    }

}(app));





