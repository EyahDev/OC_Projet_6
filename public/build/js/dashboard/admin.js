// Fonction pour le chargement des select (Materialize)
function materializeSelect() {
    $('select').material_select();
}

// Fonction de pagination des utilisateurs
function paginateUsers() {
    $('body').on('click','#paginateUsers a', function (e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#table-users').replaceWith(data);

                trLink();
            }, error: function () {
            }
        })
    });
}

// Fonction de pagination des utilisateurs
function paginateHorses() {
    $('body').on('click','#paginateHorses a', function (e) {
        e.preventDefault();
        var $a = $(this);
        var url = $a.attr('href');

        $.ajax({
            type: 'GET',
            url: url,
            success: function (data) {
                $('#table-horses').replaceWith(data);

                trLink();
            }, error: function () {
            }
        })
    });
}

// Liens sur chaque TR
function trLink() {
    $('#usersTR').find('tr').click(function(){
        window.location = $(this).data('href');
        return false;
    });
}

function reloadHorsemanTable() {
    var currentPageNb = $('#paginateUsers').find('a').attr('data-current');
    if (currentPageNb === '') {
        currentPageNb = '1';
    }

    var argGet = '?page='+currentPageNb;

    var urlNewRoute = $('#paginateUsers').find('a').attr('href');

    var newUrl = urlNewRoute+argGet;
    $.ajax({
        type: 'GET',
        url: newUrl,
        success: function (data) {
            $('#table-users').replaceWith(data);
        }
    })
}

// Rechargement du tableau des chevaux
function reloadHorseTable() {
    var currentPageNb = $('#paginateHorses').find('a').attr('data-current');
    if (currentPageNb === '') {
        currentPageNb = '1';
    }

    var argGet = '?page='+currentPageNb;

    var urlNewRoute = $('#paginateHorses').find('a').attr('href');

    var newUrl = urlNewRoute+argGet;
    $.ajax({
        type: 'GET',
        url: newUrl,
        success: function (data) {
            $('#table-horses').replaceWith(data);
        }
    })
}

// Rechargement du formulaire de ajout d'un cavalier
function reloadHorsemanForm() {
    var url = $('#horsemanForm').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#horsemanForm').replaceWith(data);

            materializeSelect();
        }
    })
}

function reloadHorseForm() {
    var url = $('#horseForm').attr('data-url');
    $.ajax({
        type: 'GET',
        url: url,
        success: function (data) {
            $('#horseForm').replaceWith(data);

            materializeSelect();
        }
    })
}

// Soumission du formulaire d'ajout d'un cavalier
function addHorseman() {
    $('body').on('submit', 'form[name="add_horseman"]', function (e) {
        e.preventDefault();

        $('.progress-horseman').show();

        var $form = $(this);

        var url = $('#add_horseman_submit').attr('data-url');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationHorseman">' + data + '</div>';

                $('#flashMessagesHorseman').html(success);

                $('.progress-horseman').hide();

                function removeFlashMsg() {
                    $('#confirmationHorseman').replaceWith('');
                }
                setTimeout(removeFlashMsg, 5000);

                reloadHorsemanForm();
                reloadHorsemanTable();
                reloadHorseForm();
            },
            error: function (jqxhr) {
                // Construction du html pour le message flash
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';
                // ajoute le message flash dans la div dédiée
                $('#flashMessagesHorseman').html(error);

                // Retrait de la barre de chargement
                $('.progress-horseman').hide();
            }
        })
    });
}

// Soumission du formulaire d'ajout d'un cheval
function addHorse() {
    $('body').on('submit', 'form[name="add_horse"]', function (e) {
        e.preventDefault();
        $('.progress-horse').show();
        var $form = $(this);
        var url = $('#add_horse_submit').attr('data-url');

        $.ajax({
            type: 'POST',
            url: url,
            data: $form.serialize(),
            success: function (data) {
                var success = '<div class="card-panel green accent-4" id="confirmationHorse">' + data + '</div>';

                $('#flashMessagesHorse').html(success);

                $('.progress-horse').hide();

                function removeFlashMsg() {
                    $('#confirmationHorse').replaceWith('');
                }
                setTimeout(removeFlashMsg, 5000);

                reloadHorseForm();
                reloadHorseTable();
            },
            error: function (jqxhr) {
                var error = '<div class="card-panel deep-orange accent-4">' + jqxhr.responseText + '</div>';

                $('#flashMessages').html(error);
                $('.progress-horse').hide();
            }
        })
    });
}

$(document).ready(function(){
    // Initialisation des inputs select
    materializeSelect();

    // Liens des TR
    trLink();

    // Pagination des utilisateurs
    paginateUsers();

    // Pagination des chevaux
    paginateHorses();

    // Ajout d'un cavalier
    addHorseman();

    // Ajout d'un cheval
    addHorse();
});
