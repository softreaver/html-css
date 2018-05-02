//Supprimer le contenue HTML de la liste UL
//document.getElementById("langages").innerHTML = "";

document.querySelector("h1").textContent += " de programmation";
document.querySelector("div").setAttribute("class", "test");

var obj = document.querySelector("h1");
obj.classList.remove("debut");
obj.classList.add("titre");

console.log(obj);

//Ajout de "Python" dans la liste :

//création d'un objet dom de type li
var pythonElt = document.createElement("li");

//définition des information du nouvel élément
pythonElt.id = "python";
pythonElt.textContent = "Python";

//Insertion du nouvel élément dans la liste ul
document.getElementById("langages").appendChild(pythonElt);

var rubyElt = document.createElement("li"); // Création d'un élément li
rubyElt.id = "ruby"; // Définition de son identifiant
rubyElt.appendChild(document.createTextNode("Ruby")); // Définition de son contenu textuel
document.getElementById("langages").appendChild(rubyElt); // Insertion du nouvel élément

var perlElt = document.createElement("li");
perlElt.id = "perl";
perlElt.textContent = "Perl";

//Ajout de l'élément avant l'identifiant "php"
document.getElementById("langages").insertBefore(perlElt,
                                document.getElementById("php"));

var javascriptElt = document.createElement("li");
javascriptElt.id = "javascript";
javascriptElt.textContent = "JavaScript";
// Ajout d'un élément au tout début de la liste
document.getElementById('langages').insertAdjacentHTML("afterBegin", 
    '<li id="javascript">JavaScript</li>');

var bashElt = document.createElement("li"); // Création d'un élément li
bashElt.id = "bash"; // Définition de son identifiant
bashElt.textContent = "Bash"; // Définition de son contenu textuel
// Remplacement de l'élément identifié par "perl" par le nouvel élément
document.getElementById("langages").replaceChild(bashElt, document.getElementById("perl"));

// Suppression de l'élément identifié par "bash"
document.getElementById("langages").removeChild(document.getElementById("bash"));

var tab = ["http://lemonde.fr", "http://lefigaro.fr", "http://liberation.fr"];

// Ajout du paragraphe en fin de page
var paragraphe = document.createElement("p");
paragraphe.id = "liste";
paragraphe.innerHTML = 'En voici une <a href="https://fr.wikipedia.org/wiki/Liste_des_langages_de_programmation">liste</a> plus complète.';
document.body.appendChild(paragraphe);

var newUl = document.createElement("ul");
document.body.appendChild(newUl);
tab.forEach(function(adresse){
    var newLink = document.createElement("a");
    newLink.textContent = 'lien';
    newLink.setAttribute('href', adresse);

    var newLi = document.createElement("li");
    newLi.appendChild(newLink);
    newUl.appendChild(newLi);
});
