$(document).ready(function () {
    let trigger = $('.hamburger'),
        overlay = $('.overlay'),
        isClosed = false;

    trigger.click(function () {
        hamburger_cross();
    });

    function hamburger_cross() {

        if (isClosed === true) {
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
        let new_url = url.toString();
        window.location.replace(new_url);
    });

    $(document).on('click', '.delete', function() {
        $('#error-message').text('').hide();
        let id = $(this).data('id');
        $.ajax({
            url: '/movies/delete',
            type: 'POST',
            data:{
                id: id
            },
            success: function(data) {
                console.log(data);
                let result = JSON.parse(data);
                console.log(result);
                if (result.error) {
                    $('#error-message').text(result.error).show();
                }
                if(result.success){
                    $('#error-message').text('').hide();
                    $('#movie-'+id).remove();
                }
            },
            error: function (error) {
                console.log(error);
            }
        });

    });

    /** add movie */
    $('#add').submit(function(e) {
        e.preventDefault();

        $('#error-message').text('').hide();
        let $form = $(this);

        let $inputs = $form.find("input");

        let serializedData = $form.serialize();

        console.log(serializedData);
        let request = $.ajax({
            url: "/movies/save",
            type: "post",
            data: serializedData
        });

        request.done(function (response){
            console.log(response);
            let result = JSON.parse(response);
            if (result.error) {
                $('#error-message').text(result.error).show();
            }
        });

        request.fail(function (jqXHR, textStatus, errorThrown){
            console.error(
                "The following error occurred: " + textStatus, errorThrown
            );
        });

        request.always(function () {
            $inputs.prop("disabled", false);
        });
    });

});