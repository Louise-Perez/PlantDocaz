$(document).ready(function(){
    const apiUrl = 'https://geo.api.gouv.fr/communes?codePostal=';
    const format = '&format=json';

    let code_postal_membres = $('#code_postal_membres'); 
    let ville_membres = $('#ville_membres');
    let errorMessage = $('#error-message'); 


    $(code_postal_membres).on('blur', function() {
        let code = $(this).val();
        // console.log(code);
        let url = apiUrl+code+format;
        // console.log(url);

        fetch(url, {method: 'get'}).then(response => response.json()).then(results=> {
            //console.log(results);
            $(ville_membres).find('option').remove();
            if (results.length){
                $(errorMessage).text('').hide();
                $.each(results, function(key, value){
                    console.log(value.nom);
                    $(ville_membres).append('<option value=" '+ value.nom +' "> '+value.nom+' </option>');
                });
            }
            else {
                if($(code_postal_membres).val()){
                    console.log('Erreur de code postal.');
                    $(errorMessage).text('Aucune commune avec ce code postal.').show();
                }
                else {
                    $(errorMessage).text('').hide();
                }
            }
        }).catch(err =>{
            console.log(err);
            $(ville_membres).find('option').remove();
        });
    });
});