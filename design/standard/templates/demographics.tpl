{def $consumer_profile_class=fetch('content', 'class', hash('class_id', 'consumer_profile'))}

<div class="container">
<div class="reg_wrapper">
<form method="POST" class=" registration" action="{'emarsys/demographics'|ezurl('no')}">
	<h2>A bit about you...</h2>

    <h4>This is a placeholder page</h4>

    <div>
        <div>
            <label>About me</label>
        </div>
        {*<label>{$fields.about_me.name}</label>*}

        {foreach $consumer_profile_class.data_map.about_me.content.options as $option}
            <label><input type="radio" value="{$option.id}" name="about_me"> {$option.name|wash(xhtml)}</label><br/>
        {/foreach}

    </div>

    <div>
        {*<label>{$fields.children_under_5.name}</label>*}
        <label>How many children under 5 do you have?</label>
        <select name="children_under_5">
            {for 0 to 10 as $c}
                <option value="{$c}" {if $data.children_under_5|eq( $c )}selected="selected"{/if}>{$c}</option>
            {/for}
        </select>
    </div>

    <input name="email" type="hidden" value="{$email|wash}"/>
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
