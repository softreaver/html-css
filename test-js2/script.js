var textColor = prompt("entrez une couleur en anglais");
var backgrdColor = prompt("couleur du fond SVP :");

var paragraphes = document.getElementsByTagName("p");

for(var i = 0; i < paragraphes.length; i++){
    paragraphes[i].style.backgroundColor = backgrdColor;
    paragraphes[i].style.color = textColor;
}

//A REVOIR LES BOUCLES FOREACH
//ON NE PEUT PAS RECUPERER LES STYLE DECLARES DANS UNE FEUILLE DE STYLE EXTERNE.