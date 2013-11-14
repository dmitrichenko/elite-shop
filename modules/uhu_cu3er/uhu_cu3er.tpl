{if $page_name == 'index'}
<!-- CU3ER content JavaScript part starts here   -->
<script type="text/javascript" src="{$module_dir}swfobject.js"></script>
<!--/{literal}-->
<script type="text/javascript">
		var flashvars = {};
		flashvars.xml = "./modules/uhu_cu3er/uhu_cu3er.xml";
		flashvars.font = "./modules/uhu_cu3er/test/font.swf";
		var attributes = {};
		attributes.wmode = "transparent";
		attributes.id = "slider";
		swfobject.embedSWF("./modules/uhu_cu3er/cu3er.swf", "cu3er-container", "924", "360", "8", "./modules/uhu_cu3er/expressInstall.swf", flashvars, attributes);
</script>
<!--/{/literal}-->
<!-- CU3ER content JavaScript part ends here   -->
<!-- CU3ER content HTML part starts here   -->
<div id="cu3er-container">
    <!-- modify this content to provide users without Flash or enabled Javascript with alternative content information -->
    <p>Click to get Flash Player<br /><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
    <p>or try to enable JavaScript and reload the page
    </p>
</div>
<!-- CU3ER content HTML part ends here   -->
{/if}