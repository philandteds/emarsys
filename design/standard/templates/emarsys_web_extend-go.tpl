<script type="text/javascript">
{if is_unset($live_hostname)}
    {def $live_hostname = ''}
{/if}
{if and( $live_hostname|ne(''), ezini( 'SiteSettings', 'SiteURL', 'site.ini' )|begins_with($live_hostname)|not )} ScarabQueue.push(['testMode']);{/if}
if (ScarabQueue.length > 0){ldelim}
    ScarabQueue.push(['go']);
{rdelim}
</script>
