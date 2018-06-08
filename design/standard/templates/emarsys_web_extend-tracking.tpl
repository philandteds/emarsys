{def 
    $merchantID = ezini('WebExtend','MerchantID','emarsys.ini')
    $locale = ezini('RegionalSettings','ContentObjectLocale')
    $locale_ini = concat( $locale, '.ini' )
    $locale_map = ezini('EmarsysAPI','LocaleMappings','emarsys.ini')
}
{if is_set($locale_map[$locale])}
    {def $e_locale = $locale_map[$locale]}
{else}
    {def $e_locale = ezini('HTTP','ContentLanguage', $locale_ini, 'share/locale',true())|explode('-')|implode('_')}
{/if}

{set-block variable=$breadcrumbs}
    {for 2 to $module_result.path|count|dec as $i}{$module_result.path[$i].text|wash}{delimiter} > {/delimiter}{/for}
{/set-block}
<script type="text/javascript">
var ScarabQueue = ScarabQueue || [];
(function(id) {ldelim}
  if (document.getElementById(id)) return;
  var js = document.createElement('script'); js.id = id;
  js.src = '//cdn.scarabresearch.com/js/{$merchantID|wash}/scarab-v2.js';
  var fs = document.getElementsByTagName('script')[0];
  fs.parentNode.insertBefore(js, fs);
{rdelim})('scarab-js-api');
var e_category = "{$breadcrumbs|trim()}";
ScarabQueue.push(['tag', '{$e_locale|wash}']);
</script>

