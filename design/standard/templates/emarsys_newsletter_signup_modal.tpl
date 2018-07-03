 {* modal popup that allows for a newsletter signup. Uses fancybox for the modal and bootstrap classes for the responsive layout. *}

{literal}
<style>
    #emarsys-newsletter-signup-modal .has-error label, label.has-error {
        color: red;
    }
</style>
{/literal}

{def $countries = ezini('CountrySettings','Countries', 'content.ini' )}
{def $emarsysContent = ezini('EmarsysContentSettings', 'emarsys-content', 'emarsys.ini')}


<div id="emarsys-newsletter-signup-modal" tabindex="-1" role="dialog" style="display:none;">
    <div class="emarsys-header">
    </div>
    {* page one of the dialog *}
    <form id="emarsys-newsletter-signup" method="post" action={'emarsys/signup'|ezurl}  class="page-1">
        <div class="emarsys-form-wrapper">
            <div class="emarsys-form-wrapper--inner">
                <div class="">
                    <!-- <h4>{'join the family!'|i18n('extension/emarsys')}</h4> -->
                    <h5>{'you’ll get the latest news &amp; exclusive promotions straight to your inbox.'|i18n('extension/emarsys')}</h5>
                </div>
                <div class="field-holder"> {* groups the fields into a unit. Hidden by JS on successful submission. *}
                    <div class=" ">  
                        <input type="email" name="email" placeholder="{'Email'|i18n('extension/emarsys')}" required class="form-control" data-validation="email" data-validation-error-msg="{'Please enter your email address'|i18n('extension/emarsys')}"/>
                    </div>
                    <div class="">
                        <input type="text" name="first_name" placeholder="{'First Name'|i18n('extension/emarsys')}" required class="form-control" data-validation="required" data-validation-error-msg="{'Please enter your first name'|i18n('extension/emarsys')}"/>
                    </div>
                    <div class="">
                        <select name="country" class="form-control" data-validation="required">
                            <option value="Select a country" disabled select="selected">Select a country</option>
                            {foreach $countries as $country}
                                <option value="{$country|wash(xhtml)}">{$country|wash(xhtml)}</option>
                            {/foreach}
                        </select>
                    </div>
                    <div class="">
                        <input id="opt_in" name="opt_in" type="checkbox" required data-validation="required" data-validation-error-msg="{'To sign up the newsletter, you must agree to receive emails'|i18n('extension/emarsys')}">
                        <label for="opt_in">{sign me up for the latest news! (you can unsubscribe at any time). see our} <a href="../Support/Privacy-Policy" class="emarsys-popup-link">Privacy Policy</a> for more details</label>
                    </div>
                </div>
                <div class="emarsys-form-footer">
                    <button type="submit" class="btn btn-big submit">{'submit'|i18n('extension/emarsys')}</button>
                    <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;"/>
                </div>
            </div>
        </div>
    </form>

    {* Demographics page *}
    <form id="emarsys-newsletter-signup-page-2" class="page-2" method="post" action={'emarsys/demographics'|ezurl}>

        <div class="emarsys-form-wrapper">
            <div class="emarsys-form-wrapper--inner">
                <div class="">
                    <h4>{'welcome to the family!'|i18n('extension/emarsys')}</h4>
                    <h5>{'so we can send some information that\'s actually useful to you, it would really help to know a little about you and your family'|i18n('extension/emarsys')}</h5>
                </div>
                <div class="field-holder"> {* groups the fields into a unit. Hidden by JS on successful submission. *}
                   
                    <div class="">
                        <input id="expecting" name="i_am_expecting_my_first_child" type="checkbox" value="1">
                        <label for="expecting">I am expecting my first child</label>
                    </div>
                    <div class="">
                        <input id="first_child" name="i_have_my_first_child" type="checkbox" value="1">
                        <label for="first_child">I have my first child</label>
                    </div>
                    <div class="">
                        <input id="next_child" name="i_am_expecting_my_next_child" type="checkbox" value="1">
                        <label for="next_child">I am expecting my next child</label>
                    </div>
                    <div class="">
                        <input id="multi_child" name="i_have_more_than_one_child" type="checkbox" value="1">
                        <label for="multi_child">I have more than one child</label>
                    </div>
                    <div class="">
                        <input id="on_behalf" name="i_am_shopping_for_someone_else" type="checkbox" value="1">
                        <label for="on_behalf">I'm shopping for someone else</label>
                    </div>
                    <div class="">
                        <input id="other" name="none_of_the_above" type="checkbox" value="1">
                        <label for="other">other</label>
                    </div>
                </div>
                <div class="emarsys-form-footer">
                    <button type="submit" class="btn btn-big submit demographic-submit">{'update'|i18n('extension/emarsys')}</button>
                    <img src={"/icons/spiffygif_24x24.gif"|ezimage} alt="" class="emarsys-spinner" style="display:none;" />
                    <button type="submit" class="btn btn--decline demographic-submit">{'No thanks x'|i18n('extension/emarsys')}</button>
                </div>
            </div>
        </div>

       
        <input name="email" type="hidden" value=""/>
    </form>

    {* Thank you page *}
    <div class="page-2-success">
        <h4>{'Thanks for signing up'|i18n('extension/emarsys')}</h4>
        <h5 class="text-center">{'Welcome to the family!'|i8n('extension/emarsys')}</h5>
    </div>


</div>

{undef $countries}