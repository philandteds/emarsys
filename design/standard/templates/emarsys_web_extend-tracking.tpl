{def $merchantID = ezini('WebExtend','MerchantID','emarsys.ini')}
<script type="text/javascript">
var ScarabQueue = ScarabQueue || [];
(function(id) {ldelim}
  if (document.getElementById(id)) return;
  var js = document.createElement('script'); js.id = id;
  js.src = '//cdn.scarabresearch.com/js/{$merchantID|wash}/scarab-v2.js';
  var fs = document.getElementsByTagName('script')[0];
  fs.parentNode.insertBefore(js, fs);
{rdelim})('scarab-js-api');
</script>

