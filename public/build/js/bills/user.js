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
    paginateBills();
});