{def $consumer_profile_class=fetch('content', 'class', hash('class_id', 'consumer_profile'))}

<div class="row form-group">
     <div class="col-xs-12">
         {foreach $consumer_profile_class.data_map.about_me.content.options as $option}
             <label><input type="radio" value="{$option.id}" name="about_me"> {$option.name|wash(xhtml)}</label><br/>
         {/foreach}
     </div>
</div>

{undef $consumer_profile}

