$(document).ready(function() {


    $(".emarsys-newsletter-signup-modal-trigger").click(function() {
        // reset the fancybox back to default state, in case it is re-entered
        var modal = findEmarsysModal();

        modal.find(".page-1").show();
        modal.find(".page-2").hide();
        modal.find(".page-2-success").hide();

        // attempt to default the country box from the siteaccess select list
        try {
            var currentSiteaccess = $(".languages-nav-current:first a").text();
            modal.find("select[name='country']").val(currentSiteaccess);
        } catch (err) {}

        // the standard fancybox approach of attaching to a <a> tag does not work. Manually trigger the fancybox.
        $.fancybox( { href: "#emarsys-newsletter-signup-modal" } );

        $.validate({
            form: "form#emarsys-newsletter-signup, form#emarsys-newsletter-signup-page-2",
            errorMessagePosition: 'inline'
        });
    });

    $("form#emarsys-newsletter-signup button.submit").click(function() {
        var form = findEmarsysNewsletterForm();
        var modal = findEmarsysModal();

        var valid = form.isValid(null, {}, true);
        if (!valid) {
            return false;
        }

        toggleEmarsysSpinner(true);

        submitEmarsysNewsletterSignup(
            form.attr("action"),
            form.find("input[name='email']").val(),
            form.find("select[name='country']").val(),
            true, // optIn
            null, // first name
            null, // last name
            function(result) { // success
                modal.find(".page-1").hide();
                modal.find(".page-2").show();
                } ,
            function(result) { // complete
                toggleEmarsysSpinner(false);
            }
        );

        return false;
    });

    $("form#emarsys-newsletter-signup-page-2 .demographic-submit").click(function () {
        var page1Form = findEmarsysNewsletterForm();
        var page2Form = findEmarsysNewsletterFormPage2();
        var modal = findEmarsysModal();

        var email = page1Form.find("input[name='email']").val();
        page2Form.find("input[name='email']").val(email);

        toggleEmarsysSpinner(true);

        $.ajax({
            method: 'post',
            url: page2Form.attr('action'),
            data: page2Form.serialize(),
            success: function() {

            },
            complete: function() {
                toggleEmarsysSpinner(false);

                modal.find(".page-2").hide();
                modal.find(".page-2-success").show();
            }
        });

        return false;
    });


    function toggleEmarsysSpinner(show) {
        $(".emarsys-spinner").toggle(show);
    }

    function findEmarsysModal() {
        return $("#emarsys-newsletter-signup-modal");
    }

    function findEmarsysNewsletterForm() {
        return $("form#emarsys-newsletter-signup");
    }

    function findEmarsysNewsletterFormPage2() {
        return $("form#emarsys-newsletter-signup-page-2");
    }


});

function submitEmarsysNewsletterSignup(url, email, country, optIn,  firstName, lastName, success, complete) {

    var rawData = {
        'email': email,
        'country': country,
        'opt_in': optIn,
        'first_name': firstName,
        'last_name': lastName
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
