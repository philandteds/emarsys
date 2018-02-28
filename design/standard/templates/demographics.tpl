{ezscript_require( array( 'jquery.datetimepicker.js', 'featherlight.js', 'product_registration.js' ) )}
{ezcss_require( array( 'jquery.datetimepicker.css' ) )}
{include uri='design:product_registration/parts/datepicker_language.tpl'}

<div class="container">
<div class="reg_wrapper">
<form method="POST" class=" registration" action="{'emarsys/demographics'|ezurl('no')}">
	<h2>Feedback (Optional)</h2>
    <div>
        <label>{$fields.children_under_5.name}</label>
        <select name="children_under_5">
            {for 0 to 10 as $c}
                <option value="{$c}" {if $data.children_under_5|eq( $c )}selected="selected"{/if}>{$c}</option>
            {/for}
        </select>
    </div>

    <div>
        <label>{$fields.about_me.name}</label>
        <select name="about_me">
            <option value="">{'-- Please select --'|i18n( 'extension/shopping' )}</option>
            <option value="I'm expecting my first child">{"I'm expecting my first child"|i18n('extension/shopping')}</option>
            <option value="I have my first child">{"I have my first child"|i18n('extension/shopping')}</option>
            <option value="I'm expecting my next child">{"I'm expecting my next child"|i18n('extension/shopping')}</option>
            <option value="I already have more than one child">{"I already have more than one child"|i18n('extension/shopping')}</option>
            <option value="I've purchased for someone else">{"I've purchased for someone else"|i18n('extension/shopping')}</option>
            <option value="None of the above">{"None of the above"|i18n('extension/shopping')}</option>
        </select>
    </div>

{*    <div>
        <label>{$fields.youngest_born_date.name}</label>
        <input type="text" name="youngest_born_date" value="{$data.youngest_born_date|wash}" placeholder="{'Date of birth'|i18n( 'extension/shopping' )}" class="calendar" />
    </div>
    <div>
        <label>{$fields.next_born_date.name}</label>
        <input type="text" name="next_born_date" value="{$data.next_born_date|wash}" placeholder="{'Date of birth'|i18n( 'extension/shopping' )}" class="calendar" />
    </div>
    <div>
        <label>{$fields.are_pregnant.name}</label>
        <input type="radio" name="are_pregnant" value="1" {if $data.are_pregnant}checked="checked"{/if}/> {'Yes'|i18n( 'extension/shopping' )}
        <input type="radio" name="are_pregnant" value="0" {if $data.are_pregnant|eq( false() )}checked="checked"{/if}/>  {'No'|i18n( 'extension/shopping' )}
    </div>
*}
    <div>
        <label>{$fields.biggest_influence.name}</label>
        <select name="biggest_influence">
            <option value="">{'-- Please select --'|i18n( 'extension/shopping' )}</option>
            {foreach $influences as $influence}
                <option value="{$influence.id}" {if $data.biggest_influence|eq( $influence.id )}selected="selected"{/if}>{$influence.name}</option>
            {/foreach}
        </select>
    </div>
    <div>
        <label>{$fields.main_features.name}</label>
        <textarea name="main_features" rows="8" cols="50">{$data.main_features|wash}</textarea>
    </div>
    <div>
        <label>{$fields.alternative.name}</label>
        <textarea name="alternative" rows="8" cols="50">{$data.alternative|wash}</textarea>
    </div>
    <div class="score">
        <label>{$fields.recommend_scroe.name}</label>
        {for 1 to 10 as $c}
            <input type="radio" name="recommend_scroe" value="{$c}"{if $data.recommend_scroe|eq( $c )} checked="checked"{/if}/> {$c}
        {/for}
    </div>
    <div>
        <label>{$fields.feedback.name}</label>
        <textarea name="feedback" rows="8" cols="50">{$data.feedback|wash}</textarea>
    </div>


    <input name="email" value="{$email|wash}"/>
    <input name="SubmitButton" type="submit" class="continue-btn" value="{'Submit'|i18n( 'extension/shopping' )}">
</form>
</div>
</div>

<script>
{literal}
head(function(){
	$.validate();
    });
{/literal}
</script>
