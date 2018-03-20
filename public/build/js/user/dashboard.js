// Chargement de l'ajout d'une notification
function loadModalNotification() {
    $('body').on('click', '#add-notification-modal-trigger', function (e) {
        e.preventDefault();
        $('#genericModal').modal('open');
        var url = $('#add-notification-modal-trigger').attr('data-url');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
                Materialize.updateTextFields();
                materializeSelect();
            }
        })
    });
}

// Rechargement du formulaire d'ajout d'un nouveau contact
function reloadNotifications() {
    var url = $('#notifications').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#notifications').replaceWith(data);
        }
    })
}

// Soumission du formulaire d'ajout d'une carte de cours
function addNotification() {
    $('body').on('submit', 'form[name="add_notification"]', function (e) {
        e.preventDefault();
        $('.progress-add-notification').show();
        var $form = $(this);
        var url = $('#add-notification-submit').attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationAddNotification">' + data + '</div>';

                $('#flashMessagesAddNotification').html(success);

                $('.progress-add-notification').hide();

                function removeFlashMsg() {
                    $('#confirmationAddNotification').replaceWith('');
                    $('#genericModal').modal('close');
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 1000);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#confirmationAddNotification').html(error);
                $('.progress-add-notification').hide();
            }
        })
    });
}


// Fonction pour la supression d'une notification
function deleteNotification() {
    $('body').on('click', '#delete-notification', function (e) {
        e.preventDefault();
        var url = $('#delete-notification').attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            success: function (data) {
                reloadNotifications();
            },
            error: function (jqxhr) {
            }
        })
    });
}

// Fonction de pagination de l'historique
function paginateHistory() {
    $('body').on('click','#paginateCourseCardHistory a', function (e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#table-course-card-history').replaceWith(data);
            }, error: function () {
            }
        })
    });
}

$(document).ready(function(){
    $('.modal').modal();
    paginateHistory();
    deleteNotification();
    loadModalNotification();
    addNotification();
});