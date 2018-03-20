// Initialisation des modals
function initMaterialize() {
    $('.modal').modal();
    $('select').material_select();
}

// Chargement du formulaire d'ajout d'une carte de cours
function loadModalAddCourseCard() {
    $('body').on('click', '#add-course-card-modal-trigger', function (e) {
        var url = $('#add-course-card-modal-trigger').attr('data-url');
        $('#genericModal').modal('open');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
            }
        })
    });
}

// Rechargement des contacts utiles
function loadModalUpdateHorse() {
    $('body').on('click', '.edit-horse-modal-trigger', function (e) {
        var htmlID = '#edit-horse-';
        var dataID = e.currentTarget.dataset.id;
        var url = $(htmlID+dataID).attr('data-url');
        $('#genericModal').modal('open');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
                Materialize.updateTextFields();
                $('select').material_select();
            }
        })
    });
}

// Chargement du formulaire pour l'ajout de la facture
function loadModalAddBill() {
    $('body').on('click', '#add-bill-modal-trigger', function (e) {
        var url = $('#add-bill-modal-trigger').attr('data-url');
        $('#genericModal').modal('open');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
                $('select').material_select();
            }
        })
    });
}

// Chargement de la mise à jour d'une facture
function loadModalUpdateBill() {
    $('body').on('click', '.update-bill-modal-trigger', function (e) {
        var htmlID = '#update-bill-modal-';
        var dataID = e.currentTarget.dataset.id;
        console.log(htmlID+dataID);
        var url = $(htmlID+dataID).attr('data-url');
        $('#genericModal').modal('open');
        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#modalContent').replaceWith(data);
                Materialize.updateTextFields();
                $('select').material_select();
            }
        })
    });
}

// Rechargement des informations lié à la carte de cours
function reloadCourseCardSection() {
    var url = $('#courseCardInformations').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#courseCardInformations').replaceWith(data);
            initMaterialize();
        }
    })
}

// Soumission du formulaire d'ajout d'une carte de cours
function addCourseCard() {
    $('body').on('submit', 'form[name="add_course_card"]', function (e) {
        e.preventDefault();
        $('.progress-add-course-card').show();
        var $form = $(this);
        var url = $('#add_course_card_submit').attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationAddCourseCard">' + data + '</div>';

                $('#flashMessagesAddCourseCard').html(success);

                $('.progress-add-course-card').hide();

                function removeFlashMsg() {
                    $('#confirmationAddCourseCard').replaceWith('');
                    $('#genericModal').modal('close');
                    reloadCourseCardSection();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesAddCourseCard').html(error);
                $('.progress-add-course-card').hide();
            }
        })
    });
}

// Soumission du formulaire de mise à jour de la carte de son historique
function addCourseCardHistory() {
    $('body').on('submit', 'form[name="update_course_card_history"]', function (e) {
        e.preventDefault();
        $('.progress-update-history').show();
        var $form = $(this);
        var url = $('#update_course_card_history_submit').attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateCourseCardHistory">' + data + '</div>';

                $('#flashMessagesCourseCardHistory').html(success);

                $('.progress-update-history').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateCourseCardHistory').replaceWith('');
                }
                setTimeout(removeFlashMsg, 5000);
                reloadCourseCardSection();
                reloadUpdateCourseCardForm();
            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesCourseCardHistory').html(error);
                $('.progress-update-history').hide();
            }
        })
    });
}

// Soumission du formulaire d'ajout d'une facture'
function addBill() {
    $('body').on('submit', 'form[name="add_new_bill"]', function (e) {
        e.preventDefault();
        $('.progress-add-bill').show();
        var url = $('#add_new_bill_submit').attr('data-url');
        $.ajax({
            type: 'POST',
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationAddBill">' + data + '</div>';

                $('#flashMessagesAddBill').html(success);

                $('.progress-add-bill').hide();

                function removeFlashMsg() {
                    $('#confirmationAddBill').replaceWith('');
                    $('#genericModal').modal('close');
                    reloadBillsTable();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 5000);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesAddBill').html(error);
                $('.progress-add-bill').hide();
            }
        })
    });
}

// Soumission du formulaire de mise à jour d'un cheval
function updateHorse() {
    $('body').on('submit', 'form[name="update_horse"]', function (e) {
        e.preventDefault();
        $('.progress-update-horse').show();
        var $form = $(this);
        var url = $('#update_horse_submit').attr('data-url');
        var id = $('#update_horse_submit').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateHorse'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateHorse'+id).html(success);

                $('.progress-update-horse').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateHorse'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadHorseSection();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateHorse'+id).html(error);
                $('.progress-update-horse').hide();
            }
        })
    });
}

// Soumission du formulaire de mise à jour d'une facture
function updateBill() {
    $('body').on('submit', 'form[name="update_bill"]', function (e) {
        e.preventDefault();
        $('.progress-update-bill').show();
        var url = $('#update_bill_submit').attr('data-url');
        var id = $('#update_bill_submit').attr('data-id');

        $.ajax({
            type: 'POST',
            url: url,
            data: new FormData(this),
            processData: false,
            contentType: false,
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationUpdateBill'+id+'">' + data + '</div>';

                $('#flashMessagesUpdateBill').html(success);

                $('.progress-update-bill').hide();

                function removeFlashMsg() {
                    $('#confirmationUpdateBill'+id).replaceWith('');
                    $('#genericModal').modal('close');
                    reloadBillsTable();
                    $('#modalContent').replaceWith('<div id="modalContent"></div>');
                }
                setTimeout(removeFlashMsg, 600);

            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                $('#flashMessagesUpdateBill'+id).html(error);
                $('.progress-update-bill').hide();
            }
        })
    });
}

// Rechargement des informations lié à la carte de cours
function reloadHorseSection() {
    var url = $('#horsesInformations').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#horsesInformations').replaceWith(data);
            initMaterialize();
        }
    })
}

// Rechargement des informations lié à la carte de cours
function reloadBillsTable() {
    var currentPageNb = $('#paginateBills').find('a').attr('data-current');
    if (currentPageNb === '') {
        currentPageNb = '1';
    }

    var argGet = '?page='+currentPageNb;

    var urlNewRoute = $('#paginateBills').find('a').attr('href');

    var newUrl = urlNewRoute+argGet;
    $.ajax({
        type: 'GET',
        url: newUrl,
        success: function (data) {
            $('#table-bills').replaceWith(data);
        }
    })
}

// Rechargement du formulaire de ajout d'un cavalier
function reloadUpdateCourseCardForm() {
    var url = $('#updateCourseCardForm').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#updateCourseCardForm').replaceWith(data);

            initMaterialize();
        }
    })
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

// Fonction de pagination des factures
function paginateBills() {
    $('body').on('click','#paginateBills a', function (e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#table-bills').replaceWith(data);
            }, error: function () {
            }
        })
    });
}

$(document).ready(function(){
    initMaterialize();
    loadModalAddCourseCard();
    loadModalUpdateHorse();
    loadModalAddBill();
    loadModalUpdateBill();
    addCourseCard();
    paginateHistory();
    addCourseCardHistory();
    updateHorse();
    addBill();
    updateBill();
    paginateBills();
});