<script type="text/javascript">
{if is_unset($live_hostname)}
    {def $live_hostname = ''}
{/if}
{if and( $live_hostname|ne(''), ezini( 'SiteSettings', 'SiteURL', 'site.ini' )|begins_with($live_hostname)|not )} ScarabQueue.push(['testMode']);{/if}
{literal}
head(function(){
    function allGo(){
        if (ScarabQueue.length > 0){
            ScarabQueue.push(['go']);
        }
    }
    Queue.addTask(allGo,1000);
});
</script>
