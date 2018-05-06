

function rechercher(nom) {
    ajaxGet("https://api.github.com/users/" + nom, function (reponse) {
        // Transforme la réponse en un tableau d'articles
        var profil = JSON.parse(reponse);
        // Mise à jour des données du profil
        var profilElt = document.getElementById('profil');

            //Création de la photo du profil
            var imgElt = document.createElement('img');
            imgElt.src = profil.avatar_url;
            imgElt.id = 'photo-profil'

            //Création du nom
            var nomElt = document.createElement('div');
            nomElt.textContent = profil.name;
            nomElt.id = 'nom-profil';

            //Création du lien vers le blog
            var blogElt = document.createElement('a');
            blogElt.href = profil.blog;
            blogElt.textContent = profil.blog;
        
        //Ajout des élément à la page
        profilElt.appendChild(imgElt);
        profilElt.appendChild(nomElt);
        profilElt.appendChild(blogElt);
    });
}

//Ajout du comportement au clique
document.getElementById('send').addEventListener("click", function(e){
    e.preventDefault();
    rechercher(document.getElementById('nom').value);
});
