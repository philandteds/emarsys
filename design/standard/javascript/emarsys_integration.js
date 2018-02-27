$(document).ready(function() {


    $(".emarsys-newsletter-signup-modal-trigger").click(function() {
        // the standard fancybox approach of attaching to a <a> tag does not work. Manually trigger the fancybox.
        $.fancybox( { href: "#emarsys-newsletter-signup-modal" } );
    });

    $("form#emarsys-newsletter-signup button").click(function() {
        var form = findEmarsysNewsletterForm();

        toggleEmarsysSpinner(true);

        submitEmarsysNewsletterSignup(
            form.attr("action"),
            form.find("input[name='email']").val(),
            form.find("select[name='country']").val(),
            true, // optIn
            function(result) { // success
                form.find("button").hide();
                form.find(".subscribe-successful").show();
                } ,
            function(result) { // complete
                toggleEmarsysSpinner(false);
            }
        );

        return false;
    });

    function toggleEmarsysSpinner(show) {
        var form = findEmarsysNewsletterForm();
        form.find(".spinner").toggle(show);
    }


    function findEmarsysNewsletterForm() {
        return $("form#emarsys-newsletter-signup");
    }

});

function submitEmarsysNewsletterSignup(url, email, country, optIn,  success, complete) {

    debugger;

    var rawData = {
        'email': email,
        'country': country,
        'opt_in': optIn
    };

    var json = JSON.stringify(rawData);

    $.ajax({
        method: 'post',
        url: url,
        data: json,
        success: success,
        complete: complete
    });
}
