/* 
Activité : jeu de devinette
*/

// NE PAS MODIFIER OU SUPPRIMER LES LIGNES CI-DESSOUS
// COMPLETEZ LE PROGRAMME UNIQUEMENT APRES LE TODO

console.log("Bienvenue dans ce jeu de devinette !");

// Cette ligne génère aléatoirement un nombre entre 1 et 100
var solution = Math.floor(Math.random() * 100) + 1;

// Décommentez temporairement cette ligne pour mieux vérifier le programme
//console.log("(La solution est " + solution + ")");

// TODO : complétez le programme
var bonneReponse = false;
var reponse, tour = 0;

while(true)
{
    tour++;
    if(tour == 7)
        break;

    reponse = Number(prompt("Entrez un nombre entre 1 et 100, il vous reste " + (7-tour) + " essais :"));

    if(reponse == solution)
    {
        bonneReponse = true;
        break;
    }
    else
    {
        if(solution < reponse)
            console.log("Le nombre à deviner est plus petit.");
        else
            console.log("Le nombre à deviner est plus grand.");
    }
}

if(bonneReponse)
    console.log("bravo, vous avez trouvé le chiffre mystère!");
else
    console.log("Vous avez perdu, le chiffre mystère était : " + solution);

