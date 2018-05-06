
ajaxGet("http://localhost/javascript-web-srv/data/langages.txt", function (reponse) {
    //découper la chaine reponse en plusisuer sous chaine en utilisant la fonction slip
    var listeLangages = reponse.split(';');

    var ulElt = document.getElementById('langages');

    //pour chaque sous chaine...
    listeLangages.forEach(function(langage){
        //... Créer un li et l'ajouter à l'élément ul
        var liElt = document.createElement('li');
        liElt.textContent = langage;
        ulElt.appendChild(liElt);
    });
});

