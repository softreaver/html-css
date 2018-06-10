//si app a déjà était créée dans un autre fichier on la reprend
//et sinon on la crée
var app = app || {};

window.onload = function () {
    let container = document.getElementById("filmsList");
    app.fetchList(container);
}

    (function (public) {// Tout ce qui devra être accessible en dehors de ce contexte d'execution sera accroché à « publics » et accessible via « app ».
        "use_strict";
        let private = {};// Tout ce qui ne devra pas quitter le contexte d'execution sera accroché à « privates » et accessible uniquement via « privates ».

        //Données
        private.APIUrl = "https://data.toulouse-metropole.fr/api/records/1.0/search/?dataset=top-500-des-films-les-plus-empruntes-a-la-bibliotheque-de-toulouse&rows=500&&sort=nbre_de_prets&q=annee%3D2017";

        //Attributs
        private.filmsList = [];
        private.load = false;
        private.IDOpened = -1;
        private.minRent = 0;
        private.maxRent = 0;
        private.slider = document.getElementById('slider');
        private.titleSuggestionElt = document.getElementById("titleSuggestion");
        private.realisatorSuggestionElt = document.getElementById("realisatorSuggestion");
        private.filmTitleInputElt = document.getElementById("filmTitle");
        private.filmRealisatorInputElt = document.getElementById("filmRealisator");
        private.filmsListContainerElt = document.getElementById("filmsList");
        private.minHandleSlider = document.getElementById('min-slider');
        private.maxHandleSlider = document.getElementById('max-slider');

        //Const
        public.SUGGEST = {
            TITLE: "titre",
            REALISATOR: "auteur",
            TOTAL_RENT: "nbre_de_prets"
        };

        public.SUGGEST_PARAM = {
            LARGEUR: "35vw",
            HAUTEUR_MAX: "50vh"
        };

        //Initialisation
        private.titleSuggestionElt.style.visibility = "hidden";
        private.realisatorSuggestionElt.style.visibility = "hidden";

        /////////////////////METHODS////////////////////////

        /////////////////////////////////////////////////////
        /**
         * Permet d'initialiser la liste des films
         */
        public.fetchList = function (elem) {

            //Si la liste existe déjà, on la supprime
            if (private.loaded) private.filmsList = [];

            //Requête d'obtention de l'API
            ajaxGet(private.APIUrl, function (response) {
                //Aucune erreur, on parse les données
                private.filmsList = JSON.parse(response).records;
                console.log(private.filmsList);

                private.minRent = private.getMinRent(private.filmsList);
                private.maxRent = private.getMaxRent(private.filmsList)

                if (!private.loaded) {
                    // Déclencher la fonction suggest à chaque fois que l'utilisateur entre quelque chose dans les input
                    document.getElementById('filmTitle').addEventListener("input", function () {
                        //Mettre à jour la liste des suggestion pour le champs de recherche concerné
                        private.suggest(private.titleSuggestionElt, public.SUGGEST.TITLE);

                        //Mettre à jour la liste des films
                        private.displayList(private.filmsListContainerElt);
                    });

                    document.getElementById('filmRealisator').addEventListener("input", function () {
                        //Mettre à jour la liste des suggestion pour le champs de recherche concerné
                        private.suggest(private.realisatorSuggestionElt, public.SUGGEST.REALISATOR);

                        //Mettre à jour la liste des films
                        private.displayList(private.filmsListContainerElt);
                    });

                    //On écoute quand les champs de recherche son déselectionné pour faire disparaitre les champs de suggestion
                    private.filmTitleInputElt.addEventListener("blur", function(event){
                        flushSuggestions(private.titleSuggestionElt);
                    });

                    private.filmRealisatorInputElt.addEventListener("blur", function(event){
                        flushSuggestions(private.realisatorSuggestionElt);
                    });

                    //On écoute l'appui de la touche entrée sur les champs de recherche
                    private.filmRealisatorInputElt.addEventListener("keypress", function(event){
                        if(event.keyCode == 13){
                            //on enlève la fenêtre de suggestion
                            flushSuggestions(private.realisatorSuggestionElt);

                            //Mettre à jour la liste des films
                            private.displayList(private.filmsListContainerElt);
                        }
                    });

                    private.filmTitleInputElt.addEventListener("keypress", function(event){
                        if(event.keyCode == 13){
                            //on enlève la fenêtre de suggestion
                            flushSuggestions(private.titleSuggestionElt);

                            //Mettre à jour la liste des films
                            private.displayList(private.filmsListContainerElt);
                        }
                    });

                    //Initialisation du double slider
                    private.initSlider(document.getElementById('slider'));

                    //Signaler que la liste des film à bien été initialisée
                    private.loaded = true;
                }

                private.displayList(elem);

            }, function (error) {
                //Afficher le message d'erreur sur la page
                if (!private.loaded)
                    elem.innerHTML = `<h3 class="error">${error}</h3>`;
                else
                    elem.insertAdjacentHTML(
                        "afterbegin",
                        `<h3 class="error">${error}</h3>`
                    );

            });

        };


        //////////////////////UTILITAIRES////////////////////////

        /////////////////////////////////////////////////////////
        /**
         * Renvoie le plus petit nombre de loction
         */
        private.getMinRent = function(filmsList){
            let min = Infinity;

            filmsList.forEach(function(film){
                if(film.fields.nbre_de_prets < min) min = film.fields.nbre_de_prets;
            });

            return min;
        }

        /////////////////////////////////////////////////////////
        /**
         * Renvoie le plus grand nombre de loction
         */
        private.getMaxRent = function(filmsList){
            let max = -Infinity;

            filmsList.forEach(function(film){
                if(film.fields.nbre_de_prets > max) max = film.fields.nbre_de_prets;
            });

            return max;
        }


        /////////////////////////////////////////////////////
        /**
         * Permet d'initiliser le double slider
         */
        private.initSlider = function(elem){
            var slider = elem;

            noUiSlider.create(slider, {
                start: [private.minRent, private.maxRent],
                connect: true,
                range: {
                    'min': private.minRent,
                    'max': private.maxRent
                }
            });

            slider.noUiSlider.on('update', function( values, handle ) {

                let value = Math.floor(values[handle]);
            
                if ( handle ) {
                    private.maxHandleSlider.value = value;
                } else {
                    private.minHandleSlider.value = value;
                }
            });

            slider.noUiSlider.on('end', function(){
                private.displayList(private.filmsListContainerElt);
            });

            private.minHandleSlider.addEventListener('change', function(){
                private.slider.noUiSlider.set([this.value, null]);
            });
            
            private.maxHandleSlider.addEventListener('change', function(){
                private.slider.noUiSlider.set([null, this.value]);
            });
        }

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
        private.suggest = function (elem, param) {
            // Vidage de la liste des suggestions
            elem.innerHTML = "";

            //Si param est valide on boucle
            if (private.filmsList[0].fields.hasOwnProperty(param)) {
                let i = 0;
                let words = "";
                let suggestionsElt = null;
                if (param === public.SUGGEST.TITLE)
                    suggestionsinputElt = private.filmTitleInputElt;
                else
                    suggestionsinputElt = private.filmRealisatorInputElt;

                words = suggestionsinputElt.value;

                private.filmsList.forEach(function (film) {
                    // Si valeur en cours de saisie correspond au contenu d'une adresse connu
                    if (match(film.fields[param], words)) {
                        //Si la liste de suggestion est invisible je la réaffiche
                        if (elem.style.visibility === "hidden") {
                            elem.style.visibility = "visible";

                            //Puis la redimentionne comme il faut
                            elem.style.maxHeight = public.SUGGEST_PARAM.HAUTEUR_MAX;
                            elem.style.width = public.SUGGEST_PARAM.LARGEUR;
                        }

                        let suggestionElt = document.createElement("div");
                        suggestionElt.classList.add("suggestion");
                        suggestionElt.classList.add(param);
                        suggestionElt.id = i;
                        suggestionElt.textContent = film.fields[param];
                        
                        elem.appendChild(suggestionElt);
                        // Gère le clicque sur une suggestion
                        suggestionElt.addEventListener("click", function (event) {
                            // Remplacement de la valeur saisie par la suggestion
                            let param = event.target.classList[1];
                            document.querySelector(
                                `input[class="${ param }"]`
                            ).value = event.target.textContent;

                            private.displayList(private.filmsListContainerElt);

                        });
                    }

                    i++;
                });
            }
        }

        ////////////////////////////////////////////////////
        /**
         * Affiche toute la liste des films en y appliquant les filtres
         * de recherche
         */
        private.displayList = function (elem) {
            //Je filtre mon tableau avec les résultats de mes champs de recherche
            let arrayToFilter = private.filmsList.filter(
                film => match(film.fields.titre, private.filmTitleInputElt.value)
            );
            let arrayToFilter2 = arrayToFilter.filter(
                film => (film.fields.nbre_de_prets >= private.minHandleSlider.value && 
                        film.fields.nbre_de_prets <= private.maxHandleSlider.value)
            );
            let filmsToDisplay = arrayToFilter2.filter(
                film => match(film.fields.auteur, private.filmRealisatorInputElt.value)
            );


            //On crée l'élément ol qui listera tous les films
            let containerElt = document.createElement("ol");
            let i = 0;
            filmsToDisplay.forEach(function (film) {
                let liFilmElt = document.createElement('li');
                liFilmElt.id = `film-${ i }`;
                liFilmElt.innerHTML = `<span class="film-title">${ film.fields.titre }</span>`;
                containerElt.appendChild(liFilmElt);

                //Ajout de toutes les infos du film
                let ulElt = document.createElement('ul');
                //On cache les infos
                ulElt.style.display = "none";

                //On écoute le clique sur l'élément de la liste pour afficher les infos du film correspondant
                liFilmElt.addEventListener("click", function(event){
                    //fermer une liste d'info si déjà ouverte
                    if(private.IDOpened !== -1){
                        document.getElementById(private.IDOpened)
                            .getElementsByTagName('ul')[0]
                                .style.display = "none";
                    }
                    //mémoriser le numéro de la liste d'info
                    private.IDOpened = event.currentTarget.id;
                    //afficher les infos du film selectionné
                    event.currentTarget.getElementsByTagName('ul')[0]
                        .style.display = "block";

                });                

                liFilmElt.appendChild(ulElt);
                for(let key in film.fields){
                    let liElt = document.createElement('li');
                    liElt.textContent = `${ key } : ${ film.fields[key] }`;
                    ulElt.appendChild(liElt);
                }

                i++;
            });

            elem.innerHTML = "";
            elem.appendChild(containerElt);
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
        function match(sentence, keywords) {
            let words = keywords.split(' ');
            let count = 0;

            words.forEach(function (word) {
                if (sentence.toUpperCase().indexOf(word.toUpperCase()) !== -1)
                    count++;
            });

            return count === words.length;
        }


        ///////////////////////////////////////////////////////////////////////////
        /**
         * Fonction permettan de faire disparaitre la fenêtre de suggestion d'adresse
         */
        function flushSuggestions(elem) {
            setTimeout(function(){
                elem.innerHTML = "";
                elem.style.visibility = "hidden";
            }, 500);
            
        }

    }(app));





