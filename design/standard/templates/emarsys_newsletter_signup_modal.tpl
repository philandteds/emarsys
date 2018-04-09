{* modal popup that allows for a newsletter signup. Uses fancybox for the modal and bootstrap classes for the responsive layout. *}

{* TODO style this dialog *}
{literal}
<style>
    #emarsys-newsletter-signup-modal .help-block.form-error {
        display: none;
    }

    #emarsys-newsletter-signup-modal .has-error label, label.has-error {
        color: red;
    }
</style>
{/literal}

{def $countries = ezini('CountrySettings','Countries', 'content.ini' )}


<div id="emarsys-newsletter-signup-modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="emarsys-header">
    </div>
    {* page one of the dialog *}
    <form id="emarsys-newsletter-signup" method="post" action={'emarsys/signup'|ezurl}  class="page-1">
        <div class="emarsys-form-wrapper">
            <div class="">
                <div class="">
                    <h4>{'join the family!'|i18n('extension/pt')}</h4>
                    <p>{'sign up to receive updates about new products and promotions!'|i18n('extension/pt')}</p>
                </div>
            </div>

            <div class="field-holder"> {* groups the fields into a unit. Hidden by JS on successful submission. *}
                <div class=" ">
                    <div>
                    	<p>{'Email'|i18n('extension/pt')} <span class="required">*</span></p>
                    </div>
                    <div class="">
                        <input type="email" name="email" required class="form-control" data-validation="required" data-validation-error-msg="{'Please enter your email address'|i18n('extension/pt')}"/>
                    </div>
                </div>
                <div class=" ">
					<div>
						<p>{'First Name'|i18n('extension/pt')} <span class="required">*</span></p>
						</div>
                    <div class="">
                        <input type="text" name="first_name" required class="form-control" data-validation="required" data-validation-error-msg="{'Please enter your first name'|i18n('extension/pt')}"/>
                    </div>
                </div>

                <div class="">
					<div>
						<p>{'Country'|i18n('extension/pt')} <span class="required">*</span></p>
					</div>
                    <div class="">
                        <select name="country" class="form-control" data-validation="required">
                            <option value=""></option>

                            {foreach $countries as $country}
                                <option value="{$country|wash(xhtml)}">{$country|wash(xhtml)}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="">
                    <div class=""><label><input name="opt_in" type="checkbox" required data-validation="required" data-validation-error-msg="{'To sign up the newsletter, you must agree to receive emails'|i18n('extension/pt')}"> I agree to receive email from phil&amp;teds</label></div>
                </div>
                <div class="">
                    <div class=""><label><input name="accept_privacy_policy" type="checkbox" required data-validation="required" data-validation-error-msg="{'To sign up the newsletter, you must agree to receive emails'|i18n('extension/pt')}"> I agree to the phil&amp;teds <a href={"/Support/Privacy-Policy"|ezurl} target="_blank">Privacy Policy</a></label></div>
                </div>

            </div>

            <div class="">
                <div class="">
                    <button type="submit" class="btn btn-primary submit">{'Subscribe'|i18n('extension/pt')}</button>
                    <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;"/>
                </div>
            </div>
        </div>
    </form>

    {* Demographics page *}
    <form id="emarsys-newsletter-signup-page-2" class="page-2" method="post" action={'emarsys/demographics'|ezurl}>

        <div class="row">
            <div class="col-xs-12">
                <h2>{'A little more about me...'|i18n('extension/pt')}</h2>
            </div>
        </div>

        {include uri="design:demographics.tpl"}

        <div class="row form-group">
            <div class="col-xs-12">
                <input name="SubmitButton" type="submit" class="demographic-submit btn" value="{'Subscribe'|i18n('extension/pt')}"/>
                <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;"/>
            </div>
        </div>

        <input name="email" type="hidden" value=""/>
    </form>

    {* Thank you page *}
    <div class="page-2-success">

        <div class="row form-group">
            <div class="col-xs-12">
                <h4>{'Thanks for signing up'|i18n('extension/pt')}</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 text-center">
                <p>{'Welcome to the family!'|i8n('extension/pt')}</p>
            </div>
        </div>
    </div>


</div>

{undef $countries}