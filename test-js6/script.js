// Création d'un objet représentant un film
var form = document.querySelector('form');

form.addEventListener("submit", function (e) {
    e.preventDefault();

    var data = new FormData(form);
    // Envoi de l'objet au serveur
    ajaxPost("http://localhost/javascript-web-srv/post_json.php", data,
        function (reponse) {
            // Confirmaiton en cas de succès
            document.getElementById('callback').textContent = 'Le témoignage à bien été envoyé.';
        },
        true // Valeur du paramètre isJson
    );
});
//https://oc-jswebsrv.herokuapp.com/api/temoignage