{* modal popup that allows for a newsletter signup. Uses fancybox for the modal and bootstrap classes for the responsive layout. *}

{* TODO remove inline styling *}

{def $countries = ezini('CountrySettings','Countries', 'content.ini' )}

<div id="emarsys-newsletter-signup-modal" tabindex="-1" role="dialog" aria-labelledby="emarsys-modal-signup-title" style="padding:2rem;display:none;">

    <form id="emarsys-newsletter-signup" method="post" action={'emarsys/signup'|ezurl}>

        <div class="row form-group">
            <div class="col-xs-12">
                <h4 class="modal-title" id="emarsys-modal-signup-title">{'Sign up for our newsletter'|i18n}</h4>
            </div>
        </div>

        <div class="modal-body">
            <div class="row form-group">
                <div class="col-xs-4">Email <span class="required">*</span></div>
                <div class="col-xs-8"><input type="email" name="email" required class="form-control"/></div>
            </div>
            <div class="row form-group">
                <div class="col-xs-4">Country <span class="required">*</span></div>
                <div class="col-xs-8">
                    <select name="country" class="form-control">
                        <option value=""></option>

                        {foreach $countries as $country}
                            <option value="{$country|wash(xhtml)}">{$country|wash(xhtml)}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <div class="row">
                <div class="col-xs-8 col-xs-push-4">
                    <button type="button" class="btn btn-primary">{'Subscribe'|i18n}</button>
                    <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="spinner" style="display:none;"/>
                    <span class="subscribe-successful" style="display:none;"><span class="glyphicon glyphicon-ok"></span> {'Thank you for subscribing!'|i8n()}</span>
                </div>
            </div>
        </div>

    </form>
</div>

{undef $countries}