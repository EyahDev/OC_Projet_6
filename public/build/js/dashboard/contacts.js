// Initialisation des select
function materializeSelect() {
    $('select').material_select();
}

// Fonction de pagination des propriétaire
function paginateOwners() {
    $('body').on('click','#paginateOwners a', function (e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#table-owners').replaceWith(data);

                trLink();
            }, error: function () {
            }
        })
    });
}

// Soumission du formulaire d'ajout d'un nouveau contact
function addContact() {
    $('body').on('submit', 'form[name="add_new_contact"]', function (e) {
        e.preventDefault();
        $('.progress-new-contact').show();
        var $form = $(this);
        var url = $('#add_new_contact_submit').attr('data-url');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationAddContact">' + data + '</div>';

                $('#flashMessagesNewContact').html(success);

                $('.progress-new-contact').hide();

                function removeFlashMsg() {
                    $('#confirmationAddContact').replaceWith('');
                }
                setTimeout(removeFlashMsg, 5000);

                reloadAddContactForm();
                reloadUsefullContacts();
            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';

                $('#flashMessagesNewContact').html(error);
                $('.progress-new-contact').hide();
            }
        })
    });
}

// Soumission du formulaire de mise à jour d'un contact existant
function updateContact() {
    $('body').on('submit', 'form[name="update_contact"]', function (e) {
        e.preventDefault();
        $('.progress-update-contact').show();
        var $form = $(this);
        var url = $('#update_contact_submit').attr('data-url');
        var id = $('#update_contact_submit').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateContact'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateContact'+id).html(success);

                $('.progress-update-contact').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateContact'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadUsefullContacts();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateContact'+id).html(error);
                $('.progress-update-contact').hide();
            }
        })
    });
}

function deleteContact() {
    $('body').on('click', '#delete-contact', function (e) {
        e.preventDefault();
        $('.progress-update-contact').show();
        var url = $('#delete-contact').attr('data-url');
        var id = $('#delete-contact').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateContact'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateContact'+id).html(success);

                $('.progress-update-contact').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateContact'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadUsefullContacts();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateContact'+id).html(error);
                $('.progress-update-contact').hide();
            }
        })
    });
}

// Soumission du formulaire de mise à jour d'un contact existant
function updateContactType() {
    $('body').on('submit', 'form[name="update_contact_type"]', function (e) {
        e.preventDefault();
        $('.progress-update-contact-type').show();
        var $form = $(this);
        var url = $('#update_contact_type_submit').attr('data-url');
        var id = $('#update_contact_type_submit').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateContactType'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateContactType'+id).html(success);

                $('.progress-update-contact-type').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateContactType'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadUsefullContacts();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateContactType'+id).html(error);
                $('.progress-update-contact').hide();
            }
        })
    });
}

function deleteContactType() {
    $('body').on('click', '#delete-contact-type', function (e) {
        e.preventDefault();
        $('.progress-update-contact-type').show();
        var url = $('#delete-contact-type').attr('data-url');
        var id = $('#delete-contact-type').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateContactType'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateContactType'+id).html(success);

                $('.progress-update-contact-type').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateContactType'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadUsefullContacts();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateContactType'+id).html(error);
                $('.progress-update-contact').hide();
            }
        })
    });
}

// Rechargement du formulaire d'ajout d'un nouveau contact
function reloadAddContactForm() {
    var url = $('#newContactForm').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#newContactForm').replaceWith(data);

            materializeSelect();
        }
    })
}


// Rechargement des contacts utiles
function reloadUsefullContacts() {
    var url = $('#usefullContacts').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#usefullContacts').replaceWith(data);
            $('.modal').modal();
            materializeSelect();
        }
    })
}

// Chargement de l'edition de chaque contact utile
function loadModalContactEdit() {
    $('body').on('click', '.edit-contact-modal-trigger', function (e) {
        var htmlID = '#modal-edit-contact-';
        var dataID = e.currentTarget.dataset.id;
        $('#genericModal').modal('open');
        var url = $(htmlID+dataID).attr('data-url');
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

// Chargement de l'edition de chaque contact utile
function loadModalContactTypeEdit() {
    $('body').on('click', '.edit-contact-type-modal-trigger', function (e) {
        var htmlID = '#modal-edit-contact-type-';
        var dataID = e.currentTarget.dataset.id;
        $('#genericModal').modal('open');
        var url = $(htmlID+dataID).attr('data-url');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
                Materialize.updateTextFields();
            }
        })
    });
}


$(document).ready(function(){
    materializeSelect();
    $('.modal').modal();
    paginateOwners();
    addContact();
    loadModalContactEdit();
    updateContact();
    deleteContact();
    loadModalContactTypeEdit();
    updateContactType();
    deleteContactType();
});