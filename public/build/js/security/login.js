resetPassword();

// Soumission du formulaire de reset de mot de passe en ajax
function resetPassword() {
    // Récupération du formulaire
    $('form[name="reset_password"]').on('submit', function(e) {

        // Bloquage de l'action initial
        e.preventDefault();

        // Affichage de la barre de chargement
        $('.progress').show();

        // Récupération du formulaire
        var $form = $(this);

        // Récupération de l'url de soumission
        var url = $('#resetPassword').attr('data-url');

        // Fonction ajax
        $.ajax({
            type:'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                // Construction du html pour le message flash
                var success = '<div class="card-panel green accent-4">'+ data +'</div>';
                // Ajout du message flash
                $('#flashMessages').html(success);

                // Retrait de la barre de chargement
                $('.progress').hide();
            },
            error: function (jqxhr) {
                // Construction du html pour le message flash
                var error = '<div class="card-panel deep-orange accent-4">'+ jqxhr.responseText +'</div>';
                // ajoute le message flash dans la div dédiée
                $('#flashMessages').html(error);

                // Retrait de la barre de chargement
                $('.progress').hide();

                // Efface le message après 5 secondes
                function removeFlashMsg(){
                    $('.card-panel').replaceWith("");
                }
                setTimeout(removeFlashMsg, 5000);
            }
        })
    });
}