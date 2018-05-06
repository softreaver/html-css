var Compteur = {
    value: 0  
  };
  
  document.getElementById('clic').addEventListener('click', function(){
      Compteur.value++;
      document.getElementById('compteurClics').textContent = Compteur.value;
  });
  