{def $consumer_profile_class=fetch('content', 'class', hash('class_id', 'consumer_profile'))}

{def $checkboxes=array(
    'i_am_expecting_my_first_child',
    'i_have_my_first_child',
    'i_am_expecting_my_next_child',
    'i_have_more_than_one_child',
    'i_am_shopping_for_someone_else',
    'none_of_the_above'
)}

{foreach $checkboxes as $checkbox_field_name}

    <input type="hidden" name="{$checkbox_field_name}" value="0"/>
    <div class="row form-group">
        <div class="col-xs-12">
            <label><input type="checkbox" value="1" name="{$checkbox_field_name}"> {$consumer_profile_class.data_map[$checkbox_field_name].name|wash(xhtml)}</label><br/>
        </div>
    </div>
{/foreach}

{undef $consumer_profile}

