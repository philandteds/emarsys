$(document).ready(function() {

    function toggleEmarsysSpinner(show) {
        $(".emarsys-spinner").toggle(show);
    }

    function findEmarsysModal() {
        return $("#emarsys-newsletter-signup-modal");
    }

    function findEmarsysNewsletterForm() {
        return $("form#emarsys-newsletter-signup");
    }

    function findEmarsysLuxuryForm() {
        return $("form#emarsys-luxury-signup");
    }

    function findEmarsysNewsletterFormPage2() {
        return $("form#emarsys-newsletter-signup-page-2");
    }

    $(".emarsys-newsletter-signup-modal-trigger, a[data-emarsys]").click(function() {
        // reset the fancybox back to default state, in case it is re-entered
        var modal = findEmarsysModal();

        modal.find(".page-1").show();
        modal.find(".page-2").hide();
        modal.find(".page-2-success").hide();

        // 4otf add a post variable to the form
        var url = window.location.href;
        if (url.indexOf("subscribe_to_4otf") > 0) {
            var form = findEmarsysNewsletterForm();
            $('<input>').attr({
                type: 'hidden',
                id: 'signup_4otf',
                name: 'signup_4otf',
                value: 1
            }).appendTo(form);
        }

        // attempt to default the country box from the siteaccess select list
        try {
            var currentSiteaccess = $(".languages-nav-current:first a").text();
            modal.find("select[name='country']").val(currentSiteaccess);
            // if i18n has taken place check the option text
            if (!modal.find("select[name='country']").val()) {
                var country = currentSiteaccess.split(' ('); // blame Canada
                if (country[0]) {
                    modal.find("select option:contains(" + country[0] + ")").attr('selected', true);
                }
            }
        } catch (err) {}

        // the standard fancybox approach of attaching to a <a> tag does not work. Manually trigger the fancybox.
        $.fancybox({
            href: "#emarsys-newsletter-signup-modal",
            wrapCSS: 'emarsys',
            autoCenter: false,
            padding: 0,
            fixed: true,
            transitionIn: 'elastic',
            transitionOut: 'elastic',
            margin: 0,
            autoScale: false,
            autoDimensions: false,
            scrolling: 'hidden',
            beforeShow: function () {
                $("html").css({ 'position': 'fixed' });
                $("body").css({ 'overflow-y': 'hidden' });
            },
            afterClose: function () {
                $("html").css({ 'position': 'relative' });
                $("body").css({ 'overflow-y': 'visible' });
            },
            helpers: {
                overlay: {
                    locked: true
                }
            }
        });

        $.validate({
            form: "form#emarsys-newsletter-signup, form#emarsys-newsletter-signup-page-2",
            errorMessagePosition: 'inline',
            rules: {
                email: true
            }
        });
    });

    $("form#emarsys-newsletter-signup button.submit").click(function() {
        var form = findEmarsysNewsletterForm();
        var modal = findEmarsysModal();

        var valid = form.isValid(null, {}, true);
        if (!valid) {
            return false;
        }

        // skip the second page
        var url = window.location.href;
        if (url.indexOf("subscribe_to_newsletter") > 0) {
            modal.find(".page-2").hide();
            $("form#emarsys-newsletter-signup-page-2 .demographic-submit").click();
        }
        if (url.indexOf("subscribe_to_4otf") > 0) {
            modal.find(".page-2").hide();
            $("form#emarsys-newsletter-signup-page-2 .demographic-submit").click();
        }


        toggleEmarsysSpinner(true);

        submitEmarsysNewsletterSignup(
            form.attr("action"),
            form.find("input[name='email']").val(),
            form.find("select[name='country']").val(),
            true, // optIn
            form.find("input[name='first_name']").val(), // first name
            form.find("input[name='last_name']").val(), // last name
            form.find("input[name='signup_4otf']").val(), // 4otf
            function(result) { // success
                modal.find(".page-1").hide();
                // do not show second page to for direct link
                if (url.indexOf("subscribe_to_newsletter") > 0 || url.indexOf("subscribe_to_4otf") > 0) {
                    modal.find(".page-2").hide();
                } else {
                    modal.find(".page-2").show();
                }
            },
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

    function findEmarsysLuxuryModal() {
        return $("#emarsys-luxury-signup-modal");
    }

    $(".emarsys-luxury-signup-modal-trigger").click(function() {
        // reset the fancybox back to default state, in case it is re-entered
        var modal = findEmarsysLuxuryModal();

        modal.find(".page-1").show();
        modal.find(".page-2-success").hide();

        // attempt to default the country box from the siteaccess select list
        try {
            var currentSiteaccess = $(".languages-nav-current:first a").text();
            modal.find("select[name='country']").val(currentSiteaccess);
        } catch (err) {}

        // the standard fancybox approach of attaching to a <a> tag does not work. Manually trigger the fancybox.
        $.fancybox({
            href: "#emarsys-luxury-signup-modal",
            wrapCSS: 'emarsys',
            autoCenter: false,
            padding: 0,
            fixed: true,
            transitionIn: 'elastic',
            transitionOut: 'elastic',
            margin: 0,
            autoScale: false,
            autoDimensions: false,
            scrolling: 'hidden',
            beforeShow: function () {
                $("html").css({ 'position': 'fixed' });
                $("body").css({ 'overflow-y': 'hidden' });
            },
            afterClose: function () {
                $("html").css({ 'position': 'relative' });
                $("body").css({ 'overflow-y': 'visible' });
            },
            helpers: {
                overlay: {
                    locked: true
                }
            }
        }); 

        $.validate({
            form: "form#emarsys-luxury-signup",
            errorMessagePosition: 'inline',
            rules: {
                email: true
            }
        });
    });

    $("form#emarsys-luxury-signup button.submit").click(function(e) {
        e.preventDefault();
        var form = findEmarsysLuxuryForm();
        var modal = findEmarsysLuxuryModal();

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
            form.find("input[name='first_name']").val(), // first name
            form.find("input[name='last_name']").val(), // last name
            form.find("input[name='signup_4otf']").val(), // 4otf
            function(result) { // success
                modal.find(".page-1").hide();
                modal.find(".page-2-success").show();
            } ,
            function(result) { // complete
                toggleEmarsysSpinner(false);
             },
            null,
            null,
            null,
            null,
            null,
            null
        );

        return false;
    });



});

function submitEmarsysNewsletterSignup(url, email, country, optIn,
    firstName, lastName, signup_4otf, success, complete, expecting, first_child,
    next_child, multi_child, on_behalf, other) {

    var rawData = {
        'email': email,
        'country': country,
        'opt_in': optIn,
        'first_name': firstName,
        'last_name': lastName,
        'signup_4otf': signup_4otf
        //'luxury_collection_sign_ups': luxury_collection_sign_ups
        // 'expecting': expecting,
        // 'first_child': firstChild,
        // 'next_child': nextChild,
        // 'multi_child': multiChild,
        // 'on_behalf': onBehalf,
        // 'other': other    
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

$(window).load(function (e) {
    // load the page with the subscribe modal open
    var url = window.location.href;
    if (url.indexOf("subscribe_to_newsletter") > 0 ) {
        $("a[data-emarsys]").first().click();
    }
    if (url.indexOf("subscribe_to_4otf") > 0 ) {
        $("a[data-emarsys]").first().click();
    }
});
