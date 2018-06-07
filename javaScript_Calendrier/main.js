//si app a déjà était créée dans un autre fichier on la reprend
//et sinon on la crée
var app = app || {};

window.onload = function(){
    let elems = document.querySelectorAll('[class^="k-landar"]');
    app.generateKalandars(elems);
}

(function(public){// Tout ce qui devra être accessible en dehors de ce contexte d'execution sera accroché à « publics » et accessible via « app ».
    "use_strict";
    let private = {};// Tout ce qui ne devra pas quitter le contexte d'execution sera accroché à « privates » et accessible uniquement via « privates ».
    
    /////////////////////METHODS////////////////////////

    public.generateKlandars = function(elements){
        //Parcourir la liste de tous les éléments devant recevoir un mois
        for(let element of elements){
            //Vérifier que l'élément contient bien tous les paramètres requis
            
        }
    }

    private.Month = function(month, year){
        //Attributs
        private.year = year;
        private.month = month;
        private.date = new Date(year, month);
        private.totalDays;

        //Const
        private.DAYS = {
            MONDAY:     1,
            TUESDAY:    2,
            WEDNESDAY:  3,
            THIRSDAY:   4,
            FRIDAY:     5,
            SATURDAY:   6,  
            SUNDAY:     0
        }

        private.MONTHS = {
            JANUARY:    0,
            FEBRUARY:   1,
            MARCH:      2,
            APRIL:      3,
            MAY:        4,
            JUNE:       5,
            JULY:       6,
            AUGUST:     7,
            SEPTEMBER:  8,
            OCTOBER:    9,
            NOVEMBER:   10,
            DECEMBER:   11
        }
    }


    //////////////////////UTILITAIRES////////////////////////

    /*******************************************************
     * @private Fonction utilitaire                         *
     * @description : Vérifie qu'un élément à bien tous     *
     * les paramètres prérequis pour être traité            *
     * Si l'élément ne peut pas être traité la fonction     *
     * se chargera également d'afficher un message d'erreur *
     * dans l'élément.                                      *
     *                                                      *
     * @param element : (element DOM) Prend l'élément       *
     * souhaitant recevoir un calendrier                    *
     *                                                      *
     * @return : (booleen) TRUE si l'élément contient       *
     * tous paramètres nécessaire, sinon FALSE              *
     ***************************************************** */
    function hasAllParam(element){
        //Initialisation des expressions régulières
        regExpMonthParam    = /k-landar-m-[1-9]$|(1[0,2])/;                                 //Formatage : k-landar-m-XX (où XX est un nombre de 1 à 12)
        regExpYearParam     = /k-landar-y-((1[7-9]{1})|([2-9]{1}[0-9]{1})[0-9]{2}$){1}/;    //Formatage : k-landar-y-XXXX (où XXXX est l'année de 1970 à 9999)
        let monthParameter = false;
            let yearParameter = false;
            for(let className in element.classList){
                
            }
    }


}(app));
