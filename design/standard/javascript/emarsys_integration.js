$(document).ready(function() {


    $(".emarsys-newsletter-signup-modal-trigger").click(function() {
        // the standard fancybox approach of attaching to a <a> tag does not work. Manually trigger the fancybox.
        $.fancybox( { href: "#emarsys-newsletter-signup-modal" } );
    });

    $("form#emarsys-newsletter-signup button").click(function() {
        var form = findEmarsysNewsletterForm();

        submitEmarsysNewsletterSignup(
            form.attr("action"),
            form.find("input[name='email']").val(),
            form.find("select[name='country']").val()
        );

        return false;

    });


    function submitEmarsysNewsletterSignup(url, email, country) {

        var form = findEmarsysNewsletterForm();

        var rawData = {
            'email': email,
            'country': country,
            'opt_in': true
        };

        var json = JSON.stringify(rawData);

        toggleEmarsysSpinner(true);

        $.ajax({
            method: 'post',
            url: url,
            data: json,
            success: function(result) {
                form.find("button").hide();
                form.find(".subscribe-successful").show();

                console.log("Emarsys submission success: " + result);
            },
            complete: function() {
                toggleEmarsysSpinner(false);
                console.log("Emarsys submission complete");
            }
        });
    }

    function toggleEmarsysSpinner(show) {
        var form = findEmarsysNewsletterForm();
        form.find(".spinner").toggle(show);
    }


    function findEmarsysNewsletterForm() {
        return $("form#emarsys-newsletter-signup");
    }

});

