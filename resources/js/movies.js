$(document).ready(function () {
    var trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;

    trigger.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed == true) {
            overlay.hide();
            trigger.removeClass('is-open');
            trigger.addClass('is-closed');
            isClosed = false;
        } else {
            overlay.show();
            trigger.removeClass('is-closed');
            trigger.addClass('is-open');
            isClosed = true;
        }
    }

    $('[data-toggle="offcanvas"]').click(function () {
        $('#wrapper').toggleClass('toggled');
    });

    $('#pref-search').on('keypress',function(e) {
        let search = $('#pref-search');
        if(e.which === 13 && search.length) {
            let url = new URL(window.location.href);
            let search_params = url.searchParams;
            search_params.set('search', search.val());

            url.search = search_params.toString();
            let  new_url = url.toString();
            window.location.replace(new_url);
        }
    });

    $('#pref-orderby').on('change', function(){
        let val = $("#pref-orderby").val();
        let params = val.split('_');
        console.log(params);

        let url = new URL(window.location.href);
        let search_params = url.searchParams;
        search_params.delete(params[0]);
        search_params.delete(params[1]);
        search_params.set('order_by', params[0]);
        search_params.set('sort', params[1]);

        url.search = search_params.toString();
        let  new_url = url.toString();
        window.location.replace(new_url);
    });

});