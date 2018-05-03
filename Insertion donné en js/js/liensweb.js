/* 
Activité 1
*/

// Liste des liens Web à afficher. Un lien est défini par :
// - son titre
// - son URL
// - son auteur (la personne qui l'a publié)
var listeLiens = [
    {
        titre: "So Foot",
        url: "http://sofoot.com",
        auteur: "yann.usaille"
    },
    {
        titre: "Guide d'autodéfense numérique",
        url: "http://guide.boum.org",
        auteur: "paulochon"
    },
    {
        titre: "L'encyclopédie en ligne Wikipedia",
        url: "http://Wikipedia.org",
        auteur: "annie.zette"
    }
];

//Créer un tableau vide qui contiendra chaque lien
var listeElt = [];

//Parcourir l'ensemble de la liste de lien
listeLiens.forEach(
    function(lien){
        //Créer une div qui contiendra l'ancre et le nom de l'auteur
        var divElt = document.createElement('div');

        //Ajouter la classe lien à la div
        divElt.className = 'lien';

        //Créer un span qui contiendra le titre du lien
        var spanElt = document.createElement('span');

        //Ajouter le style au span
        spanElt.style.color = '#428bca';
        spanElt.style.fontSize = '150%';

        //Ajouter le contenu textuel au span
        spanElt.innerText = lien.titre + ' '; //Ajout d'un espace afin d'éviter que le titre et le nom du lien ne soit collés

        //Créer une ancre qui contiendra l'élément span suivi de l'url du lien
        var aElt = document.createElement('a');

        //Ajouter le contenu textuel dans l'ancre
        aElt.textContent = lien.url;

        //Ajouter le span contenant le titre du lien au début de l'ancre
        aElt.insertAdjacentElement("afterbegin", spanElt);

        //Ajouter un style à l'ancre (retirer le soulignement du lien et l'url en noir)
        aElt.style.textDecoration = 'none';
        aElt.style.color = 'black';

        //Faire pointer l'ancre vers l'url du lien
        aElt.href = lien.url;

        //Ajouter le contenu textuel de la div
        divElt.innerHTML = '<br/><span>' + lien.auteur + '</span>';

        //Ajouter l'ancre dans la div
        divElt.insertAdjacentElement("afterbegin", aElt);

        //Ajouter l'élément div dans un tableau pour l'utiliser plus tard
        listeElt.push(divElt);
    }
);

//Parcourir de nouveau toute la liste de lien pour implanter mes éléments dans la page web
listeElt.forEach(
    function(element){
        //Insérer l'élément en cours dans la div ayant la classe "contenu"
        document.getElementById('contenu').appendChild(element);
    }
);
