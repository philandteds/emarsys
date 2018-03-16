{* modal popup that allows for a newsletter signup. Uses fancybox for the modal and bootstrap classes for the responsive layout. *}

{* TODO style this dialog *}
{literal}
<style>
    #emarsys-newsletter-signup-modal .help-block.form-error {
        display: none;
    }
</style>
{/literal}

{def $countries = ezini('CountrySettings','Countries', 'content.ini' )}

<div id="emarsys-newsletter-signup-modal" tabindex="-1" role="dialog" style="padding:2rem;display:none;">

    {* page one of the dialog *}
    <form id="emarsys-newsletter-signup" method="post" action={'emarsys/signup'|ezurl}  class="page-1">

        <div class="row form-group">
            <div class="col-xs-12">
                <h4>{'Sign up for our newsletter'|i18n}</h4>
            </div>
        </div>

        <div class="field-holder"> {* groups the fields into a unit. Hidden by JS on successful submission. *}
            <div class="row form-group">
                <div class="col-xs-4">Email <span class="required">*</span></div>
                <div class="col-xs-8">
                    <input type="email" name="email" required class="form-control" data-validation="required" data-validation-error-msg="{'Please enter your email address'|i18n('extension/pt')}"/>
                </div>
            </div>
            <div class="row form-group">
                <div class="col-xs-4">Country <span class="required">*</span></div>
                <div class="col-xs-8">
                    <select name="country" class="form-control" data-validation="required">
                        <option value=""></option>

                        {foreach $countries as $country}
                            <option value="{$country|wash(xhtml)}">{$country|wash(xhtml)}</option>
                        {/foreach}
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-8 col-xs-push-4">
                <button type="submit" class="btn btn-primary submit">{'Subscribe'|i18n}</button>
                <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;"/>
            </div>
        </div>
    </form>

    {* Demographics page *}
    <form id="emarsys-newsletter-signup-page-2" class="page-2" method="post" action={'emarsys/demographics'|ezurl}>

        <div class="row">
            <div class="col-xs-12">
                <h2>A little more about me...</h2>
            </div>
        </div>

        {include uri="design:demographics.tpl"}

        <div class="row form-group">
            <div class="col-xs-12">
                <input name="SubmitButton" type="submit" class="demographic-submit btn" value="Submit"/>
                <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;"/>
            </div>
        </div>

        <input name="email" type="hidden" value=""/>
    </form>

    {* Thank you page *}
    <div class="page-2-success">

        <div class="row form-group">
            <div class="col-xs-12">
                <h4>{'Thanks for signing up'|i18n}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                <p>{'Welcome to the family!'|i8n}</p>
            </div>
        </div>
    </div>


</div>

{undef $countries}