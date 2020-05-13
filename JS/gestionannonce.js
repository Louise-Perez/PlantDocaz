let corbeille = document.getElementById("corbeille"); 

function supprimerAnnonce() {
    console.log("ça marche pas");
    delete corbeille.parentElement.outerHTML;
   
}

corbeille.onclick = supprimerAnnonce; 